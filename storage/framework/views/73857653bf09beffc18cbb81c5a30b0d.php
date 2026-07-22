<?php $__env->startSection('title', 'Verify Your Email'); ?>

<?php $__env->startSection('contents'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="custom-card text-center p-4">
                <div class="card-body">
                    <i class="bi bi-envelope-check text-primary" style="font-size: 4rem;"></i>
                    <h3 class="text-primary fw-bold mt-3">Email Verification Required</h3>
                    <p class="text-muted">Please check your inbox and click the verification link to activate your account.</p>

                    <?php if(session('message')): ?>
                        <div class="alert alert-success mt-3">
                            <?php echo e(session('message')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('verification.resend')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-primary mt-3">
                            <i class="bi bi-arrow-repeat me-2"></i>Resend Verification Email
                        </button>
                    </form>

                    <p class="text-muted mt-4">Didn't receive the email? Check your spam folder or click above to resend.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\auth\verify.blade.php ENDPATH**/ ?>