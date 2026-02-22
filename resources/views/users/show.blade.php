@extends('layouts.app')

@section('title', 'User Details')

@section('contents')
<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">

            <!-- 🌟 Page Header -->
            <div class="page-header d-flex justify-content-between align-items-center">
                <h1 class="page-title text-gradient fw-bold">
                    <i class="fa fa-user-circle me-2 text-primary"></i> User Details
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">User</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>

            <!-- 👤 User Card -->
            <div class="row mt-4">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-header bg-gradient-info text-white text-center py-4">
                            <h3 class="card-title fw-bold mb-0">
                                <i class="fa fa-id-badge me-2"></i> User Profile
                            </h3>
                        </div>
                        <div class="card-body bg-light p-5">
                            <div class="text-center mb-4">
                                <img src="{{ $user->profile_photo_url }}"
                                     alt="Profile Photo"
                                     class="rounded-circle shadow-lg border border-3 border-white"
                                     width="120" height="120" style="object-fit: cover;">
                                <h4 class="mt-3 fw-bold text-dark">{{ $user->name }}</h4>

                                <div class="mt-2">
                                    <span class="badge rounded-pill bg-info text-white px-3 py-1">
                                        {{ $user->role_label }}
                                    </span>
                                    <span class="badge rounded-pill {{ $user->deleted_at ? 'bg-danger' : 'bg-success' }} text-white px-3 py-1 ms-2">
                                        {{ $user->deleted_at ? 'Deleted' : 'Active' }}
                                    </span>
                                </div>
                            </div>

                            <!-- 📋 User Info Table -->
                            <table class="table table-bordered table-hover shadow-sm rounded">
                                <tbody>
                                    <tr>
                                        <th class="bg-light text-primary w-25">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-primary">Mobile</th>
                                        <td>{!! $user->mobile_display ?? '<span class="text-muted">—</span>' !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-primary">Designation</th>
                                        <td>{!! $user->designation_display ?? '<span class="text-muted">—</span>' !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-primary">About</th>
                                        <td>{!! $user->about ? e($user->about) : '<span class="text-muted">—</span>' !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-primary">Address</th>
                                        <td>{!! $user->address ? e($user->address) : '<span class="text-muted">—</span>' !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-primary">Created At</th>
                                        <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-primary">Updated At</th>
                                        <td>{{ $user->updated_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- 🔧 Action Buttons -->
                            <div class="text-end mt-4">
                                @if(auth()->id() === $user->id || auth()->user()->permission <= 1)
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning fw-bold me-2">
                                        <i class="fa fa-edit me-1"></i> Edit
                                    </a>
                                @endif
                                <a href="{{ route('users.index') }}" class="btn btn-secondary fw-bold">
                                    <i class="fa fa-arrow-left me-1"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END ROW -->

        </div>
    </div>
</div>
@endsection

<style>`
    .text-gradient {
    background: linear-gradient(to right, #4e73df, #1cc88a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
