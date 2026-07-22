<?php $__env->startSection('title', 'Activity Log'); ?>

<?php $__env->startSection('contents'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Activity Log</h5>
                            <small class="text-white opacity-75"><?php echo e($logs->total()); ?> total activities</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <form method="GET" action="<?php echo e(route('activity.logs')); ?>" class="d-flex gap-2 justify-content-lg-end">
                            <select name="model" class="filter-select" style="width: 150px;" onchange="this.form.submit()">
                                <option value="">All Actions</option>
                                <option value="login" <?php echo e(request('model') === 'login' ? 'selected' : ''); ?>>Login</option>
                                <option value="logout" <?php echo e(request('model') === 'logout' ? 'selected' : ''); ?>>Logout</option>
                                <option value="create" <?php echo e(request('model') === 'create' ? 'selected' : ''); ?>>Create</option>
                                <option value="update" <?php echo e(request('model') === 'update' ? 'selected' : ''); ?>>Update</option>
                                <option value="delete" <?php echo e(request('model') === 'delete' ? 'selected' : ''); ?>>Delete</option>
                                <option value="restore" <?php echo e(request('model') === 'restore' ? 'selected' : ''); ?>>Restore</option>
                                <option value="Product" <?php echo e(request('model') === 'Product' ? 'selected' : ''); ?>>Product</option>
                                <option value="Category" <?php echo e(request('model') === 'Category' ? 'selected' : ''); ?>>Category</option>
                                <option value="Brand" <?php echo e(request('model') === 'Brand' ? 'selected' : ''); ?>>Brand</option>
                                <option value="Model" <?php echo e(request('model') === 'Model' ? 'selected' : ''); ?>>Model</option>
                                <option value="Maintenance" <?php echo e(request('model') === 'Maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                                <option value="User" <?php echo e(request('model') === 'User' ? 'selected' : ''); ?>>User</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th style="min-width: 180px;">User</th>
                            <th style="width: 100px;">Action</th>
                            <th style="width: 100px;">Type</th>
                            <th style="min-width: 280px;">Description</th>
                            <th style="width: 140px;">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $isNoChange = $log->action === 'update' && Str::contains($log->description, 'No changes');
                            
                            $actionColors = [
                                'login' => 'warranty-active',
                                'logout' => 'warranty-expiring',
                                'create' => 'warranty-active',
                                'update' => 'role-admin',
                                'delete' => 'warranty-expired',
                                'restore' => 'status-active',
                                'status-toggle' => 'role-user',
                                'send-credentials' => 'status-active',
                                'verification-init' => 'status-active',
                            ];
                            $badgeClass = $actionColors[$log->action] ?? 'role-user';
                        ?>
                        <tr>
                            <td class="ps-4">
                                <span class="row-number"><?php echo e($index + 1); ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if($log->user): ?>
                                    <img src="<?php echo e($log->user->profile_photo_url); ?>" 
                                         alt="<?php echo e($log->user->name); ?>" 
                                         class="user-avatar me-2"
                                         style="width: 36px; height: 36px;">
                                    <div>
                                        <div class="product-name"><?php echo e($log->user->name); ?></div>
                                        <small class="product-meta"><?php echo e($log->user->email); ?></small>
                                    </div>
                                    <?php else: ?>
                                    <div class="product-avatar me-2" style="width: 36px; height: 36px; font-size: 0.9rem;">
                                        <i class="bi bi-gear"></i>
                                    </div>
                                    <div>
                                        <div class="product-name">System</div>
                                        <small class="product-meta">Automated</small>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span class="warranty-badge <?php echo e($badgeClass); ?>">
                                    <?php echo e(ucfirst($log->action)); ?>

                                </span>
                            </td>
                            <td><span class="product-meta"><?php echo e($log->model ?? '—'); ?></span></td>
                            <td class="<?php echo e($isNoChange ? 'text-muted fst-italic' : ''); ?>">
                                <?php echo \App\Helpers\StringHelper::sanitizeHtml($log->description); ?>

                            </td>
                            <td>
                                <div class="text-nowrap">
                                    <div class="product-name"><?php echo e($log->updated_at->format('d M Y')); ?></div>
                                    <small class="product-meta"><?php echo e($log->updated_at->format('h:i A')); ?></small>
                                    <div><small class="text-info"><?php echo e($log->updated_at->diffForHumans()); ?></small></div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <h6 class="fw-bold">No Activity Found</h6>
                                    <p class="mb-0">Start interacting with the system to generate logs</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($logs->hasPages()): ?>
            <div class="table-footer px-3">
                <?php echo e($logs->links('vendor.pagination.bootstrap-5')); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\activity_logs\index.blade.php ENDPATH**/ ?>