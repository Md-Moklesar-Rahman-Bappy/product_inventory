@extends('layouts.app')

@section('title', 'User Management')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">User Management</h5>
                            <small class="text-white opacity-75">{{ $users->total() }} total users</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 text-lg-end">
                        @if(auth()->user()->permission === 0)
                        <a href="{{ route('users.create') }}" class="btn btn-add">
                            <i class="bi bi-plus-lg me-1"></i>Add User
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th>User</th>
                            <th>Designation</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th style="width: 100px;">Role</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 60px;">Photo</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-semibold">{{ $user->name }}</div>
                            </td>
                            <td>{{ $user->designation ?? '—' }}</td>
                            <td><span class="text-muted">{{ $user->email }}</span></td>
                            <td>{{ $user->formatted_mobile ?? '—' }}</td>
                            <td>
                                @php
                                    $roleClass = match($user->role_label) {
                                        'Super Admin' => 'role-superadmin',
                                        'Admin' => 'role-admin',
                                        default => 'role-user'
                                    };
                                @endphp
                                <span class="role-badge {{ $roleClass }}">
                                    {{ $user->role_label }}
                                </span>
                            </td>
                            <td>
                                @if(auth()->user()->permission === 0 && auth()->id() !== $user->id)
                                    <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-toggle {{ $user->status === 'active' ? 'active' : '' }}" 
                                            title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                            <span class="toggle-slider"></span>
                                        </button>
                                    </form>
                                @else
                                    @php
                                        $statusClass = $user->status === 'active' ? 'status-active' : 'status-inactive';
                                        $statusIcon = $user->status === 'active' ? 'check-circle-fill' : 'x-circle-fill';
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="bi bi-{{ $statusIcon }}"></i>
                                        {{ ucfirst($user->status) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <img src="{{ $user->profile_photo_url }}" alt="Photo" 
                                    class="user-avatar">
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('users.show', $user->id) }}" 
                                        class="action-btn action-btn-view" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(auth()->user()->permission <= 1)
                                        <a href="{{ route('users.edit', $user->id) }}" 
                                            class="action-btn action-btn-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="action-btn action-btn-delete delete-btn" 
                                                data-title="Delete User"
                                                data-text="Delete {{ $user->name }}?"
                                                title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mt-3">No Users Found</h6>
                                    <p class="text-muted mb-3">Get started by adding your first user</p>
                                    @if(auth()->user()->permission === 0)
                                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i>Add User
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
            <div class="table-footer px-3">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
            @endif

            @if(auth()->user()->permission === 0 && $deletedUsers->count() > 0)
            <div class="recycle-bin-section">
                <div class="px-3 py-2 d-flex align-items-center">
                    <i class="bi bi-trash text-danger me-2"></i>
                    <h6 class="mb-0 text-danger fw-bold">Recycle Bin</h6>
                    <span class="badge bg-danger ms-2">{{ $deletedUsers->count() }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">User</th>
                                <th>Email</th>
                                <th>Deleted</th>
                                <th class="pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deletedUsers as $deletedUser)
                            <tr>
                                <td class="ps-3">{{ $deletedUser->name }}</td>
                                <td>{{ $deletedUser->email }}</td>
                                <td>{{ $deletedUser->deleted_at->format('d M Y') }}</td>
                                <td class="pe-3">
                                    <form action="{{ route('users.restore', $deletedUser->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
