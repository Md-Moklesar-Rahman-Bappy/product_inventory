<?php $__env->startSection('title', 'Create Category'); ?>

<?php $__env->startSection('contents'); ?>
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

    
    <div class="card-header text-white" style="background: linear-gradient(90deg, #00C9FF, #92FE9D); padding: 1.5rem;">
      <h3 class="mb-0 fw-bold"><i class="fa fa-plus-circle me-2"></i> Add New Category</h3>
    </div>

    
    <div class="card-body bg-light" style="padding: 2rem;">
      <form action="<?php echo e(route('categories.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        
        <div class="mb-4">
          <label for="category_name" class="form-label fw-semibold text-dark">Category Name</label>
          <input type="text" name="category_name" id="category_name" class="form-control form-control-lg shadow-sm" placeholder="Enter category name..." value="<?php echo e(old('category_name')); ?>" required>
        </div>

        
        <div class="d-grid mt-4">
          <button type="submit" class="btn btn-success px-4">
              <i class="fa fa-check-circle me-1"></i> Create
            </button>

        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\categories\create.blade.php ENDPATH**/ ?>