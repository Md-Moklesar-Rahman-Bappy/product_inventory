<?php $__env->startSection('title', 'Products in ' . $brand->brand_name); ?>

<?php $__env->startSection('contents'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-2 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Products in <?php echo e($brand->brand_name); ?></h5>
                            <small class="text-white opacity-75"><?php echo e($products->total()); ?> total items</small>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="liveSearch" placeholder="Search products..." autocomplete="off">
                            <div id="searchResults" class="search-results"></div>
                        </div>
                        <form id="searchForm" method="GET" action="<?php echo e(route('brands.products', $brand->id)); ?>" class="d-none">
                            <input type="hidden" name="search" id="searchInput">
                        </form>
                    </div>

                    <div class="col-12 col-lg-3">
                        <div class="d-flex gap-2">
                            <select name="filter" class="form-select form-select-sm filter-select" onchange="this.form.submit()">
                                <option value="">All</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 text-lg-end">
                        <?php if(auth()->user()->permission <= 1): ?>
                            <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                                <a href="<?php echo e(route('brands.index')); ?>" class="btn btn-sm btn-light">
                                    <i class="bi bi-arrow-left me-1"></i>Back
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bi bi-file-earmark-excel me-1"></i>Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo e(route('products.export.brand', $brand->id)); ?>">Export</a></li>
                                    </ul>
                                </div>
                                <a href="<?php echo e(route('products.create', ['brand_id' => $brand->id])); ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-plus-lg me-1"></i>Add
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th>Product</th>
                            <th>Serial No</th>
                            <th class="d-none d-md-table-cell">Category</th>
                            <th class="d-none d-lg-table-cell">Location</th>
                            <th class="d-none d-lg-table-cell">Price</th>
                            <th style="width: 130px;">Warranty</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4">
                                <span class="row-number"><?php echo e(($products->currentPage() - 1) * $products->perPage() + $loop->iteration); ?></span>
                            </td>

                            <td>
                                <div class="product-info">
                                    <div class="product-avatar">
                                        <i class="bi bi-box"></i>
                                    </div>
                                    <div>
                                        <div class="product-name"><?php echo e($p->product_name); ?></div>
                                        <div class="product-meta">
                                            <?php echo e($p->category->category_name ?? 'N/A'); ?> | <?php echo e($p->model->model_name ?? 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <code class="serial-code"><?php echo e($p->serial_no ?? '-'); ?></code>
                            </td>

                            <td class="d-none d-md-table-cell">
                                <span class="category-badge">
                                    <i class="bi bi-tag-fill"></i>
                                    <?php echo e($p->category->category_name ?? 'N/A'); ?>

                                </span>
                            </td>

                            <td class="d-none d-lg-table-cell">
                                <span class="location-text"><?php echo e($p->position ?? '—'); ?></span>
                            </td>

                            <td class="d-none d-lg-table-cell">
                                <span class="price-value">
                                    <span class="price-symbol">৳</span><?php echo e(number_format($p->price ?? 0, 2)); ?>

                                </span>
                            </td>

                            <td>
                                <?php if($p->warranty_end): ?>
                                    <?php
                                        $daysLeft = now()->diffInDays($p->warranty_end, false);
                                        $warrantyClass = $daysLeft < 0 ? 'warranty-expired' : ($daysLeft <= 30 ? 'warranty-expiring' : 'warranty-active');
                                        $warrantyIcon = $daysLeft < 0 ? 'x-circle-fill' : ($daysLeft <= 30 ? 'exclamation-circle-fill' : 'check-circle-fill');
                                        $warrantyText = $daysLeft < 0 ? 'Expired' : $daysLeft . ' days';
                                    ?>
                                    <span class="warranty-badge <?php echo e($warrantyClass); ?>">
                                        <i class="bi bi-<?php echo e($warrantyIcon); ?>"></i>
                                        <?php echo e($warrantyText); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="warranty-none">— No Warranty</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('products.show', $p->id)); ?>" 
                                       class="action-btn action-btn-view" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if(auth()->user()->permission <= 1): ?>
                                        <a href="<?php echo e(route('products.edit', $p->id)); ?>" 
                                           class="action-btn action-btn-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mt-3">No Products Found</h6>
                                    <p class="text-muted mb-3">Get started by adding your first product</p>
                                    <?php if(auth()->user()->permission <= 1): ?>
                                        <a href="<?php echo e(route('products.create', ['brand_id' => $brand->id])); ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i>Add Product
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($products->hasPages()): ?>
            <div class="table-footer">
                <?php echo e($products->links('vendor.pagination.bootstrap-5')); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\brands\products.blade.php ENDPATH**/ ?>