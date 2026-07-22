<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination pagination-sm mb-0">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-start-pill">
                        <i class="bi bi-chevron-left me-1"></i> Previous
                    </span>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link rounded-start-pill" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">
                        <i class="bi bi-chevron-left me-1"></i> Previous
                    </a>
                </li>
            <?php endif; ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item">
                    <a class="page-link rounded-end-pill" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">
                        Next <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-end-pill">
                        Next <i class="bi bi-chevron-right ms-1"></i>
                    </span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\vendor\pagination\simple-bootstrap-5.blade.php ENDPATH**/ ?>