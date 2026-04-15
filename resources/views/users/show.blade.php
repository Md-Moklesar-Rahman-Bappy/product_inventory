@extends('layouts.app')

@section('title', 'User Details')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section" style="background: linear-gradient(135deg, #ec4899 0%, #f43f5e 50%, #fb7185 100%);">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon" style="background: rgba(255,255,255,0.2);">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-white">User Details</h4>
                            <small class="text-white opacity-75">View user information</small>
                        </div>
                    </div>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="profile-section mb-4">
                            <img src="{{ $user->profile_photo_url }}" alt="Profile Photo" 
                                class="rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid white;">
                            <div class="mt-3">
                                <span class="role-badge role-{{ $user->role_label === 'Super Admin' ? 'superadmin' : ($user->role_label === 'Admin' ? 'admin' : 'user') }}">
                                    {{ $user->role_label }}
                                </span>
                                <span class="status-badge {{ $user->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="detail-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <div class="section-icon" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #4f46e5;">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <h6 class="mb-0 fw-bold" style="color: #1e293b;">Basic Information</h6>
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
                                                <span class="badge" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #047857; border: 1px solid #a7f3d0;">Verified</span>
                                            @else
                                                <span class="badge" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #b45309; border: 1px solid #fde68a;">Unverified</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <div class="section-icon" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0284c7;">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <h6 class="mb-0 fw-bold" style="color: #1e293b;">Contact Information</h6>
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
                                <div class="section-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #047857;">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <h6 class="mb-0 fw-bold" style="color: #1e293b;">Additional Details</h6>
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
                                <div class="section-icon" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #d97706;">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <h6 class="mb-0 fw-bold" style="color: #1e293b;">Account Information</h6>
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
                                            <span class="status-badge {{ $user->status === 'active' ? 'status-active' : 'status-inactive' }}">
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

                <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                    @if(auth()->id() === $user->id || auth()->user()->permission <= 1)
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-edit px-4">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
