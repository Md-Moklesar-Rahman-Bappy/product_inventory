<?php $currentStep = 3; ?>

<?php $__env->startSection('content'); ?>
    <h4 class="mb-2"><i class="bi bi-key me-2"></i>Step 3: License Activation</h4>
    <p class="text-muted mb-4">Enter your license key to activate the software. The key will be verified with our license server.</p>

    <form method="POST" action="<?php echo e(route('install.license.activate')); ?>">
        <?php echo csrf_field(); ?>

        <?php $__errorArgs = ['license_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i><?php echo e($message); ?>

            </div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <div class="mb-4">
            <label for="license_key" class="form-label">License Key</label>
            <input type="text" name="license_key" id="license_key"
                   class="form-control form-control-lg <?php $__errorArgs = ['license_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('license_key')); ?>"
                   placeholder="XXXX-XXXX-XXXX-XXXX"
                   style="text-align:center; letter-spacing:2px; font-weight:600;"
                   required autofocus>
            <?php $__errorArgs = ['license_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <small class="text-muted d-block mt-2 text-center">
                Contact your software provider if you don't have a license key.
            </small>
        </div>

        <div class="text-center">
            <a href="<?php echo e(route('install.database')); ?>" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
            <button type="submit" class="btn btn-install">
                Activate License <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('install.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\install\license.blade.php ENDPATH**/ ?>