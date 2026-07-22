<?php $__env->startSection('title', 'Edit Category'); ?>

<?php $__env->startSection('contents'); ?>
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

    
    <div class="card-header text-white" style="background: linear-gradient(90deg, #FF9800, #FF5722); padding: 1.5rem;">
      <h3 class="mb-0 fw-bold"><i class="fa fa-edit me-2"></i> Edit Category</h3>
    </div>

    
    <div class="card-body bg-light" style="padding: 2rem;">
      <form action="<?php echo e(route('categories.update', $category->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="mb-4">
          <label for="category_name" class="form-label fw-semibold text-dark">Category Name</label>
          <input type="text" name="category_name" id="category_name" class="form-control form-control-lg shadow-sm" placeholder="Enter category name..." value="<?php echo e($category->category_name); ?>" required>
        </div>

        
        <div class="d-grid mt-4">
          <button type="submit" class="btn btn-warning btn-lg fw-bold shadow-sm">
            <i class="fa fa-save me-1"></i> Update Category
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\categories\edit.blade.php ENDPATH**/ ?>