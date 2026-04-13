@extends('layouts.app')

@section('title', 'User Details')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary text-white me-3">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">User Details</h5>
                            <small class="text-muted">View user information</small>
                        </div>
                    </div>
                    <a href="{{ route('users.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body p-4">
                <div class="row">
                    {{-- Left Column - Profile Photo --}}
                    <div class="col-md-4 text-center">
                        <div class="profile-section">
                            <img src="{{ $user->profile_photo_url }}" alt="Profile Photo" 
                                class="profile-image rounded-circle shadow-sm">
                            <div class="mt-3">
                                <span class="badge bg-primary">{{ $user->role_label }}</span>
                                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column - User Info --}}
                    <div class="col-md-8">
                        <div class="detail-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <div class="section-icon bg-primary-subtle text-primary me-3">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark">Basic Information</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <span class="detail-label">Full Name</span>
                                        <span class="detail-value">{{ $user->name }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <span class="detail-label">Email Address</span>
                                        <span class="detail-value">
                                            {{ $user->email }}
                                            @if($user->hasVerifiedEmail())
                                                <span class="badge bg-success ms-2">Verified</span>
                                            @else
                                                <span class="badge bg-warning text-dark ms-2">Unverified</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <div class="section-icon bg-info-subtle text-info me-3">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark">Contact Information</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <span class="detail-label">Mobile Number</span>
                                        <span class="detail-value">{!! $user->formatted_mobile !!}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <span class="detail-label">Designation</span>
                                        <span class="detail-value">{!! $user->designation_display !!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <div class="section-icon bg-success-subtle text-success me-3">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark">Additional Details</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="detail-card">
                                        <span class="detail-label">About</span>
                                        <span class="detail-value">{{ $user->about ?? '—' }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="detail-card">
                                        <span class="detail-label">Address</span>
                                        <span class="detail-value">{{ $user->address ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <div class="section-icon bg-warning-subtle text-warning me-3">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark">Account Information</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <span class="detail-label">User ID</span>
                                        <span class="detail-value">#{{ $user->id }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <span class="detail-label">Account Status</span>
                                        <span class="detail-value">
                                            <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <span class="detail-label">Created At</span>
                                        <span class="detail-value">{{ $user->created_at->format('d M Y, h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <span class="detail-label">Last Updated</span>
                                        <span class="detail-value">{{ $user->updated_at->format('d M Y, h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-end pt-3 border-top">
                    <a href="{{ route('users.index') }}" class="btn btn-light me-2">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                    @if(auth()->id() === $user->id || auth()->user()->permission <= 1)
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection