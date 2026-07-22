<?php $__env->startSection('title', 'Maintenance Details'); ?>

<?php $__env->startSection('contents'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon" style="background: rgba(255,255,255,0.2);">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-white">Maintenance Details</h4>
                            <small class="text-white opacity-75">Record #<?php echo e($maintenance->id); ?></small>
                        </div>
                    </div>
                    <a href="<?php echo e(route('maintenance.index')); ?>" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #4f46e5;">
                            <i class="bi bi-box"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Product Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Product Name</span>
                                <span class="detail-value"><?php echo e($maintenance->product->product_name ?? 'N/A'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Serial No</span>
                                <span class="detail-value"><code class="serial-code"><?php echo e($maintenance->product->serial_no ?? 'N/A'); ?></code></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #d97706;">
                            <i class="bi bi-wrench"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Maintenance Details</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="detail-card">
                                <span class="detail-label">Issue / Description</span>
                                <span class="detail-value"><?php echo e($maintenance->description); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Start Date</span>
                                <span class="detail-value"><?php echo e($maintenance->start_time->format('d M Y')); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">End Date</span>
                                <span class="detail-value"><?php echo e($maintenance->end_time->format('d M Y')); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    <?php if(now()->between($maintenance->start_time, $maintenance->end_time)): ?>
                                        <span class="warranty-badge warranty-expiring">In Progress</span>
                                    <?php elseif(now()->lt($maintenance->start_time)): ?>
                                        <span class="warranty-badge" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0284c7; border: 1px solid #bae6fd;">Scheduled</span>
                                    <?php else: ?>
                                        <span class="warranty-badge warranty-active">Completed</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0284c7;">
                            <i class="bi bi-person"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Logged By</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">User Name</span>
                                <span class="detail-value"><?php echo e($maintenance->user->name ?? 'System'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color: #64748b;">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Record Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Created At</span>
                                <span class="detail-value"><?php echo e($maintenance->created_at->format('d M Y, h:i A')); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Last Updated</span>
                                <span class="detail-value"><?php echo e($maintenance->updated_at->format('d M Y, h:i A')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                    <a href="<?php echo e(route('maintenance.index')); ?>" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                    <?php if(auth()->user()->permission <= 1): ?>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('maintenance.edit', $maintenance->id)); ?>" class="btn btn-edit px-4">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="<?php echo e(route('maintenance.destroy', $maintenance->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-delete px-4 delete-btn"
                                data-title="Delete Record"
                                data-text="Are you sure you want to delete this maintenance record?">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\maintenance\show.blade.php ENDPATH**/ ?>