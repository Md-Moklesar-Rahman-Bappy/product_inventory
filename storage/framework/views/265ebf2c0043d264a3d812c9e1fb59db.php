<?php if($paginator->hasPages()): ?>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 py-3 px-2">
        
        
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small">Show</span>
            <form method="GET" action="<?php echo e(request()->url()); ?>" class="d-inline">
                <?php $__currentLoopData = request()->except('per_page', 'page'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <select name="per_page" class="form-select form-select-sm" style="width: auto; min-width: 70px;" onchange="this.form.submit()">
                    <?php $__currentLoopData = [10, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($size); ?>" <?php echo e(request('per_page', 10) == $size ? 'selected' : ''); ?>>
                            <?php echo e($size); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
            <span class="text-muted small">entries</span>
        </div>

        
        <div class="text-muted small">
            <span class="fw-semibold"><?php echo e($paginator->firstItem() ?? 0); ?></span>
            <span>to</span>
            <span class="fw-semibold"><?php echo e($paginator->lastItem() ?? 0); ?></span>
            <span>of</span>
            <span class="fw-semibold"><?php echo e($paginator->total()); ?></span>
            <span>results</span>
        </div>

        
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                
                <li class="page-item <?php echo e($paginator->onFirstPage() ? 'disabled' : ''); ?>">
                    <?php if($paginator->onFirstPage()): ?>
                        <span class="page-link rounded-start-pill">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    <?php else: ?>
                        <a class="page-link rounded-start-pill" href="<?php echo e($paginator->previousPageUrl()); ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    <?php endif; ?>
                </li>

                
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_string($element)): ?>
                        <li class="page-item disabled">
                            <span class="page-link"><?php echo e($element); ?></span>
                        </li>
                    <?php endif; ?>

                    <?php if(is_array($element)): ?>
                        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $paginator->currentPage()): ?>
                                <li class="page-item active">
                                    <span class="page-link bg-primary border-primary"><?php echo e($page); ?></span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <li class="page-item <?php echo e(!$paginator->hasMorePages() ? 'disabled' : ''); ?>">
                    <?php if($paginator->hasMorePages()): ?>
                        <a class="page-link rounded-end-pill" href="<?php echo e($paginator->nextPageUrl()); ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="page-link rounded-end-pill">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\product_inventory_main\product_inventory\resources\views/vendor/pagination/bootstrap-5.blade.php ENDPATH**/ ?>