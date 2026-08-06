<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('contents'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-2 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Products</h5>
                            <small class="text-white opacity-75"><?php echo e($products->total()); ?> total items</small>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="liveSearch" placeholder="Search products..." autocomplete="off">
                            <div id="searchResults" class="search-results"></div>
                        </div>
                        <form id="searchForm" method="GET" action="<?php echo e(route('products.index')); ?>" class="d-none">
                            <input type="hidden" name="search" id="searchInput">
                        </form>
                    </div>

                    <div class="col-12 col-lg-3">
                        <div class="d-flex gap-2">
                            <select name="category_id" class="form-select form-select-sm filter-select" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>>
                                        <?php echo e($cat->category_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="brand_id" class="form-select form-select-sm filter-select" onchange="this.form.submit()">
                                <option value="">All Brands</option>
                                <?php $__currentLoopData = \App\Models\Brand::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($brand->id); ?>" <?php echo e(request('brand_id') == $brand->id ? 'selected' : ''); ?>>
                                        <?php echo e($brand->brand_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if(request('search')): ?>
                                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 text-lg-end">
                        <?php if(auth()->user()->permission <= 1): ?>
                            <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                                <a href="<?php echo e(route('products.sample')); ?>" class="btn btn-sm btn-light">
                                    <i class="bi bi-download me-1"></i>Sample
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bi bi-file-earmark-excel me-1"></i>Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo e(route('products.export.excel')); ?>">Excel Format</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('products.export.category')); ?>">By Category</a></li>
                                    </ul>
                                </div>
                                <a href="<?php echo e(route('products.create')); ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-plus-lg me-1"></i>Add
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if(auth()->user()->permission <= 1): ?>
            <div class="import-section">
                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                        <strong>Import Error:</strong> <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('import_stats')): ?>
                    <?php
                        $stats = session('import_stats');
                        $totalProcessed = $stats['created'] + $stats['updated'] + $stats['skipped'];
                    ?>
                    <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                        <strong>Import Complete!</strong>
                        <div class="mt-1">
                            <?php if($stats['created'] > 0): ?>
                                <span class="badge bg-success me-1"><?php echo e($stats['created']); ?> Created</span>
                            <?php endif; ?>
                            <?php if($stats['updated'] > 0): ?>
                                <span class="badge bg-primary me-1"><?php echo e($stats['updated']); ?> Updated</span>
                            <?php endif; ?>
                            <?php if($stats['skipped'] > 0): ?>
                                <span class="badge bg-warning text-dark me-1"><?php echo e($stats['skipped']); ?> Skipped</span>
                            <?php endif; ?>
                            <span class="badge bg-secondary"><?php echo e($totalProcessed); ?> Total</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('products.import')); ?>" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2 flex-wrap">
                    <?php echo csrf_field(); ?>
                    <input type="file" name="file" class="form-control form-control-sm" style="max-width: 200px;" accept=".xlsx,.xls,.csv" required>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-upload me-1"></i>Import
                    </button>
                    <small class="text-muted d-none d-sm-inline ms-auto">Supported: .xlsx, .csv, .xls</small>
                </form>
            </div>
            <?php endif; ?>

            <?php if(Session::has('skippedRows') && count(Session::get('skippedRows')) > 0): ?>
                <div class="m-3 alert alert-warning d-flex align-items-start" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div class="flex-grow-1">
                        <strong>Skipped Rows (<?php echo e(count(Session::get('skippedRows'))); ?>)</strong>
                        <div class="table-responsive mt-2" style="max-height: 150px;">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Reason</th>
                                        <th>Product Name</th>
                                        <th>Serial No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = Session::get('skippedRows'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><span class="badge bg-warning text-dark"><?php echo e($row['skip_reason'] ?? 'Unknown'); ?></span></td>
                                        <td class="text-dark"><?php echo e($row['product_name'] ?? 'N/A'); ?></td>
                                        <td><code><?php echo e($row['serial_no'] ?? 'N/A'); ?></code></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex gap-2 ms-3">
                        <a href="<?php echo e(route('products.skipped.export')); ?>" class="btn btn-sm btn-outline-dark" title="Export">
                            <i class="bi bi-download"></i>
                        </a>
                        <form action="<?php echo e(route('products.skipped.clear')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-close" aria-label="Close"></button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th>Product Info</th>
                            <th>Serial No</th>
                            <th class="d-none d-md-table-cell">Category</th>
                            <th class="d-none d-lg-table-cell">Location</th>
                            <th class="d-none d-lg-table-cell">Price</th>
                            <th style="width: 130px;">Warranty</th>
                            <th class="text-center" style="width: 180px;">Actions</th>
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
                                            <?php echo e($p->brand->brand_name ?? 'N/A'); ?> | <?php echo e($p->model->model_name ?? 'N/A'); ?>

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
                                    <a href="<?php echo e(route('products.show', $p->id)); ?>" class="action-btn action-btn-view" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if(auth()->user()->permission <= 1): ?>
                                        <a href="<?php echo e(route('products.edit', $p->id)); ?>" class="action-btn action-btn-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <a href="<?php echo e(route('maintenance.create', ['product_id' => $p->id])); ?>" class="action-btn action-btn-maintenance" title="Maintenance">
                                            <i class="bi bi-tools"></i>
                                        </a>

                                        <form action="<?php echo e(route('products.destroy', $p->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="action-btn action-btn-delete delete-btn" title="Delete" data-title="Delete Product" data-text="Delete <?php echo e($p->product_name); ?>?">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
                                        <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary btn-sm">
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

            <?php if(\App\Models\Product::onlyTrashed()->count() > 0): ?>
            <div class="recycle-bin-section">
                <div class="px-3 py-2 d-flex align-items-center">
                    <i class="bi bi-trash text-danger me-2"></i>
                    <h6 class="mb-0 text-danger fw-bold">Recycle Bin</h6>
                    <span class="badge bg-danger ms-2"><?php echo e(\App\Models\Product::onlyTrashed()->count()); ?></span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Product</th>
                                <th>Serial No</th>
                                <th>Deleted</th>
                                <th class="pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = \App\Models\Product::onlyTrashed()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deleted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="ps-3"><?php echo e($deleted->product_name); ?></td>
                                <td><code><?php echo e($deleted->serial_no); ?></code></td>
                                <td><?php echo e($deleted->deleted_at->format('d M Y')); ?></td>
                                <td class="pe-3">
                                    <form action="<?php echo e(route('products.restore', $deleted->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('products.forceDelete', $deleted->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger delete-btn" data-title="Permanent Delete" data-text="Permanently delete <?php echo e($deleted->product_name); ?>?">
                                            <i class="bi bi-trash me-1"></i>Delete
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\product_inventory_main\product_inventory\resources\views/products/index.blade.php ENDPATH**/ ?>