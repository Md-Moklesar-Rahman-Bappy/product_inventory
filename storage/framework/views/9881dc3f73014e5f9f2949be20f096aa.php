<?php $__env->startSection('title', 'Log Maintenance'); ?>

<?php $__env->startSection('contents'); ?>
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
    <div class="card-header bg-primary text-white py-3">
      <h3 class="mb-0 fw-bold"><i class="fa fa-tools me-2"></i> Create Maintenance Record</h3>
    </div>

    <div class="card-body bg-white px-4 py-5">
      <?php if($errors->any()): ?>
        <div class="alert alert-danger shadow-sm">
          <strong><i class="fa fa-exclamation-triangle me-1"></i> Please fix the following:</strong>
          <ul class="mt-2 mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="<?php echo e(route('maintenance.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">

        
        <h5 class="text-primary fw-bold mb-3"><i class="fa fa-box-open me-2"></i> Product Details</h5>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label">Product Name</label>
            <input type="text" class="form-control" value="<?php echo e($product->product_name); ?>" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Serial No</label>
            <input type="text" class="form-control" value="<?php echo e($product->serial_no); ?>" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Project Serial No</label>
            <input type="text" class="form-control" value="<?php echo e($product->project_serial_no); ?>" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label d-block">Warranty</label>
            <?php if (isset($component)) { $__componentOriginal11a038ff03590b5d424bcbbd923c4196 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal11a038ff03590b5d424bcbbd923c4196 = $attributes; } ?>
<?php $component = App\View\Components\WarrantyCountdown::resolve(['start' => $product->warranty_start,'end' => $product->warranty_end] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('warranty-countdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\WarrantyCountdown::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal11a038ff03590b5d424bcbbd923c4196)): ?>
<?php $attributes = $__attributesOriginal11a038ff03590b5d424bcbbd923c4196; ?>
<?php unset($__attributesOriginal11a038ff03590b5d424bcbbd923c4196); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11a038ff03590b5d424bcbbd923c4196)): ?>
<?php $component = $__componentOriginal11a038ff03590b5d424bcbbd923c4196; ?>
<?php unset($__componentOriginal11a038ff03590b5d424bcbbd923c4196); ?>
<?php endif; ?>
          </div>
        </div>

        
        <h5 class="text-primary fw-bold mb-3"><i class="fa fa-exclamation-circle me-2"></i> Problem Description</h5>
        <div class="mb-4">
          <textarea name="description" class="form-control" rows="4" placeholder="Describe the issue..." required><?php echo e(old('description')); ?></textarea>
        </div>

        
        <h5 class="text-primary fw-bold mb-3"><i class="fa fa-calendar-alt me-2"></i> Maintenance Timeline</h5>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_time" class="form-control" value="<?php echo e(old('start_time')); ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">End Date</label>
            <input type="date" name="end_time" class="form-control" value="<?php echo e(old('end_time')); ?>" required>
          </div>
        </div>

        
        <div class="d-flex justify-content-between mt-4">
          <button type="submit" class="btn btn-primary px-4 fw-bold">
            <i class="fa fa-check-circle me-1"></i> Create
          </button>
          <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary px-4">
            <i class="fa fa-times-circle me-1"></i> Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\maintenance\create.blade.php ENDPATH**/ ?>