@extends('layouts.app')

@section('title', 'Edit User')

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

    .profile-photo-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }

    .profile-photo-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid white;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }

    .profile-photo-placeholder i {
        font-size: 4rem;
        color: #94a3b8;
    }

    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .upload-btn-wrapper .btn {
        width: 100%;
        margin-top: 12px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border: none;
        color: white;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .upload-btn-wrapper .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
    }

    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
    }

    .form-section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-section-title i {
        color: #4f46e5;
    }

    .form-input {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 12px 16px;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }

    .form-label-custom {
        font-size: 0.85rem;
        font-weight: 500;
        color: #475569;
        margin-bottom: 6px;
    }

    .password-requirements {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 1px solid #fde68a;
        border-radius: 12px;
    }

    .req-item {
        font-size: 0.8rem;
        color: #92400e;
    }

    .req-item.met {
        color: #047857;
        font-weight: 600;
    }

    .progress {
        border-radius: 10px;
        overflow: hidden;
    }

    .btn-submit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        padding: 12px 32px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    @media (max-width: 768px) {
        .profile-photo, .profile-photo-placeholder {
            width: 120px;
            height: 120px;
        }
    }
</style>
@endpush

@section('contents')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="profile-upload-card">
            <div class="profile-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">Edit User</h4>
                        <small class="opacity-75">Update user information</small>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-4" style="border-radius: 12px;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                            <strong>Please fix the following errors:</strong>
                        </div>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="userForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <div class="profile-photo-wrapper" id="photoContainer">
                                    <img src="{{ $user->profile_photo_url }}" alt="Profile Photo" 
                                        class="profile-photo" id="photoPreview">
                                </div>
                                <div class="upload-btn-wrapper">
                                    <button class="btn" type="button">
                                        <i class="bi bi-camera me-2"></i>Change Photo
                                    </button>
                                    <input type="file" name="profile_photo_path" accept="image/*" onchange="previewImage(this)">
                                </div>
                                <small class="text-muted d-block mt-2">JPG, PNG (Max 2MB)</small>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-info text-white">{{ $user->role_label }}</span>
                                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-section-title">
                                <i class="bi bi-person-badge"></i>
                                Basic Information
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">User Name</label>
                                    <input type="text" name="name" class="form-control form-input" 
                                        placeholder="Enter user name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Email Address</label>
                                    <input type="email" name="email" class="form-control form-input" 
                                        placeholder="Enter email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Mobile Number</label>
                                    <input type="text" name="mobile" class="form-control form-input" 
                                        placeholder="Enter mobile number" value="{{ old('mobile', $user->mobile) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Role / Permission</label>
                                    <select name="permission" class="form-select form-input" required>
                                        <option value="1" {{ old('permission', $user->permission) == 1 ? 'selected' : '' }}>Admin</option>
                                        <option value="2" {{ old('permission', $user->permission) == 2 ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-section-title mt-4">
                                <i class="bi bi-briefcase"></i>
                                Work Details
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Designation</label>
                                    <input type="text" name="designation" class="form-control form-input" 
                                        placeholder="Enter designation" value="{{ old('designation', $user->designation) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Password <small class="text-muted">(leave blank to keep current)</small></label>
                                    <input type="password" name="password" id="newPassword" class="form-control form-input" 
                                        placeholder="Enter new password" autocomplete="off">
                                    <div class="mt-2">
                                        <div class="progress" style="height: 6px;">
                                            <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <small class="text-muted mt-1 d-block">Strength: <span id="strengthText" class="fw-semibold">None</span></small>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">About</label>
                                <textarea name="about" class="form-control form-input" rows="2" placeholder="Brief description about this user">{{ old('about', $user->about) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Address</label>
                                <textarea name="address" class="form-control form-input" rows="2" placeholder="Enter address">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-3 password-requirements">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-shield-lock me-2"></i>
                            <strong>Password Requirements</strong>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="mb-0 ps-3">
                                    <li class="req-item" id="req-length"><i class="bi bi-circle me-1"></i> At least 8 characters</li>
                                    <li class="req-item" id="req-upper"><i class="bi bi-circle me-1"></i> At least 1 uppercase letter (A-Z)</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="mb-0 ps-3">
                                    <li class="req-item" id="req-lower"><i class="bi bi-circle me-1"></i> At least 1 lowercase letter (a-z)</li>
                                    <li class="req-item" id="req-number"><i class="bi bi-circle me-1"></i> At least 1 number (0-9)</li>
                                    <li class="req-item" id="req-special"><i class="bi bi-circle me-1"></i> At least 1 special character (!@#$%^&*)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-submit text-white">
                            <i class="bi bi-check-lg me-1"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const container = document.getElementById('photoContainer');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            container.innerHTML = `<img src="${e.target.result}" class="profile-photo" alt="Preview">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('newPassword').addEventListener('input', function() {
    const password = this.value;
    const bar = document.getElementById('passwordStrengthBar');
    const text = document.getElementById('strengthText');
    
    let strength = 0;
    const requirements = {
        length: password.length >= 8,
        upper: /[A-Z]/.test(password),
        lower: /[a-z]/.test(password),
        number: /[0-9]/.test(password),
        special: /[!@#$%^&*]/.test(password)
    };
    
    const updateReq = (id, met) => {
        const el = document.getElementById(id);
        if (met) {
            el.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> ' + el.textContent.replace(/<i class="[^"]*"><\/i>\s*/, '');
            el.className = 'req-item met';
        } else {
            el.innerHTML = '<i class="bi bi-circle me-1"></i> ' + el.textContent.replace(/<i class="[^"]*"><\/i>\s*/, '');
            el.className = 'req-item';
        }
    };
    
    updateReq('req-length', requirements.length);
    updateReq('req-upper', requirements.upper);
    updateReq('req-lower', requirements.lower);
    updateReq('req-number', requirements.number);
    updateReq('req-special', requirements.special);
    
    if (requirements.length) strength++;
    if (requirements.upper) strength++;
    if (requirements.lower) strength++;
    if (requirements.number) strength++;
    if (requirements.special) strength++;
    
    const percentage = (strength / 5) * 100;
    bar.style.width = percentage + '%';
    
    const colors = ['bg-secondary', 'bg-danger', 'bg-warning', 'bg-info', 'bg-primary', 'bg-success'];
    const labels = ['None', 'Very Weak', 'Weak', 'Good', 'Strong', 'Very Strong'];
    
    bar.className = 'progress-bar ' + colors[strength];
    text.textContent = labels[strength];
});
</script>
@endpush
