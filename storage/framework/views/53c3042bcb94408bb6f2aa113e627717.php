<?php $currentStep = 5; ?>

<?php $__env->startSection('content'); ?>
    <div class="text-center py-3">
        <div style="font-size: 4rem; color: #10b981; margin-bottom: 15px;">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h3 class="mb-3" style="color: #1e293b;">Installation Complete!</h3>
        <p class="text-muted mb-4">
            Product Inventory has been installed successfully. Your license is activated and your super admin account is ready.
        </p>

        <div class="alert alert-info mb-4">
            <i class="bi bi-info-circle me-2"></i>
            You can now log in using the admin credentials you just created.
        </div>

        <a href="<?php echo e(route('login')); ?>" class="btn btn-install btn-lg">
            <i class="bi bi-box-arrow-in-right me-2"></i> Go to Login
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('install.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\install\complete.blade.php ENDPATH**/ ?>