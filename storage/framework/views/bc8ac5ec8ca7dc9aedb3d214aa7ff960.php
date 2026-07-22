<?php if($paginator->hasPages()): ?>
    <nav class="pagination-block mt-4" aria-label="Pagination Navigation">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            
            
            <div class="d-flex align-items-center">
                <label for="perPage" class="me-2 small text-muted">Show:</label>
                <select id="perPage" onchange="window.location.href=updateQueryStringParameter(this.value)" 
                        class="form-select form-select-sm" style="width: auto;">
                    <?php $__currentLoopData = [10, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($perPage); ?>" <?php echo e(request('per_page', 10) == $perPage ? 'selected' : ''); ?>>
                            <?php echo e($perPage); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <ul class="pagination justify-content-center flex-wrap gap-2 mb-0">

            
            <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled"><span class="page-link">&laquo;&laquo;</span></li>
            <?php else: ?>
                <li class="page-item"><a class="page-link" href="<?php echo e($paginator->url(1)); ?>" rel="first">&laquo;&laquo;</a></li>
            <?php endif; ?>

            
            <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            <?php else: ?>
                <li class="page-item"><a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">&laquo;</a></li>
            <?php endif; ?>

            
            <?php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $start = max($current - 2, 1);
                $end = min($start + 4, $last);
                if ($end - $start < 4) {
                    $start = max($end - 4, 1);
                }
            ?>

            <?php for($page = $start; $page <= $end; $page++): ?>
                <?php if($page == $current): ?>
                    <li class="page-item active" aria-current="page"><span class="page-link"><?php echo e($page); ?></span></li>
                <?php else: ?>
                    <li class="page-item"><a class="page-link" href="<?php echo e($paginator->url($page)); ?>"><?php echo e($page); ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item"><a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">&raquo;</a></li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            <?php endif; ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item"><a class="page-link" href="<?php echo e($paginator->url($last)); ?>" rel="last">&raquo;&raquo;</a></li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">&raquo;&raquo;</span></li>
            <?php endif; ?>

        </ul>
        </div>
    </nav>

    <script>
        function updateQueryStringParameter(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            return url.toString();
        }
    </script>
<?php endif; ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\components\pagination-block.blade.php ENDPATH**/ ?>