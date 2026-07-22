<?php $__env->startSection('title', 'Warranty Overview'); ?>

<?php $__env->startSection('contents'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-4 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Product Warranties</h5>
                            <small class="text-white opacity-75"><?php echo e($products->total()); ?> total products</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 text-lg-end">
                        <form method="GET" class="d-flex gap-2 justify-content-lg-end">
                            <select name="warranty_status" class="filter-select" style="width: 120px;">
                                <option value="">All</option>
                                <option value="active" <?php echo e(request('warranty_status') === 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="expired" <?php echo e(request('warranty_status') === 'expired' ? 'selected' : ''); ?>>Expired</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-light">Filter</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th>Product Name</th>
                            <th>Serial No</th>
                            <th>Project Serial</th>
                            <th>Category</th>
                            <th style="width: 120px;">Warranty Ends</th>
                            <th style="width: 140px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $lastUrgency = null; ?>

                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $urgency = $p->urgency_level;
                            $now = \Carbon\Carbon::now();
                            $end = \Carbon\Carbon::parse($p->warranty_end);
                            $expired = $p->warranty_end && $end->isPast();
                        ?>

                        <?php if($urgency !== $lastUrgency): ?>
                        <tr>
                            <td colspan="7" class="bg-light-subtle fw-bold text-dark px-4 py-2 warranty-section-header">
                                <?php switch($urgency):
                                    case (0): ?> <i class="bi bi-exclamation-triangle text-danger me-2"></i> Expired Warranties <?php break; ?>
                                    <?php case (1): ?> <i class="bi bi-exclamation-circle text-warning me-2"></i> Expiring in 7 Days <?php break; ?>
                                    <?php case (2): ?> <i class="bi bi-clock text-info me-2"></i> Expiring in 30 Days <?php break; ?>
                                    <?php case (3): ?> <i class="bi bi-check-circle text-success me-2"></i> Active Warranties <?php break; ?>
                                    <?php case (4): ?> <i class="bi bi-dash-circle text-muted me-2"></i> No Warranty Info <?php break; ?>
                                    <?php default: ?> Unknown
                                <?php endswitch; ?>
                            </td>
                        </tr>
                        <?php $lastUrgency = $urgency; ?>
                        <?php endif; ?>

                        <tr <?php if($expired): ?> class="bg-danger-subtle" <?php endif; ?>>
                            <td class="ps-4">
                                <span class="row-number"><?php echo e($products->firstItem() + $index); ?></span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('products.show', $p->id)); ?>" class="product-name text-decoration-none">
                                    <i class="bi bi-box me-2"></i><?php echo e($p->product_name); ?>

                                </a>
                            </td>
                            <td>
                                <code class="serial-code"><?php echo e($p->serial_no ?? '—'); ?></code>
                            </td>
                            <td><span class="text-muted"><?php echo e($p->project_serial_no ?? '—'); ?></span></td>
                            <td>
                                <span class="category-badge">
                                    <i class="bi bi-tag-fill"></i>
                                    <?php echo e($p->category->category_name ?? 'N/A'); ?>

                                </span>
                            </td>
                            <td>
                                <span class="text-muted"><?php echo e($p->warranty_end ? $end->format('d M Y') : '—'); ?></span>
                            </td>
                            <td>
                                <?php if($p->warranty_end && $p->warranty_start): ?>
                                    <?php
                                        if ($expired) {
                                            $badgeClass = 'warranty-expired';
                                            $badgeIcon = 'x-circle-fill';
                                            $badgeText = 'Expired';
                                        } else {
                                            $totalDays = floor($now->diffInMinutes($end) / (60 * 24));
                                            $badgeClass = $totalDays <= 7 ? 'warranty-expired' : ($totalDays <= 30 ? 'warranty-expiring' : 'warranty-active');
                                            $badgeIcon = $totalDays <= 7 ? 'exclamation-circle-fill' : ($totalDays <= 30 ? 'exclamation-circle-fill' : 'check-circle-fill');
                                            $badgeText = "{$totalDays} days";
                                        }
                                    ?>
                                    <span class="warranty-badge <?php echo e($badgeClass); ?>">
                                        <i class="bi bi-<?php echo e($badgeIcon); ?>"></i> <?php echo e($badgeText); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="warranty-none">— No Warranty</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mt-3">No Warranty Data</h6>
                                    <p class="text-muted mb-0">Make sure products have warranty info assigned</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($products->hasPages()): ?>
            <div class="table-footer px-3">
                <?php echo e($products->links('vendor.pagination.bootstrap-5')); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\warranties\index.blade.php ENDPATH**/ ?>