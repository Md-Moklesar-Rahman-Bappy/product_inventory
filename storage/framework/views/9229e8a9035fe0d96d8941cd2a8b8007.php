<!-- 🌈 Sidebar Navigation -->
<ul class="navbar-nav sidebar sidebar-dark accordion bg-gradient-primary shadow-lg" id="accordionSidebar">

  
  <?php
    $appName = \App\Models\Setting::get('app_name', 'Product Inventory');
    $logoPath = \App\Models\Setting::get('logo_path');
    $logoUrl = asset('images/logo.svg');
    if (!empty($logoPath) && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath)) {
        $logoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($logoPath);
    }
  ?>
  <a class="sidebar-brand d-flex align-items-center justify-content-center py-4" href="<?php echo e(route('dashboard')); ?>">
    <div class="sidebar-brand-icon rotate-n-15 text-warning">
      <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($appName); ?> Logo" style="height: 50px; transition: transform 0.3s ease;">
    </div>
    <div class="sidebar-brand-text mx-3 text-white fw-bold text-uppercase">
      <?php echo e($appName); ?>

    </div>
  </a>

  <hr class="sidebar-divider my-0">

  
  <li class="nav-item <?php echo e(request()->routeIs('dashboard') ? 'active bg-gradient-info shadow-sm' : ''); ?>">
    <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('dashboard')); ?>" data-toggle="tooltip" title="Dashboard">
      <i class="fas fa-tachometer-alt text-white"></i>
      <span class="text-white">Dashboard</span>
    </a>
  </li>

  <li class="nav-item <?php echo e(request()->routeIs('activity.logs') ? 'active bg-gradient-info shadow-sm' : ''); ?>">
    <a class="nav-link d-flex align-items-center gap-2" href="<?php echo e(route('activity.logs')); ?>" data-toggle="tooltip" title="Activity Logs">
      <i class="fas fa-clipboard-list text-white"></i>
      <span class="text-white">Activity Logs</span>
    </a>
  </li>

  <hr class="sidebar-divider">

  
  <?php
    $inventoryActive = request()->routeIs('categories.*', 'brands.*', 'models.*');
  ?>
  <li class="nav-item">
    <a class="nav-link collapsed <?php echo e($inventoryActive ? 'active' : ''); ?>" href="#" data-toggle="collapse" data-target="#collapseInventory"
       aria-expanded="<?php echo e($inventoryActive ? 'true' : 'false'); ?>" aria-controls="collapseInventory">
      <i class="fas fa-tags text-white"></i>
      <span class="text-white">Add Items</span>
    </a>
    <div id="collapseInventory" class="collapse <?php echo e($inventoryActive ? 'show' : ''); ?>" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded shadow-sm">
        <a class="collapse-item" href="<?php echo e(route('categories.index')); ?>">
          <i class="fas fa-eye text-primary me-2"></i> Categories
        </a>
        <a class="collapse-item" href="<?php echo e(route('brands.index')); ?>">
          <i class="fas fa-eye text-primary me-2"></i> Brands
        </a>
        <a class="collapse-item" href="<?php echo e(route('models.index')); ?>">
          <i class="fas fa-eye text-primary me-2"></i> Models
        </a>
      </div>
    </div>
  </li>

  
  <?php
    $productActive = request()->routeIs('products.*');
  ?>
  <li class="nav-item">
    <a class="nav-link collapsed <?php echo e($productActive ? 'active' : ''); ?>" href="#" data-toggle="collapse" data-target="#collapseProduct"
       aria-expanded="<?php echo e($productActive ? 'true' : 'false'); ?>" aria-controls="collapseProduct">
      <i class="fas fa-box-open text-white"></i>
      <span class="text-white">Product</span>
    </a>
    <div id="collapseProduct" class="collapse <?php echo e($productActive ? 'show' : ''); ?>" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded shadow-sm">
        <a class="collapse-item" href="<?php echo e(route('products.index')); ?>">
          <i class="fas fa-eye text-primary me-2"></i> Products
        </a>
        <a class="collapse-item" href="<?php echo e(route('products.create')); ?>">
          <i class="fas fa-plus text-success me-2"></i> Add Product
        </a>
      </div>
    </div>
  </li>

  
  <?php
    $maintenanceActive = request()->routeIs('maintenance.*');
  ?>
  <li class="nav-item">
    <a class="nav-link collapsed <?php echo e($maintenanceActive ? 'active' : ''); ?>" href="#" data-toggle="collapse" data-target="#collapseMaintenance"
       aria-expanded="<?php echo e($maintenanceActive ? 'true' : 'false'); ?>" aria-controls="collapseMaintenance">
      <i class="fas fa-tools text-white"></i>
      <span class="text-white">Maintenance</span>
    </a>
    <div id="collapseMaintenance" class="collapse <?php echo e($maintenanceActive ? 'show' : ''); ?>" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded shadow-sm">
        <a class="collapse-item" href="<?php echo e(route('maintenance.index')); ?>">
          <i class="fas fa-eye text-primary me-2"></i> Maintenance Logs
        </a>
        <a class="collapse-item" href="<?php echo e(route('maintenance.create')); ?>">
          <i class="fas fa-plus text-success me-2"></i> Add Maintenance
        </a>
      </div>
    </div>
  </li>

  
  <?php
    $warrantyActive = request()->routeIs('warranties.*');
  ?>
  <li class="nav-item">
    <a class="nav-link collapsed <?php echo e($warrantyActive ? 'active' : ''); ?>" href="#" data-toggle="collapse" data-target="#collapseWarranty"
       aria-expanded="<?php echo e($warrantyActive ? 'true' : 'false'); ?>" aria-controls="collapseWarranty">
      <i class="fas fa-shield-alt text-white"></i>
      <span class="text-white">Warranty</span>
    </a>
    <div id="collapseWarranty" class="collapse <?php echo e($warrantyActive ? 'show' : ''); ?>" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded shadow-sm">
        <a class="collapse-item" href="<?php echo e(route('warranties.index')); ?>">
          <i class="fas fa-eye text-primary me-2"></i> Warranty Status
        </a>
      </div>
    </div>
  </li>

  
  <?php
    $settingsActive = request()->routeIs('users.*', 'users.show', 'settings.*');
  ?>
  <li class="nav-item">
    <a class="nav-link collapsed <?php echo e($settingsActive ? 'active' : ''); ?>" href="#" data-toggle="collapse" data-target="#collapseSettings"
       aria-expanded="<?php echo e($settingsActive ? 'true' : 'false'); ?>" aria-controls="collapseSettings">
      <i class="fas fa-cogs text-white"></i>
      <span class="text-white">Settings</span>
    </a>
    <div id="collapseSettings" class="collapse <?php echo e($settingsActive ? 'show' : ''); ?>" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded shadow-sm">
        <?php if(auth()->user()->isSuperadmin()): ?>
          <a class="collapse-item" href="<?php echo e(route('users.index')); ?>">
            <i class="fas fa-user text-primary me-2"></i> User Management
          </a>
          <a class="collapse-item" href="<?php echo e(route('settings.index')); ?>">
            <i class="fas fa-sliders-h text-primary me-2"></i> Application Settings
          </a>
        <?php endif; ?>
        <a class="collapse-item" href="<?php echo e(route('users.show', auth()->user()->id)); ?>">
          <i class="fas fa-user-circle text-primary me-2"></i> Profile
        </a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider d-none d-md-block">

  
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>


<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\layouts\sidebar.blade.php ENDPATH**/ ?>