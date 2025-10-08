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

    {{-- 🧭 Dashboard --}}
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active bg-gradient-info shadow-sm' : '' }}">
        <a class="nav-link d-flex align-items-center gap-2" href="{{ route('dashboard') }}" data-toggle="tooltip" title="Dashboard">
            <i class="fas fa-tachometer-alt text-white"></i>
            <span class="text-white">Dashboard</span>
        </a>
    </li>

    {{-- 📜 Activity Logs --}}
    <li class="nav-item {{ request()->routeIs('activity.logs') ? 'active bg-gradient-info shadow-sm' : '' }}">
        <a class="nav-link d-flex align-items-center gap-2" href="{{ route('activity.logs') }}" data-toggle="tooltip" title="Activity Logs">
            <i class="fas fa-clipboard-list text-white"></i>
            <span class="text-white">Activity Logs</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- 🏷️ Add Items --}}
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('categories.*', 'brands.*', 'models.*') ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseCategory"
            aria-expanded="{{ request()->routeIs('categories.*', 'brands.*', 'models.*') ? 'true' : 'false' }}" aria-controls="collapseCategory">
            <i class="fas fa-tags text-white"></i>
            <span class="text-white">Add Items</span>
        </a>
        <div id="collapseCategory" class="collapse {{ request()->routeIs('categories.*', 'brands.*', 'models.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
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

    {{-- 📋 Product --}}
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('products.*') ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseProduct"
            aria-expanded="{{ request()->routeIs('products.*') ? 'true' : 'false' }}" aria-controls="collapseProduct">
            <i class="fas fa-box-open text-white"></i>
            <span class="text-white">Product</span>
        </a>
        <div id="collapseProduct" class="collapse {{ request()->routeIs('products.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
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
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('maintenance.*') ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseMaintenance"
            aria-expanded="{{ request()->routeIs('maintenance.*') ? 'true' : 'false' }}" aria-controls="collapseMaintenance">
            <i class="fas fa-tools text-white"></i>
            <span class="text-white">Maintenance</span>
        </a>
        <div id="collapseMaintenance" class="collapse {{ request()->routeIs('maintenance.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
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

    {{-- 🛡️ Warranty --}}
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('warranties.*') ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseWarranty"
            aria-expanded="{{ request()->routeIs('warranties.*') ? 'true' : 'false' }}" aria-controls="collapseWarranty">
            <i class="fas fa-shield-alt text-white"></i>
            <span class="text-white">Warranty</span>
        </a>
        <div id="collapseWarranty" class="collapse {{ request()->routeIs('warranties.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                <a class="collapse-item" href="{{ route('warranties.index') }}">
                    <i class="fas fa-eye text-primary me-2"></i> Warranty Status
                </a>
            </div>
        </div>
    </li>

    @if(auth()->user()->isSuperadmin())
    {{-- 👤 User Management --}}
    <li class="nav-item {{ request()->routeIs('users.index') ? 'active bg-gradient-info shadow-sm' : '' }}">
        <a class="nav-link d-flex align-items-center gap-2" href="{{ route('users.index') }}" data-toggle="tooltip" title="User">
            <i class="fas fa-user text-white"></i>
            <span class="text-white">User</span>
        </a>
    </li>
    @endif

    {{-- 👤 Profile --}}
    <li class="nav-item {{ request()->routeIs('users.show') ? 'active bg-gradient-info shadow-sm' : '' }}">
        <a class="nav-link d-flex align-items-center gap-2" href="{{ route('users.show', auth()->user()->id) }}" data-toggle="tooltip" title="Profile">
            <i class="fas fa-user-circle text-white"></i>
            <span class="text-white">Profile</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    {{-- 🔄 Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

{{-- 🌐 Tooltips Initialization --}}
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
