@extends('layouts.app')

@section('title', 'User Management')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card">
            {{-- Header --}}
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i>User Management</h5>
                    @if(auth()->user()->permission === 0)
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-warning fw-bold">
                        <i class="bi bi-plus-lg me-1"></i>Add User
                    </a>
                    @endif
                </div>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>User</th>
                                <th>Designation</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th style="width: 80px;">Role</th>
                                <th style="width: 80px;">Status</th>
                                <th style="width: 80px;">Photo</th>
                                <th style="width: 120px;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                </td>
                                <td>{!! $user->designation_display !!}</td>
                                <td>{{ $user->email }}</td>
                                <td>{!! $user->formatted_mobile !!}</td>
                                <td>
                                    <span class="badge bg-info text-white">{{ $user->role_label }}</span>
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
                                        class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('users.show', $user->id) }}" 
                                            class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->permission <= 1)
                                            <a href="{{ route('users.edit', $user->id) }}" 
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger delete-btn" 
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
                                <td colspan="9" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                                        <h6 class="fw-bold text-muted mt-3">No users found</h6>
                                        @if(auth()->user()->permission === 0)
                                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm mt-2">
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
                <div class="p-3 border-top">
                    <x-pagination-block :paginator="$users" />
                </div>

                {{-- Recycle Bin --}}
                @if(auth()->user()->permission === 0 && $deletedUsers->count() > 0)
                <div class="card-body border-top bg-light py-3">
                    <h6 class="text-danger fw-bold mb-3"><i class="bi bi-trash me-1"></i>Recycle Bin</h6>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Deleted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deletedUsers as $deletedUser)
                                <tr>
                                    <td>{{ $deletedUser->name }}</td>
                                    <td>{{ $deletedUser->email }}</td>
                                    <td>{{ $deletedUser->deleted_at->format('d M Y') }}</td>
                                    <td>
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
