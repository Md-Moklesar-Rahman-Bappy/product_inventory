<?php $currentStep = 1; ?>

<?php $__env->startSection('content'); ?>
    <h4 class="mb-2"><i class="bi bi-gear me-2"></i>Step 1: System Requirements</h4>
    <p class="text-muted mb-4">Please verify that your server meets the minimum requirements.</p>

    <?php
        $allPassed = collect($requirements)->every(fn($r) => $r['passed']);
    ?>

    <?php $__currentLoopData = $requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="requirement-item <?php echo e($req['passed'] ? 'passed' : 'failed'); ?>">
            <div>
                <strong><?php echo e($req['name']); ?></strong>
                <br><small class="text-muted">Current: <?php echo e($req['current']); ?></small>
            </div>
            <span class="status-badge <?php echo e($req['passed'] ? 'pass' : 'fail'); ?>">
                <?php echo e($req['passed' ] ? 'Pass' : 'Fail'); ?>

            </span>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="text-center mt-4">
        <?php if($allPassed): ?>
            <a href="<?php echo e(route('install.database')); ?>" class="btn btn-install">
                Continue <i class="bi bi-arrow-right ms-2"></i>
            </a>
        <?php else: ?>
            <div class="alert alert-danger mt-3">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Please fix the failing requirements above before continuing.
            </div>
            <button class="btn btn-install" disabled>
                Cannot Continue <i class="bi bi-arrow-right ms-2"></i>
            </button>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('install.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\install\requirements.blade.php ENDPATH**/ ?>