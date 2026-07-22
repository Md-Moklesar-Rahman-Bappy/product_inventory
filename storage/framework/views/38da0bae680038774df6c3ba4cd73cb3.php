<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('contents'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">User Management</h5>
                            <small class="text-white opacity-75"><?php echo e($users->total()); ?> total users</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 text-lg-end">
                        <?php if(auth()->user()->permission === 0): ?>
                        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-add">
                            <i class="bi bi-plus-lg me-1"></i>Add User
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th>User</th>
                            <th>Designation</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th style="width: 100px;">Role</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 60px;">Photo</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 text-muted"><?php echo e($loop->iteration); ?></td>
                            <td>
                                <div class="fw-semibold"><?php echo e($user->name); ?></div>
                            </td>
                            <td><?php echo e($user->designation ?? '—'); ?></td>
                            <td><span class="text-muted"><?php echo e($user->email); ?></span></td>
                            <td>
                                <?php if($user->formatted_mobile): ?>
                                    <?php echo e($user->formatted_mobile); ?>

                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    $roleClass = match($user->role_label) {
                                        'Super Admin' => 'role-superadmin',
                                        'Admin' => 'role-admin',
                                        default => 'role-user'
                                    };
                                ?>
                                <span class="role-badge <?php echo e($roleClass); ?>">
                                    <?php echo e($user->role_label); ?>

                                </span>
                            </td>
                            <td>
                                <?php if(auth()->user()->permission === 0 && auth()->id() !== $user->id): ?>
                                    <form action="<?php echo e(route('users.toggleStatus', $user->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-sm btn-toggle <?php echo e($user->status === 'active' ? 'active' : ''); ?>" 
                                            title="<?php echo e($user->status === 'active' ? 'Deactivate' : 'Activate'); ?>">
                                            <span class="toggle-slider"></span>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <?php
                                        $statusClass = $user->status === 'active' ? 'status-active' : 'status-inactive';
                                        $statusIcon = $user->status === 'active' ? 'check-circle-fill' : 'x-circle-fill';
                                    ?>
                                    <span class="status-badge <?php echo e($statusClass); ?>">
                                        <i class="bi bi-<?php echo e($statusIcon); ?>"></i>
                                        <?php echo e(ucfirst($user->status)); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <img src="<?php echo e($user->profile_photo_url); ?>" alt="Photo" 
                                    class="user-avatar">
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('users.show', $user->id)); ?>" 
                                        class="action-btn action-btn-view" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if(auth()->user()->permission <= 1): ?>
                                        <a href="<?php echo e(route('users.edit', $user->id)); ?>" 
                                            class="action-btn action-btn-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                class="action-btn action-btn-delete delete-btn" 
                                                data-title="Delete User"
                                                data-text="Delete <?php echo e($user->name); ?>?"
                                                title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mt-3">No Users Found</h6>
                                    <p class="text-muted mb-3">Get started by adding your first user</p>
                                    <?php if(auth()->user()->permission === 0): ?>
                                        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i>Add User
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($users->hasPages()): ?>
            <div class="table-footer px-3">
                <?php echo e($users->links('vendor.pagination.bootstrap-5')); ?>

            </div>
            <?php endif; ?>

            <?php if(auth()->user()->permission === 0 && $deletedUsers->count() > 0): ?>
            <div class="recycle-bin-section">
                <div class="px-3 py-2 d-flex align-items-center">
                    <i class="bi bi-trash text-danger me-2"></i>
                    <h6 class="mb-0 text-danger fw-bold">Recycle Bin</h6>
                    <span class="badge bg-danger ms-2"><?php echo e($deletedUsers->count()); ?></span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">User</th>
                                <th>Email</th>
                                <th>Deleted</th>
                                <th class="pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $deletedUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deletedUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="ps-3"><?php echo e($deletedUser->name); ?></td>
                                <td><?php echo e($deletedUser->email); ?></td>
                                <td><?php echo e($deletedUser->deleted_at->format('d M Y')); ?></td>
                                <td class="pe-3">
                                    <form action="<?php echo e(route('users.restore', $deletedUser->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\users\index.blade.php ENDPATH**/ ?>