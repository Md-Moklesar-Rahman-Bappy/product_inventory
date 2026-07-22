<?php $__env->startSection('title', 'Categories'); ?>

<?php $__env->startSection('contents'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-2 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-tags"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Categories</h5>
                            <small class="text-white opacity-75"><?php echo e($categories->total()); ?> total</small>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="liveSearch" placeholder="Search categories..." autocomplete="off">
                            <div id="searchResults" class="search-results"></div>
                        </div>
                        <form id="searchForm" method="GET" action="<?php echo e(route('categories.index')); ?>" class="d-none">
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
                                <a href="<?php echo e(route('categories.sample')); ?>" class="btn btn-sm btn-light">
                                    <i class="bi bi-download me-1"></i>Sample
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bi bi-file-earmark-excel me-1"></i>Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo e(route('categories.export')); ?>">Export</a></li>
                                    </ul>
                                </div>
                                <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-plus-lg me-1"></i>Add
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if(auth()->user()->permission <= 1): ?>
            <div class="import-section">
                <form action="<?php echo e(route('categories.import')); ?>" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                    <?php echo csrf_field(); ?>
                    <input type="file" name="file" class="form-control form-control-sm" style="max-width: 200px;" accept=".xlsx,.xls,.csv" required>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-upload me-1"></i>Import
                    </button>
                    <small class="text-muted ms-auto">Supported: .xlsx, .csv, .xls</small>
                </form>
            </div>
            <?php endif; ?>

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th>Category Name</th>
                            <th style="width: 120px;">Products</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr <?php if($c->trashed()): ?> class="bg-danger-subtle" <?php endif; ?>>
                            <td class="ps-4">
                                <span class="row-number"><?php echo e(($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration); ?></span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('categories.products', $c->id)); ?>" class="product-name text-decoration-none">
                                    <i class="bi bi-tag-fill me-2 text-primary"></i><?php echo e($c->category_name); ?>

                                </a>
                                <?php if($c->trashed()): ?>
                                    <span class="badge bg-danger ms-2">Archived</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="category-badge">
                                    <i class="bi bi-box"></i>
                                    <?php echo e($c->products_count ?? 0); ?>

                                </span>
                            </td>
                            <td>
                                <?php if(auth()->user()->permission <= 1): ?>
                                    <div class="action-buttons">
                                        <?php if($c->trashed()): ?>
                                            <form action="<?php echo e(route('categories.restore', $c->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="action-btn action-btn-view" title="Restore">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('categories.edit', $c->id)); ?>" class="action-btn action-btn-edit" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('categories.destroy', $c->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="action-btn action-btn-delete delete-btn"
                                                    data-title="Archive Category"
                                                    data-text="Archive <?php echo e($c->category_name); ?>?"
                                                    title="Archive">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-tags"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mt-3">No Categories Found</h6>
                                    <p class="text-muted mb-3">Get started by adding your first category</p>
                                    <?php if(auth()->user()->permission <= 1): ?>
                                        <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i>Add Category
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($categories->hasPages()): ?>
            <div class="table-footer">
                <?php echo e($categories->links('vendor.pagination.bootstrap-5')); ?>

            </div>
            <?php endif; ?>

            <?php if(auth()->user()->permission <= 1 && \App\Models\Category::onlyTrashed()->count() > 0): ?>
            <div class="recycle-bin-section">
                <div class="px-3 py-2 d-flex align-items-center">
                    <i class="bi bi-trash text-danger me-2"></i>
                    <h6 class="mb-0 text-danger fw-bold">Recycle Bin</h6>
                    <span class="badge bg-danger ms-2"><?php echo e(\App\Models\Category::onlyTrashed()->count()); ?></span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Category</th>
                                <th>Deleted</th>
                                <th class="pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = \App\Models\Category::onlyTrashed()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deleted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="ps-3"><?php echo e($deleted->category_name); ?></td>
                                <td><?php echo e($deleted->deleted_at->format('d M Y')); ?></td>
                                <td class="pe-3">
                                    <form action="<?php echo e(route('categories.restore', $deleted->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                        </button>
                                    </form>
                                    <?php if(auth()->user()->isSuperadmin()): ?>
                                        <form action="<?php echo e(route('categories.forceDelete', $deleted->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-sm btn-danger delete-btn"
                                                data-title="Permanent Delete"
                                                data-text="Permanently delete <?php echo e($deleted->category_name); ?>?">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    <?php endif; ?>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\categories\index.blade.php ENDPATH**/ ?>