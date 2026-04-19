@extends('layouts.app')

@section('title', 'User Details')

@push('styles')
<style>
    .profile-upload-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
    }

    .profile-header {
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 50%, #fb7185 100%);
        padding: 24px;
        color: white;
    }

    .header-icon {
        background: rgba(255,255,255,0.2);
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .detail-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 16px;
    }

    .section-header {
        margin-bottom: 16px;
    }

    .section-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .profile-section img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }

    .role-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-right: 8px;
    }

    .role-superadmin {
        background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 100%);
        color: #78350f;
    }

    .role-admin {
        background: linear-gradient(135deg, #a5b4fc 0%, #6366f1 100%);
        color: #3730a3;
    }

    .role-user {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-active {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-inactive {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .detail-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 16px;
    }

    .section-header {
        margin-bottom: 16px;
    }

    .section-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1rem;
    }

    .detail-card {
        background: white;
        border-radius: 10px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
    }

    .detail-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 0.95rem;
        font-weight: 500;
        color: #1e293b;
    }

    .btn-edit {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border: none;
        color: white;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
    }
</style>
@endpush

@section('contents')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="profile-upload-card">
            <div class="profile-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">User Details</h4>
                            <small class="opacity-75">View user information</small>
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
                            <img src="{{ $user->profile_photo_url }}" alt="Profile Photo">
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
                            <div class="section-header d-flex align-items-center">
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
                                                <span class="badge ms-1" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #047857; border: 1px solid #a7f3d0;">Verified</span>
                                            @else
                                                <span class="badge ms-1" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #b45309; border: 1px solid #fde68a;">Unverified</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section mb-4">
                            <div class="section-header d-flex align-items-center">
                                <div class="section-icon" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0284c7;">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <h6 class="mb-0 fw-bold" style="color: #1e293b;">Contact Information</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <span class="detail-label">Mobile Number</span>
                                        <span class="detail-value">{{ $user->formatted_mobile ?? '—' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <span class="detail-label">Designation</span>
                                        <span class="detail-value">{{ $user->designation ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section mb-4">
                            <div class="section-header d-flex align-items-center">
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
                            <div class="section-header d-flex align-items-center">
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
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                    @if(auth()->id() === $user->id || auth()->user()->permission <= 1)
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-edit px-4">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection