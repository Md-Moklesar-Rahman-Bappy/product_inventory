<!-- 🌈 Sidebar Navigation -->
<ul class="navbar-nav sidebar sidebar-dark accordion bg-gradient-primary shadow-lg" id="accordionSidebar">

  {{-- 🌟 Brand --}}
  <a class="sidebar-brand d-flex align-items-center justify-content-center py-4" href="{{ route('dashboard') }}">
    <div class="sidebar-brand-icon rotate-n-15 text-warning">
      <img src="{{ asset('images/logo.svg') }}" alt="SOCDS Logo" style="height: 50px; transition: transform 0.3s ease;">
    </div>
    <div class="sidebar-brand-text mx-3 text-white fw-bold text-uppercase">
      Product Inventory
    </div>
  </a>

  <hr class="sidebar-divider my-0">

  {{-- 📊 Core Navigation --}}
  <li class="nav-item {{ request()->routeIs('dashboard') ? 'active bg-gradient-info shadow-sm' : '' }}">
    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('dashboard') }}" data-toggle="tooltip" title="Dashboard">
      <i class="fas fa-tachometer-alt text-white"></i>
      <span class="text-white">Dashboard</span>
    </a>
  </li>

  <li class="nav-item {{ request()->routeIs('activity.logs') ? 'active bg-gradient-info shadow-sm' : '' }}">
    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('activity.logs') }}" data-toggle="tooltip" title="Activity Logs">
      <i class="fas fa-clipboard-list text-white"></i>
      <span class="text-white">Activity Logs</span>
    </a>
  </li>

  <hr class="sidebar-divider">

  {{-- 🧩 Inventory Modules --}}
  @php
    $inventoryActive = request()->routeIs('categories.*', 'brands.*', 'models.*');
  @endphp
  <li class="nav-item">
    <a class="nav-link collapsed {{ $inventoryActive ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseInventory"
       aria-expanded="{{ $inventoryActive ? 'true' : 'false' }}" aria-controls="collapseInventory">
      <i class="fas fa-tags text-white"></i>
      <span class="text-white">Add Items</span>
    </a>
    <div id="collapseInventory" class="collapse {{ $inventoryActive ? 'show' : '' }}" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded shadow-sm">
        <a class="collapse-item" href="{{ route('categories.index') }}">
          <i class="fas fa-eye text-primary me-2"></i> Categories
        </a>
        <a class="collapse-item" href="{{ route('brands.index') }}">
          <i class="fas fa-eye text-primary me-2"></i> Brands
        </a>
        <a class="collapse-item" href="{{ route('models.index') }}">
          <i class="fas fa-eye text-primary me-2"></i> Models
        </a>
      </div>
    </div>
  </li>

  {{-- 📦 Products --}}
  @php
    $productActive = request()->routeIs('products.*');
  @endphp
  <li class="nav-item">
    <a class="nav-link collapsed {{ $productActive ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseProduct"
       aria-expanded="{{ $productActive ? 'true' : 'false' }}" aria-controls="collapseProduct">
      <i class="fas fa-box-open text-white"></i>
      <span class="text-white">Product</span>
    </a>
    <div id="collapseProduct" class="collapse {{ $productActive ? 'show' : '' }}" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded shadow-sm">
        <a class="collapse-item" href="{{ route('products.index') }}">
          <i class="fas fa-eye text-primary me-2"></i> Products
        </a>
        <a class="collapse-item" href="{{ route('products.create') }}">
          <i class="fas fa-plus text-success me-2"></i> Add Product
        </a>
      </div>
    </div>
  </li>

  {{-- 🛠 Maintenance --}}
  @php
    $maintenanceActive = request()->routeIs('maintenance.*');
  @endphp
  <li class="nav-item">
    <a class="nav-link collapsed {{ $maintenanceActive ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseMaintenance"
       aria-expanded="{{ $maintenanceActive ? 'true' : 'false' }}" aria-controls="collapseMaintenance">
      <i class="fas fa-tools text-white"></i>
      <span class="text-white">Maintenance</span>
    </a>
    <div id="collapseMaintenance" class="collapse {{ $maintenanceActive ? 'show' : '' }}" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded shadow-sm">
        <a class="collapse-item" href="{{ route('maintenance.index') }}">
          <i class="fas fa-eye text-primary me-2"></i> Maintenance Logs
        </a>
        <a class="collapse-item" href="{{ route('maintenance.create') }}">
          <i class="fas fa-plus text-success me-2"></i> Add Maintenance
        </a>
      </div>
    </div>
  </li>

  {{-- 🛡 Warranty --}}
  @php
    $warrantyActive = request()->routeIs('warranties.*');
  @endphp
  <li class="nav-item">
    <a class="nav-link collapsed {{ $warrantyActive ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseWarranty"
       aria-expanded="{{ $warrantyActive ? 'true' : 'false' }}" aria-controls="collapseWarranty">
      <i class="fas fa-shield-alt text-white"></i>
      <span class="text-white">Warranty</span>
    </a>
    <div id="collapseWarranty" class="collapse {{ $warrantyActive ? 'show' : '' }}" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded shadow-sm">
        <a class="collapse-item" href="{{ route('warranties.index') }}">
          <i class="fas fa-eye text-primary me-2"></i> Warranty Status
        </a>
      </div>
    </div>
  </li>

  {{-- ⚙️ Settings --}}
  @php
    $settingsActive = request()->routeIs('users.*', 'users.show');
  @endphp
  <li class="nav-item">
    <a class="nav-link collapsed {{ $settingsActive ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseSettings"
       aria-expanded="{{ $settingsActive ? 'true' : 'false' }}" aria-controls="collapseSettings">
      <i class="fas fa-cogs text-white"></i>
      <span class="text-white">Settings</span>
    </a>
    <div id="collapseSettings" class="collapse {{ $settingsActive ? 'show' : '' }}" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded shadow-sm">
        @if(auth()->user()->isSuperadmin())
          <a class="collapse-item" href="{{ route('users.index') }}">
            <i class="fas fa-user text-primary me-2"></i> User Management
          </a>
        @endif
        <a class="collapse-item" href="{{ route('users.show', auth()->user()->id) }}">
          <i class="fas fa-user-circle text-primary me-2"></i> Profile
        </a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider d-none d-md-block">

  {{-- 🔄 Sidebar Toggler --}}
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>

{{-- 🌐 Tooltip Initialization --}}
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
