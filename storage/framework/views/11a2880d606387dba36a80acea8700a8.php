<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('contents'); ?>
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="custom-card">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person me-2"></i>My Profile</h5>
            </div>
            
            <div class="card-body">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><i class="bi bi-exclamation-circle me-1"></i> <?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row">
                        
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <img src="<?php echo e(auth()->user()->profile_photo_url); ?>" alt="Profile Photo" 
                                    class="rounded-circle shadow-sm" width="150" height="150" 
                                    style="object-fit: cover;" id="photoPreview">
                                <input type="file" name="profile_photo_path" class="form-control mt-3" 
                                    accept="image/*" onchange="previewImage(this, 'photoPreview')">
                                <small class="text-muted">Click to change photo (Max 2MB)</small>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-info text-white"><?php echo e(auth()->user()->role_label); ?></span>
                                <span class="badge <?php echo e(auth()->user()->status === 'active' ? 'bg-success' : 'bg-secondary'); ?>">
                                    <?php echo e(ucfirst(auth()->user()->status)); ?>

                                </span>
                            </div>
                        </div>

                        
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" 
                                        value="<?php echo e(old('name', auth()->user()->name)); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="<?php echo e(auth()->user()->email); ?>" disabled>
                                    <?php if(!auth()->user()->hasVerifiedEmail()): ?>
                                        <small class="text-warning">Email not verified</small>
                                    <?php else: ?>
                                        <small class="text-success">Email verified</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile</label>
                                    <input type="text" name="mobile" class="form-control" 
                                        value="<?php echo e(old('mobile', auth()->user()->mobile)); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Designation</label>
                                    <input type="text" name="designation" class="form-control" 
                                        value="<?php echo e(old('designation', auth()->user()->designation)); ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">About</label>
                                <textarea name="about" class="form-control" rows="3"><?php echo e(old('about', auth()->user()->about)); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2"><?php echo e(old('address', auth()->user()->address)); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Save Profile
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                
                <h5 class="fw-bold mb-3"><i class="bi bi-key me-2"></i>Change Password</h5>
                <form action="<?php echo e(route('password.update')); ?>" method="POST" id="passwordForm">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" id="newPassword" class="form-control" required>
                            <div class="mt-2">
                                <div class="progress" style="height: 8px;">
                                    <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted mt-1 d-block">Password Strength: <span id="strengthText">None</span></small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-2 password-requirements">
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
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-key me-1"></i>Change Password
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Account Information</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="table-light" style="width: 30%;">User ID</th>
                                <td><?php echo e(auth()->user()->id); ?></td>
                            </tr>
                            <tr>
                                <th class="table-light">Email Verified</th>
                                <td>
                                    <?php if(auth()->user()->hasVerifiedEmail()): ?>
                                        <span class="badge bg-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">No</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light">Account Status</th>
                                <td>
                                    <span class="badge <?php echo e(auth()->user()->status === 'active' ? 'bg-success' : 'bg-danger'); ?>">
                                        <?php echo e(ucfirst(auth()->user()->status)); ?>

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light">Created At</th>
                                <td><?php echo e(auth()->user()->created_at->format('d M Y, h:i A')); ?></td>
                            </tr>
                            <tr>
                                <th class="table-light">Last Updated</th>
                                <td><?php echo e(auth()->user()->updated_at->format('d M Y, h:i A')); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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

// Password Strength Checker
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
    
    // Update requirement indicators
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
    
    // Calculate strength
    if (requirements.length) strength++;
    if (requirements.upper) strength++;
    if (requirements.lower) strength++;
    if (requirements.number) strength++;
    if (requirements.special) strength++;
    
    // Update progress bar
    const percentage = (strength / 5) * 100;
    bar.style.width = percentage + '%';
    
    // Update color and text
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\product_inventory_main\product_inventory\resources\views/profile.blade.php ENDPATH**/ ?>