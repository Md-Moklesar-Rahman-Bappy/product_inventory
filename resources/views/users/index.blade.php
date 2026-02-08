@extends('layouts.app')

@section('title', 'User Management')

@section('contents')
<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">
                        <i class="fa fa-users me-2 text-primary"></i> User List
                    </h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Users</li>
                    </ol>
                </div>
            </div>

            <!-- USER TABLE -->
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-gradient-info text-white d-flex justify-content-between align-items-center py-3 px-4">
                            <h3 class="mb-0 fw-bold"><i class="fa fa-list me-2"></i> User List</h3>
                            @if(auth()->user()->isSuperadmin())
                                <a href="{{ route('users.create') }}" class="btn btn-light fw-bold shadow-sm">
                                    <i class="fa fa-plus me-1"></i> Add New User
                                </a>
                            @endif
                        </div>

                        <div class="card-body bg-light p-4">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle text-center shadow-sm rounded" style="min-width: 1000px;">
                                    <thead class="bg-light text-uppercase text-primary fw-bold">
                                        <tr>
                                            <th>Sl</th>
                                            <th>User Name</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-semibold">{{ $user->name }}</td>
                                            <td>{!! $user->designation_display !!}</td>
                                            <td>{{ $user->email }}</td>
                                            {{-- <td>{!! $user->mobile_display !!}</td> --}}
                                            <td>{!! $user->formatted_mobile !!}</td>
                                            <td><span class="badge bg-info text-white">{{ $user->role_label }}</span></td>

                                            <!-- ✅ Status Column with Toggle -->
                                            <td>
                                                @if(auth()->user()->isSuperadmin() && auth()->id() !== $user->id)
                                                    <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')

                                                        <label class="custom-switch">
                                                            <input type="submit" class="switch-input" name="status"
                                                                value="{{ $user->status === 'active' ? 'deactive' : 'active' }}">
                                                            <span class="switch-slider {{ $user->status === 'active' ? 'active' : '' }}"></span>
                                                        </label>
                                                    </form>
                                                @else
                                                    <span class="badge {{ $user->status === 'active' ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                                                        {{ ucfirst($user->status) }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                <img src="{{ $user->profile_photo_url }}" alt="Profile Photo"
                                                     class="rounded shadow-sm" width="120" height="120" style="object-fit: cover;">
                                            </td>
                                            <td>
                                                <div class="action-buttons d-flex gap-1 justify-content-center">
                                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @if(auth()->user()->isSuperadmin() || auth()->user()->isAdmin())
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this user?')" title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5 text-muted">
                                                <i class="fa fa-user-slash fa-2x mb-3 text-danger"></i>
                                                <h5 class="fw-bold">No users found</h5>
                                                <p class="small">Start by adding a new user to your system.</p>
                                                @if(auth()->user()->isSuperadmin())
                                                    <a href="{{ route('users.create') }}" class="btn btn-primary fw-bold mt-2 shadow-sm">
                                                        <i class="fa fa-plus me-1"></i> Add User
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- 🗑️ Recycle Bin Section (Superadmin Only) -->
                            @if(auth()->user()->isSuperadmin() && $deletedUsers->count() > 0)
                                <div class="mt-5">
                                    <h5 class="text-danger"><i class="fa fa-trash-alt me-1"></i> Recycle Bin</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover align-middle text-center shadow-sm rounded">
                                            <thead class="bg-light text-uppercase text-danger fw-bold">
                                                <tr>
                                                    <th>User Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Deleted At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($deletedUsers as $deletedUser)
                                                <tr class="table-danger">
                                                    <td>{{ $deletedUser->name }}</td>
                                                    <td>{{ $deletedUser->email }}</td>
                                                    <td>{!! $deletedUser->mobile_display !!}</td>
                                                    <td>{{ $deletedUser->deleted_at->format('d M Y, h:i A') }}</td>
                                                    <td>
                                                        <form action="{{ route('users.restore', $deletedUser->id) }}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-sm btn-warning" title="Restore User">
                                                                <i class="fa fa-undo"></i> Restore
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
            <!-- END ROW -->

        </div>
    </div>
</div>

<style>
    .custom-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
    cursor: pointer;
}

.switch-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.switch-slider {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    border-radius: 34px;
    transition: background-color 0.3s;
}

.switch-slider::before {
    content: "";
    position: absolute;
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    border-radius: 50%;
    transition: transform 0.3s;
}

.switch-slider.active {
    background-color: #0d6efd;
}

.switch-slider.active::before {
    transform: translateX(24px);
}

.card {
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.table {
    border-radius: 0.75rem;
    overflow: hidden;
}
.table-hover tbody tr:hover {
    background-color: #f1f5f9;
}

.badge {
    border-radius: 50rem;
    font-size: 0.85rem;
    padding: 0.4em 0.8em;
}
.btn-outline-info:hover {
    background-color: #0dcaf0;
    color: white;
}

img.rounded.shadow-sm {
    transition: transform 0.3s ease;
}
img.rounded.shadow-sm:hover {
    transform: scale(1.05);
}


</style>
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
</script>
@endsection
