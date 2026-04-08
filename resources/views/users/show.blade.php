@extends('layouts.app')

@section('title', 'User Details')

@section('contents')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="custom-card">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person me-2"></i>User Details</h5>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    {{-- Left Column - Profile Photo --}}
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <img src="{{ $user->profile_photo_url }}" alt="Profile Photo" 
                                class="rounded-circle shadow-sm" width="150" height="150" 
                                style="object-fit: cover;">
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-info text-white">{{ $user->role_label }}</span>
                            <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Right Column - User Info --}}
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <div class="form-control-plaintext">{{ $user->name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <div class="form-control-plaintext">
                                    {{ $user->email }}
                                    @if(!$user->hasVerifiedEmail())
                                        <span class="badge bg-warning text-dark">Unverified</span>
                                    @else
                                        <span class="badge bg-success">Verified</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mobile</label>
                                <div class="form-control-plaintext">{!! $user->formatted_mobile !!}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Designation</label>
                                <div class="form-control-plaintext">{!! $user->designation_display !!}</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">About</label>
                            <div class="form-control-plaintext">{!! $user->about ? e($user->about) : '<span class="text-muted">—</span>' !!}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <div class="form-control-plaintext">{!! $user->address ? e($user->address) : '<span class="text-muted">—</span>' !!}</div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Account Info --}}
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Account Information</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="table-light" style="width: 30%;">User ID</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">Email Verified</th>
                                <td>
                                    @if($user->hasVerifiedEmail())
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-warning text-dark">No</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light">Account Status</th>
                                <td>
                                    <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light">Created At</th>
                                <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">Last Updated</th>
                                <td>{{ $user->updated_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-4">
                    @if(auth()->id() === $user->id || auth()->user()->permission <= 1)
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                    @endif
                    <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
