<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
</head>
<body class="bg-light">

    
    <?php if(auth()->guard()->check()): ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(route('dashboard')); ?>">Inventory System</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">
                    <?php echo e(auth()->user()->name); ?> —
                    <strong>
                        <?php echo e(match(auth()->user()->permission) {
                            0 => 'Super Admin',
                            1 => 'Admin',
                            2 => 'Editor',
                            3 => 'Viewer',
                            default => 'Guest',
                        }); ?>

                    </strong>
                </span>
                <a href="<?php echo e(route('logout')); ?>" class="btn btn-sm btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-3 col-lg-2 bg-white border-end vh-100 p-3">
                <h5 class="mb-4">Navigation</h5>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="<?php echo e(route('dashboard')); ?>" class="nav-link">Dashboard</a></li>

                    <?php if(auth()->user()->permission === 0): ?>
                        <li class="nav-item"><a href="<?php echo e(route('users.index')); ?>" class="nav-link">Manage Users</a></li>
                    <?php endif; ?>

                    <?php if(in_array(auth()->user()->permission, [0, 1])): ?>
                        <li class="nav-item"><a href="<?php echo e(route('products.index')); ?>" class="nav-link">Products</a></li>
                        <li class="nav-item"><a href="<?php echo e(route('products.create')); ?>" class="nav-link">Add Product</a></li>
                        <li class="nav-item"><a href="<?php echo e(route('activity.logs')); ?>" class="nav-link">Activity Logs</a></li>
                    <?php endif; ?>

                    <li class="nav-item"><a href="<?php echo e(route('profile')); ?>" class="nav-link">My Profile</a></li>
                </ul>
            </div>

            
            <main class="col-md-9 col-lg-10 py-4 px-5">
                <?php if(session('message')): ?>
                    <div class="alert alert-success"><?php echo e(session('message')); ?></div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('body'); ?>
            </main>
        </div>
    </div>

    
    <footer class="text-center py-3 bg-white border-top mt-auto">
        <small>&copy; <?php echo e(date('Y')); ?> Product Inventory System. All rights reserved.</small>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete confirmation
            document.querySelectorAll('.delete-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    const title = this.getAttribute('data-title') || 'Are you sure?';
                    const text = this.getAttribute('data-text') || 'This action cannot be undone.';
                    
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Form submit loading state
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.classList.contains('no-loading')) {
                        submitBtn.disabled = true;
                        const originalText = submitBtn.innerHTML;
                        submitBtn.setAttribute('data-original-text', originalText);
                        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
                        
                        // Re-enable after 10 seconds as fallback
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        }, 10000);
                    }
                });
            });
        });
    </script>

</body>
</html>
<?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\layouts\master.blade.php ENDPATH**/ ?>