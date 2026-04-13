@extends('layouts.app')

@section('title', 'User Management')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header Section --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                        <div class="icon-box bg-primary text-white">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold text-dark">User Management</h5>
                            <small class="text-muted">{{ $users->total() }} total users</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 text-lg-end">
                        @if(auth()->user()->permission === 0)
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>Add User
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" style="width: 50px;">#</th>
                                <th>User</th>
                                <th>Designation</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th style="width: 90px;">Role</th>
                                <th style="width: 90px;">Status</th>
                                <th style="width: 60px;">Photo</th>
                                <th class="text-center pe-4" style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr class="table-row">
                                <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                </td>
                                <td>{!! $user->designation_display !!}</td>
                                <td><span class="text-muted">{{ $user->email }}</span></td>
                                <td>{!! $user->formatted_mobile !!}</td>
                                <td>
                                    @php
                                        $roleColors = [
                                            'Super Admin' => 'bg-primary',
                                            'Admin' => 'bg-info',
                                            'User' => 'bg-secondary'
                                        ];
                                    @endphp
                                    <span class="badge {{ $roleColors[$user->role_label] ?? 'bg-secondary' }}">
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
                                        <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <img src="{{ $user->profile_photo_url }}" alt="Photo" 
                                        class="rounded-circle" width="36" height="36" style="object-fit: cover;">
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('users.show', $user->id) }}" 
                                            class="btn btn-sm btn-light" title="View">
                                            <i class="bi bi-eye text-info"></i>
                                        </a>
                                        @if(auth()->user()->permission <= 1)
                                            <a href="{{ route('users.edit', $user->id) }}" 
                                                class="btn btn-sm btn-light" title="Edit">
                                                <i class="bi bi-pencil text-warning"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="btn btn-sm btn-light delete-btn" 
                                                    data-title="Delete User"
                                                    data-text="Delete {{ $user->name }}?"
                                                    title="Delete">
                                                    <i class="bi bi-trash text-danger"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon bg-light text-muted">
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

                {{-- Pagination --}}
                @if($users->hasPages())
                <div class="px-3 py-3 border-top bg-light-subtle">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
                        </div>
                        {{ $users->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
                @endif

                {{-- Recycle Bin --}}
                @if(auth()->user()->permission === 0 && $deletedUsers->count() > 0)
                <div class="border-top bg-danger-subtle">
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
</div>
@endsection