@extends('layouts.app')

@section('title', 'Create User')

@section('contents')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="custom-card">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-plus me-2"></i>Create User</h5>
            </div>
            
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li><i class="bi bi-exclamation-circle me-1"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
                    @csrf
                    
                    <div class="row">
                        {{-- Left Column - Profile Photo --}}
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <img src="{{ asset('images/default-profile.png') }}" alt="Profile Photo" 
                                    class="rounded-circle shadow-sm" width="150" height="150" 
                                    style="object-fit: cover;" id="photoPreview">
                                <input type="file" name="profile_photo_path" class="form-control mt-3" 
                                    accept="image/*" onchange="previewImage(this, 'photoPreview')">
                                <small class="text-muted">Click to add photo (Max 2MB)</small>
                            </div>
                        </div>

                        {{-- Right Column - User Info --}}
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">User Name</label>
                                    <input type="text" name="name" class="form-control" 
                                        placeholder="Enter user name" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" 
                                        placeholder="Enter email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" name="mobile" class="form-control" 
                                        placeholder="Enter mobile number" value="{{ old('mobile') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Permission</label>
                                    <select name="permission" class="form-select" required>
                                        <option value="" disabled {{ old('permission') ? '' : 'selected' }}>Select role</option>
                                        <option value="1" {{ old('permission') == 1 ? 'selected' : '' }}>Admin</option>
                                        <option value="2" {{ old('permission') == 2 ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Designation</label>
                                    <input type="text" name="designation" class="form-control" 
                                        placeholder="Enter designation" value="{{ old('designation') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" id="newPassword" class="form-control" 
                                        placeholder="Enter password" autocomplete="off" required>
                                    <div class="mt-2">
                                        <div class="progress" style="height: 8px;">
                                            <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <small class="text-muted mt-1 d-block">Password Strength: <span id="strengthText">None</span></small>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">About</label>
                                <textarea name="about" class="form-control" rows="2" placeholder="Enter about info">{{ old('about') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2" placeholder="Enter address">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 password-requirements">
                        <strong>Password Requirements:</strong>
                        <ul class="mb-0 small">
                            <li id="req-length"><i class="bi bi-circle me-1"></i> At least 8 characters</li>
                            <li id="req-upper"><i class="bi bi-circle me-1"></i> At least 1 uppercase letter (A-Z)</li>
                            <li id="req-lower"><i class="bi bi-circle me-1"></i> At least 1 lowercase letter (a-z)</li>
                            <li id="req-number"><i class="bi bi-circle me-1"></i> At least 1 number (0-9)</li>
                            <li id="req-special"><i class="bi bi-circle me-1"></i> At least 1 special character (!@#$%^&*)</li>
                        </ul>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Create User
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
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('newPassword').addEventListener('input', function() {
    const password = this.value;
    const bar = document.getElementById('passwordStrengthBar');
    const text = document.getElementById('strengthText');
    
    let strength = 0;
    let requirements = {
        length: password.length >= 8,
        upper: /[A-Z]/.test(password),
        lower: /[a-z]/.test(password),
        number: /[0-9]/.test(password),
        special: /[!@#$%^&*]/.test(password)
    };
    
    const updateReq = (id, met) => {
        const el = document.getElementById(id);
        if (met) {
            el.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> ' + el.textContent.replace('<i class="bi bi-check-circle-fill me-1"></i> ', '').replace('<i class="bi bi-circle me-1"></i> ', '');
            el.className = 'text-success fw-bold';
        } else {
            el.innerHTML = '<i class="bi bi-circle me-1"></i> ' + el.textContent.replace('<i class="bi bi-check-circle-fill me-1"></i> ', '').replace('<i class="bi bi-circle me-1"></i> ', '');
            el.className = 'text-muted';
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
    
    if (strength === 0) {
        bar.className = 'progress-bar bg-secondary';
        text.textContent = 'None';
    } else if (strength === 1) {
        bar.className = 'progress-bar bg-danger';
        text.textContent = 'Very Weak';
    } else if (strength === 2) {
        bar.className = 'progress-bar bg-warning';
        text.textContent = 'Weak';
    } else if (strength === 3) {
        bar.className = 'progress-bar bg-info';
        text.textContent = 'Good';
    } else if (strength === 4) {
        bar.className = 'progress-bar bg-primary';
        text.textContent = 'Strong';
    } else {
        bar.className = 'progress-bar bg-success';
        text.textContent = 'Very Strong';
    }
});
</script>
@endpush
