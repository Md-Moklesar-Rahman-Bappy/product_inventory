<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $appName = \App\Models\Setting::get('app_name', 'Product Inventory');
        $faviconPath = \App\Models\Setting::get('favicon_path');
        $faviconUrl = asset('favicon.ico');
        if (!empty($faviconPath) && \Illuminate\Support\Facades\Storage::disk('public')->exists($faviconPath)) {
            $faviconUrl = Storage::url($faviconPath);
        }
        $faviconUrl = $faviconUrl . '?v=' . filemtime(public_path('favicon.ico'));
    @endphp
    <title>{{ $appName }} - @yield('title', 'Dashboard')</title>
    
    <!-- Favicon - must be first -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconUrl }}">
    <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <!-- Page-specific styles -->
    @stack('styles')
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="brand">
                <i class="bi bi-box-seam-fill"></i>
                <span>{{ $appName }}</span>
            </a>
            <button class="close-btn d-md-none" onclick="toggleSidebar()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                {{-- Activity Log --}}
                <li class="nav-item">
                    <a href="{{ route('activity.logs') }}" class="nav-link {{ request()->routeIs('activity.logs') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i>
                        <span>Activity Log</span>
                    </a>
                </li>
                
                {{-- Categories, Brands, Models, Products (Admin only) --}}
                @if(in_array(auth()->user()->permission, [0, 1]))
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('brands.index') }}" class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                        <i class="bi bi-award"></i>
                        <span>Brands</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('models.index') }}" class="nav-link {{ request()->routeIs('models.*') ? 'active' : '' }}">
                        <i class="bi bi-layers"></i>
                        <span>Models</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="bi bi-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                
                {{-- Warranty --}}
                <li class="nav-item">
                    <a href="{{ route('warranties.index') }}" class="nav-link {{ request()->routeIs('warranties.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-check"></i>
                        <span>Warranty</span>
                    </a>
                </li>
                
                {{-- Maintenance --}}
                <li class="nav-item">
                    <a href="{{ route('maintenance.index') }}" class="nav-link {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
                        <i class="bi bi-tools"></i>
                        <span>Maintenance</span>
                    </a>
                </li>
                @endif
                
                {{-- Manage Users (Superadmin only) --}}
                @if(auth()->user()->permission === 0)
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-person-plus"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>Application Settings</span>
                    </a>
                </li>
                @endif
                
                {{-- Profile --}}
                <li class="nav-item">
                    <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile" class="user-avatar-sm">
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <button class="toggle-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>
                    <div class="col">
                        <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="col-auto d-flex align-items-center gap-2">
                        <!-- Global Search -->
                        <div class="global-search d-none d-lg-block">
                            <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control form-control-sm" 
                                    placeholder="Search products..." 
                                    style="width: 200px; border-radius: 20px 0 0 20px;">
                                <button type="submit" class="btn btn-sm btn-primary" 
                                    style="border-radius: 0 20px 20px 0;">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Dark Mode Toggle -->
                        <button class="btn theme-toggle" onclick="toggleTheme()" title="Toggle Theme">
                            <i class="bi bi-moon-stars" id="themeIcon"></i>
                        </button>
                        
                        <!-- User Menu -->
                            <div class="dropdown">
                                <button class="btn user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile" class="user-avatar">
                                    <span class="user-name d-none d-md-inline">{{ auth()->user()->name }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person"></i> Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <div class="container-fluid">
                @yield('contents')
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0 small text-muted">
                            <i class="fas fa-calendar-alt me-1 text-primary"></i>
                            <span id="datetime"></span>
                        </p>
                        @php
                            $address = \App\Models\Setting::get('address');
                        @endphp
                        @if($address)
                            <p class="mb-0 small text-muted mt-1">
                                <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                {{ $address }}
                            </p>
                        @endif
                    </div>
                    <div class="col-md-6 text-md-end">
                        @php
                            $website = \App\Models\Setting::get('website');
                            $footerCredit = \App\Models\Setting::get('footer_credit', 'DLRS SOCDS Project');
                            $phone = \App\Models\Setting::get('phone');
                            $email = \App\Models\Setting::get('email');
                        @endphp
                        @if($website)
                            <a href="{{ $website }}" target="_blank" class="text-muted text-decoration-none me-3">{{ $footerCredit }}</a>
                        @else
                            <span class="text-muted me-3">{{ $footerCredit }}</span>
                        @endif
                        @if($phone)
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="text-muted text-decoration-none me-3">
                                <i class="fas fa-phone-alt me-1"></i>{{ $phone }}
                            </a>
                        @endif
                        @if($email)
                            <a href="mailto:{{ $email }}" class="text-muted text-decoration-none">
                                <i class="fas fa-envelope me-1"></i>{{ $email }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </footer>
        <script>
          function updateDateTime() {
            const now = new Date();
            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            const dateStr = now.toLocaleDateString('en-GB', options).replace(/\//g, ' ');
            
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            const timeStr = `${hours}:${minutes}:${seconds} ${ampm} GMT+6`;
            
            document.getElementById('datetime').textContent = `${dateStr}, ${timeStr}`;
          }
          updateDateTime();
          setInterval(updateDateTime, 1000);
    </script>
    
    <!-- Theme Toggle CSS -->
    <style>
        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .theme-toggle:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
        }
        
        .theme-toggle i {
            font-size: 1.1rem;
            color: #64748b;
        }
        
        .global-search form {
            display: flex;
            align-items: center;
        }
        
        .global-search input {
            border-right: none;
        }
        
        .global-search input:focus {
            border-color: #4f46e5;
            box-shadow: none;
        }
        
        .global-search button {
            background: #4f46e5;
            border-color: #4f46e5;
        }
        
        /* Dark Mode Styles */
        body.dark-mode {
            background: #0f172a;
            color: #e2e8f0;
        }
        
        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            border-right: 1px solid #334155;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.4);
        }
        
        body.dark-mode .sidebar-header {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2) 0%, rgba(124, 58, 237, 0.15) 100%);
            border-bottom-color: #334155;
        }
        
        body.dark-mode .sidebar-nav .nav-link {
            color: #94a3b8;
        }
        
        body.dark-mode .sidebar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
        }
        
        body.dark-mode .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.3) 0%, rgba(124, 58, 237, 0.25) 100%);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
        }
        
        body.dark-mode .sidebar-footer {
            background: rgba(0, 0, 0, 0.3);
            border-top-color: #334155;
        }
        
        body.dark-mode .main-content {
            background: #0f172a;
        }
        
        body.dark-mode .top-navbar {
            background: #1e293b;
            border-bottom-color: #334155;
        }
        
        body.dark-mode .page-title {
            color: #e2e8f0;
        }
        
        body.dark-mode .theme-toggle {
            background: #334155;
            border-color: #475569;
        }
        
        body.dark-mode .theme-toggle i {
            color: #fbbf24;
        }
        
        body.dark-mode .custom-card,
        body.dark-mode .dashboard-widget,
        body.dark-mode .chart-card,
        body.dark-mode .stat-card {
            background: #1e293b;
            border-color: #334155;
        }
        
        body.dark-mode .card-header {
            background: #1e293b;
            border-bottom-color: #334155;
        }
        
        body.dark-mode .table {
            color: #e2e8f0;
        }
        
        body.dark-mode .table thead th {
            background: #334155;
            color: #e2e8f0;
            border-color: #475569;
        }
        
        body.dark-mode .table td {
            border-color: #334155;
        }
        
        body.dark-mode .form-control {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }
        
        body.dark-mode .form-control:focus {
            background: #334155;
            border-color: #4f46e5;
            color: #e2e8f0;
        }
        
        body.dark-mode .btn-light {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }
        
        body.dark-mode .welcome-section {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }
        
        body.dark-mode .main-footer {
            background: #1e293b;
            border-top-color: #334155;
        }
        
        body.dark-mode .stat-value,
        body.dark-mode .stat-label {
            color: #e2e8f0;
        }
        
        body.dark-mode .list-text {
            color: #e2e8f0;
        }
        
        body.dark-mode .widget-title {
            color: #e2e8f0;
        }
        
        body.dark-mode .chart-title {
            color: #e2e8f0;
        }
        
        body.dark-mode .detail-card {
            background: #334155;
            border-color: #475569;
        }
        
        body.dark-mode .detail-label {
            color: #94a3b8;
        }
        
        body.dark-mode .detail-value {
            color: #e2e8f0;
        }
        
        body.dark-mode .detail-section {
            background: #334155;
        }

        /* Dark Mode - Additional Components */
        body.dark-mode .dropdown-menu {
            background: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }

        body.dark-mode .dropdown-menu .dropdown-item {
            color: #e2e8f0;
        }

        body.dark-mode .dropdown-menu .dropdown-item:hover,
        body.dark-mode .dropdown-menu .dropdown-item:focus {
            background: #334155;
            color: #ffffff;
        }

        body.dark-mode .dropdown-menu .dropdown-divider {
            border-color: #334155;
        }

        body.dark-mode .form-select {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .form-select:focus {
            background: #334155;
            border-color: #4f46e5;
            color: #e2e8f0;
        }

        body.dark-mode .btn-close {
            filter: invert(1);
        }

        body.dark-mode .modal-content {
            background: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }

        body.dark-mode .modal-header {
            border-bottom-color: #334155;
        }

        body.dark-mode .modal-footer {
            border-top-color: #334155;
        }

        body.dark-mode .modal-backdrop.show {
            opacity: 0.8;
        }

        body.dark-mode .pagination .page-link {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .pagination .page-link:hover {
            background: #475569;
            border-color: #64748b;
            color: #ffffff;
        }

        body.dark-mode .pagination .page-item.active .page-link {
            background: #4f46e5;
            border-color: #4f46e5;
            color: white;
        }

        body.dark-mode .pagination .page-item.disabled .page-link {
            background: #1e293b;
            border-color: #334155;
            color: #64748b;
        }

        body.dark-mode .alert {
            border-color: transparent;
        }

        body.dark-mode .alert-success {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        body.dark-mode .alert-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        body.dark-mode .alert-warning {
            background: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        body.dark-mode .alert-info {
            background: rgba(14, 165, 233, 0.2);
            color: #7dd3fc;
        }

        body.dark-mode .text-muted {
            color: #94a3b8 !important;
        }

        body.dark-mode .bg-white {
            background: #1e293b !important;
        }

        body.dark-mode .bg-light {
            background: #334155 !important;
        }

        body.dark-mode .bg-light-subtle {
            background: #334155 !important;
        }

        body.dark-mode .table-secondary {
            background: #334155 !important;
            color: #e2e8f0;
        }

        body.dark-mode .border {
            border-color: #334155 !important;
        }

        body.dark-mode .border-top {
            border-top-color: #334155 !important;
        }

        body.dark-mode .border-bottom {
            border-bottom-color: #334155 !important;
        }

        body.dark-mode .border-end {
            border-right-color: #334155 !important;
        }

        body.dark-mode .list-group-item {
            background: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }

        body.dark-mode .list-group-item:hover {
            background: #334155;
        }

        body.dark-mode .nav-tabs .nav-link {
            color: #94a3b8;
            border-color: transparent;
        }

        body.dark-mode .nav-tabs .nav-link:hover {
            color: #e2e8f0;
            border-color: #334155;
        }

        body.dark-mode .nav-tabs .nav-link.active {
            background: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }

        body.dark-mode .nav-pills .nav-link {
            color: #94a3b8;
        }

        body.dark-mode .nav-pills .nav-link.active {
            background: #4f46e5;
            color: white;
        }

        body.dark-mode .card {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .card-body {
            color: #e2e8f0;
        }

        body.dark-mode .card-header {
            background: #334155;
            border-bottom-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .card-footer {
            background: #334155;
            border-top-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
            --bs-table-accent-bg: #334155;
            color: #e2e8f0;
        }

        body.dark-mode .table-hover > tbody > tr:hover {
            --bs-table-accent-bg: #475569;
            color: #ffffff;
        }

        body.dark-mode input:-webkit-autofill,
        body.dark-mode input:-webkit-autofill:hover,
        body.dark-mode input:-webkit-autofill:focus {
            -webkit-text-fill-color: #e2e8f0;
            -webkit-box-shadow: 0 0 0px 1000px #334155 inset;
        }

        body.dark-mode ::placeholder {
            color: #64748b !important;
        }

        body.dark-mode .form-control:disabled,
        body.dark-mode .form-control[readonly] {
            background: #1e293b;
            opacity: 0.7;
        }

        body.dark-mode .input-group-text {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .btn-outline-secondary {
            border-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .btn-outline-secondary:hover {
            background: #475569;
            border-color: #64748b;
            color: #ffffff;
        }

        body.dark-mode .btn-outline-primary {
            color: #818cf8;
            border-color: #6366f1;
        }

        body.dark-mode .btn-outline-primary:hover {
            background: #4f46e5;
            color: white;
        }

        body.dark-mode .badge {
            color: #ffffff;
        }

        body.dark-mode .progress {
            background: #334155;
        }

        body.dark-mode .text-secondary {
            color: #94a3b8 !important;
        }

        body.dark-mode .table-responsive {
            background: transparent;
        }

        body.dark-mode .form-check-input {
            background-color: #334155;
            border-color: #475569;
        }

        body.dark-mode .form-check-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        body.dark-mode .form-check-label {
            color: #e2e8f0;
        }

        body.dark-mode .spinner-border-sm {
            border-color: rgba(255, 255, 255, 0.3);
            border-right-color: transparent;
        }

        body.dark-mode .vr {
            background: #334155;
        }

        /* Dark Mode - Page Specific */
        body.dark-mode .welcome-section {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: #e2e8f0;
        }

        body.dark-mode .welcome-title {
            color: #e2e8f0;
        }

        body.dark-mode .welcome-subtitle {
            color: #94a3b8;
        }

        body.dark-mode .badge-modern {
            background: rgba(79, 70, 229, 0.2);
            color: #818cf8;
        }

        body.dark-mode .stat-card {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .stat-card:hover {
            background: #334155;
            border-color: #475569;
        }

        body.dark-mode .stat-value {
            color: #e2e8f0;
        }

        body.dark-mode .stat-label {
            color: #94a3b8;
        }

        body.dark-mode .chart-card {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .chart-title {
            color: #e2e8f0;
        }

        body.dark-mode .chart-select {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .modern-table-card {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .modern-table-card .table-header-section {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
        }

        body.dark-mode .modern-table-card thead th {
            background: #334155;
            color: #e2e8f0;
            border-bottom-color: #475569;
        }

        body.dark-mode .modern-table-card tbody tr {
            background: #1e293b;
            border-bottom-color: #334155;
        }

        body.dark-mode .modern-table-card tbody tr:nth-child(even) {
            background: #1f2937;
        }

        body.dark-mode .modern-table-card tbody tr:hover {
            background: #334155;
        }

        body.dark-mode .modern-table-card td {
            color: #e2e8f0;
            border-bottom-color: #334155;
        }

        body.dark-mode .modern-table-card .table-footer {
            background: #334155;
            border-top-color: #475569;
        }

        body.dark-mode .table-header-gradient {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
        }

        body.dark-mode .header-icon {
            background: rgba(255, 255, 255, 0.1);
        }

        body.dark-mode .search-box input {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .search-box input:focus {
            border-color: #4f46e5;
            background: #334155;
        }

        body.dark-mode .search-box i {
            color: #94a3b8;
        }

        body.dark-mode .search-results {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .search-results a {
            border-bottom-color: #334155;
            color: #e2e8f0;
        }

        body.dark-mode .search-results a:hover {
            background: #334155;
        }

        body.dark-mode .import-section {
            background: #334155;
            border-bottom-color: #475569;
        }

        body.dark-mode .empty-state {
            background: #1e293b;
        }

        body.dark-mode .empty-icon {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            color: #94a3b8;
        }

        body.dark-mode .profile-upload-card {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .profile-header {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
        }

        body.dark-mode .profile-photo-placeholder {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            color: #94a3b8;
        }

        body.dark-mode .recycle-bin-section {
            background: rgba(239, 68, 68, 0.1);
            border-top-color: rgba(239, 68, 68, 0.3);
        }

        body.dark-mode .detail-section {
            background: #334155;
        }

        body.dark-mode .detail-card {
            background: #1e293b;
            border-color: #475569;
        }

        body.dark-mode .detail-label {
            color: #94a3b8;
        }

        body.dark-mode .detail-value {
            color: #e2e8f0;
        }

        body.dark-mode .form-section-title {
            color: #e2e8f0;
            border-bottom-color: #475569;
        }

        body.dark-mode .form-section-title i {
            color: #818cf8;
        }

        body.dark-mode .password-requirements {
            background: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.3);
        }

        body.dark-mode .req-item {
            color: #fcd34d;
        }

        body.dark-mode .req-item.met {
            color: #6ee7b7;
        }

        body.dark-mode .user-btn {
            background: #334155;
            border-color: #475569;
        }

        body.dark-mode .user-btn:hover {
            border-color: #4f46e5;
        }

        body.dark-mode .user-name {
            color: #e2e8f0;
        }

        body.dark-mode .toggle-btn {
            color: #e2e8f0;
        }

        body.dark-mode .page-title {
            color: #e2e8f0;
        }

        body.dark-mode .icon-box {
            background: rgba(79, 70, 229, 0.1);
            color: #818cf8;
        }

        body.dark-mode .product-info .product-avatar {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }

        body.dark-mode .product-name {
            color: #e2e8f0;
        }

        body.dark-mode .product-meta {
            color: #94a3b8;
        }

        body.dark-mode .serial-code {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            color: #94a3b8;
            border-color: #475569;
        }

        body.dark-mode .category-badge {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2) 0%, rgba(124, 58, 237, 0.2) 100%);
            color: #a5b4fc;
            border-color: rgba(79, 70, 229, 0.3);
        }

        body.dark-mode .location-text {
            color: #94a3b8;
        }

        body.dark-mode .price-value {
            color: #34d399;
        }

        body.dark-mode .warranty-active {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.2) 100%);
            color: #6ee7b7;
            border-color: rgba(16, 185, 129, 0.3);
        }

        body.dark-mode .warranty-expiring {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.2) 100%);
            color: #fcd34d;
            border-color: rgba(245, 158, 11, 0.3);
        }

        body.dark-mode .warranty-expired {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(239, 68, 68, 0.2) 100%);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.3);
        }

        body.dark-mode .warranty-none {
            color: #64748b;
        }

        body.dark-mode .role-badge {
            color: #e2e8f0;
        }

        body.dark-mode .role-superadmin {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(239, 68, 68, 0.2) 100%);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.3);
        }

        body.dark-mode .role-admin {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.2) 0%, rgba(14, 165, 233, 0.2) 100%);
            color: #7dd3fc;
            border-color: rgba(14, 165, 233, 0.3);
        }

        body.dark-mode .role-user {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2) 0%, rgba(124, 58, 237, 0.2) 100%);
            color: #a5b4fc;
            border-color: rgba(79, 70, 229, 0.3);
        }

        body.dark-mode .status-badge {
            color: #e2e8f0;
        }

        body.dark-mode .status-active {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.2) 100%);
            color: #6ee7b7;
            border-color: rgba(16, 185, 129, 0.3);
        }

        body.dark-mode .status-inactive {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            color: #94a3b8;
            border-color: #475569;
        }

        body.dark-mode .table-row:hover {
            background: #334155 !important;
        }

        body.dark-mode .btn-table-action {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .btn-table-action:hover {
            background: #475569;
            border-color: #64748b;
            color: #ffffff;
        }

        body.dark-mode .action-btn-view {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.2) 0%, rgba(14, 165, 233, 0.2) 100%);
            color: #7dd3fc;
        }

        body.dark-mode .action-btn-edit {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.2) 100%);
            color: #fcd34d;
        }

        body.dark-mode .action-btn-maintenance {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2) 0%, rgba(124, 58, 237, 0.2) 100%);
            color: #a5b4fc;
        }

        body.dark-mode .action-btn-delete {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(239, 68, 68, 0.2) 100%);
            color: #fca5a5;
        }

        body.dark-mode .form-label {
            color: #e2e8f0;
        }

        body.dark-mode .form-label-custom {
            color: #e2e8f0;
        }

        body.dark-mode .invalid-feedback {
            color: #fca5a5;
        }

        body.dark-mode .form-control.is-invalid {
            border-color: #ef4444;
        }

        body.dark-mode .toast {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .toast .toast-title {
            color: #e2e8f0;
        }

        body.dark-mode .toast .toast-message {
            color: #94a3b8;
        }

        /* Dashboard Components */
        body.dark-mode .quick-action-item {
            background: #334155;
            border-color: #475569;
        }

        body.dark-mode .quick-action-item:hover {
            background: #475569;
            border-color: #64748b;
        }

        body.dark-mode .quick-action-item span {
            color: #e2e8f0;
        }

        body.dark-mode .alert-list-item {
            background: #334155;
            border-color: #475569;
        }

        body.dark-mode .alert-list-item:hover {
            background: #475569;
        }

        body.dark-mode .list-icon {
            background: rgba(245, 158, 11, 0.2) !important;
        }

        body.dark-mode .alert-text {
            color: #e2e8f0;
        }

        body.dark-mode .alert-time {
            color: #94a3b8;
        }

        body.dark-mode .charts-grid {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .chart-body {
            background: #1e293b;
        }

        body.dark-mode .widget-body {
            background: #1e293b;
        }

        body.dark-mode .legend-item {
            color: #e2e8f0;
        }

        body.dark-mode .dashboard-widget {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .widget-title {
            color: #e2e8f0;
        }

        body.dark-mode .widget-icon {
            background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;
        }

        body.dark-mode .btn-toggle {
            background: #475569;
        }

        body.dark-mode .btn-toggle.active {
            background: #10b981;
        }

        body.dark-mode .btn-toggle::before {
            background: #e2e8f0;
        }

        body.dark-mode .toggle-slider {
            background: #e2e8f0;
        }

        body.dark-mode .recycle-bin-section {
            background: rgba(239, 68, 68, 0.1) !important;
            border-top-color: rgba(239, 68, 68, 0.3) !important;
        }

        body.dark-mode .table-light {
            background: #334155 !important;
            color: #e2e8f0;
        }

        body.dark-mode .bg-light.fw-bold.text-dark {
            background: #334155 !important;
            color: #e2e8f0 !important;
        }

        body.dark-mode .text-dark {
            color: #e2e8f0 !important;
        }

        body.dark-mode .text-white {
            color: #ffffff !important;
        }

        body.dark-mode .border {
            border-color: #334155 !important;
        }

        body.dark-mode .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.4) !important;
        }

        body.dark-mode .shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.4) !important;
        }

        body.dark-mode .card {
            background: #1e293b !important;
            border-color: #334155 !important;
        }

        body.dark-mode .card-header {
            background: #334155 !important;
            border-bottom-color: #475569 !important;
        }

        body.dark-mode .card-body {
            background: #1e293b !important;
            color: #e2e8f0;
        }

        body.dark-mode .btn-light {
            background: #475569 !important;
            border-color: #64748b !important;
            color: #e2e8f0 !important;
        }

        body.dark-mode .btn-light:hover {
            background: #64748b !important;
            border-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        body.dark-mode .btn-outline-dark {
            border-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .btn-outline-dark:hover {
            background: #475569;
            border-color: #64748b;
            color: #ffffff;
        }

        body.dark-mode .btn-close {
            filter: invert(1);
        }

        body.dark-mode code {
            background: #334155;
            color: #e2e8f0;
        }

        body.dark-mode .form-control-plaintext {
            color: #e2e8f0;
        }

        body.dark-mode .table-success {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #6ee7b7;
        }

        body.dark-mode .table-danger {
            background: rgba(239, 68, 68, 0.15) !important;
            color: #fca5a5;
        }

        body.dark-mode .table-warning {
            background: rgba(245, 158, 11, 0.15) !important;
            color: #fcd34d;
        }

        body.dark-mode .table-info {
            background: rgba(14, 165, 233, 0.15) !important;
            color: #7dd3fc;
        }

        body.dark-mode .input-group {
            background: #334155;
            border-radius: 8px;
        }

        body.dark-mode .input-group-text {
            background: #475569;
            border-color: #64748b;
            color: #e2e8f0;
        }

        body.dark-mode .accordion-button {
            background: #1e293b;
            color: #e2e8f0;
        }

        body.dark-mode .accordion-button:not(.collapsed) {
            background: #334155;
            color: #818cf8;
        }

        body.dark-mode .accordion-body {
            background: #1e293b;
            color: #e2e8f0;
        }

        body.dark-mode .accordion-item {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .btn-group .btn {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .btn-group .btn:hover {
            background: #475569;
            border-color: #64748b;
        }

        body.dark-mode .btn-group .btn.active {
            background: #4f46e5;
            border-color: #4f46e5;
            color: white;
        }

        body.dark-mode .page-item .page-link {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        body.dark-mode .page-item.active .page-link {
            background: #4f46e5;
            border-color: #4f46e5;
            color: white;
        }

        body.dark-mode .page-item.disabled .page-link {
            background: #1e293b;
            border-color: #334155;
            color: #64748b;
        }

        body.dark-mode .alert-heading {
            color: #e2e8f0;
        }

        body.dark-mode .list-group-item-action {
            background: #1e293b;
            color: #e2e8f0;
        }

        body.dark-mode .list-group-item-action:hover {
            background: #334155;
        }

        body.dark-mode .breadcrumb {
            background: #334155;
        }

        body.dark-mode .breadcrumb-item {
            color: #94a3b8;
        }

        body.dark-mode .breadcrumb-item.active {
            color: #e2e8f0;
        }

        body.dark-mode .breadcrumb-item + .breadcrumb-item::before {
            color: #64748b;
        }

        body.dark-mode .popover {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .popover-body {
            background: #1e293b;
            color: #e2e8f0;
        }

        body.dark-mode .popover-header {
            background: #334155;
            color: #e2e8f0;
            border-color: #475569;
        }

        body.dark-mode .bs-popover-start .popover-arrow::before {
            border-left-color: #334155;
        }

        body.dark-mode .bs-popover-end .popover-arrow::before {
            border-right-color: #334155;
        }

        body.dark-mode .bs-popover-top .popover-arrow::before {
            border-top-color: #334155;
        }

        body.dark-mode .bs-popover-bottom .popover-arrow::before {
            border-bottom-color: #334155;
        }

        body.dark-mode .tooltip-inner {
            background: #334155;
            color: #e2e8f0;
        }

        body.dark-mode .tooltip-arrow::before {
            border-top-color: #334155;
        }

        body.dark-mode .text-truncate {
            color: #e2e8f0;
        }

        body.dark-mode .visually-hidden {
            color: #64748b;
        }

        body.dark-mode .lh-1 {
            color: #e2e8f0;
        }

        body.dark-mode .display-1,
        body.dark-mode .display-2,
        body.dark-mode .display-3,
        body.dark-mode .display-4,
        body.dark-mode .display-5,
        body.dark-mode .display-6 {
            color: #e2e8f0;
        }

        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, 
        body.dark-mode h4, body.dark-mode h5, body.dark-mode h6 {
            color: #e2e8f0;
        }

        body.dark-mode p {
            color: #e2e8f0;
        }

        body.dark-mode a {
            color: #818cf8;
        }

        body.dark-mode a:hover {
            color: #a5b4fc;
        }

        body.dark-mode hr {
            border-color: #334155;
        }

        body.dark-mode mark, body.dark-mode .mark {
            background: rgba(245, 158, 11, 0.3);
            color: #fcd34d;
        }

        body.dark-mode .bg-gradient {
            background: linear-gradient(135deg, #334155 0%, #475569 100%) !important;
        }

        body.dark-mode .bg-body {
            background: #0f172a !important;
        }

        body.dark-mode .bg-transparent {
            background: transparent !important;
        }

        body.dark-mode .link-dark {
            color: #e2e8f0 !important;
        }

        body.dark-mode .link-secondary {
            color: #94a3b8 !important;
        }

        body.dark-mode .link-success {
            color: #6ee7b7 !important;
        }

        body.dark-mode .link-danger {
            color: #fca5a5 !important;
        }

        body.dark-mode .link-warning {
            color: #fcd34d !important;
        }

        body.dark-mode .link-info {
            color: #7dd3fc !important;
        }

        body.dark-mode .link-light {
            color: #e2e8f0 !important;
        }
    </style>
    
    <!-- Theme Toggle Script -->
    <script>
        // Check saved theme on load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
                document.getElementById('themeIcon').classList.remove('bi-moon-stars');
                document.getElementById('themeIcon').classList.add('bi-sun');
            }
        });
        
        function toggleTheme() {
            const body = document.body;
            const icon = document.getElementById('themeIcon');
            
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                icon.classList.remove('bi-moon-stars');
                icon.classList.add('bi-sun');
            } else {
                localStorage.setItem('theme', 'light');
                icon.classList.remove('bi-sun');
                icon.classList.add('bi-moon-stars');
            }
        }
    </script>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Scripts -->
    <script src="{{ asset('js/custom.js') }}"></script>
    
    <script>
        // Toggle Sidebar - Collapse/Expand
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const isDesktop = window.innerWidth >= 992;
            
            if (isDesktop) {
                // Desktop: toggle between collapsed (icons only) and expanded
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
            } else {
                // Mobile: slide in/out
                sidebar.classList.toggle('open');
                const overlay = document.querySelector('.sidebar-overlay');
                overlay.classList.toggle('active');
            }
            
            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        }
        
        // Initialize sidebar state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const isDesktop = window.innerWidth >= 992;
            
            // Check localStorage for saved state
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true' && isDesktop) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                const nowDesktop = window.innerWidth >= 992;
                if (nowDesktop) {
                    // On desktop, remove mobile open state
                    sidebar.classList.remove('open');
                    const overlay = document.querySelector('.sidebar-overlay');
                    if (overlay) overlay.classList.remove('active');
                }
            });
        });
        
        // Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "4000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        
        // Display Toastr notifications from session
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                toastr.success('{{ strip_tags(session('success')) }}', 'Success');
            @endif
            
            @if(session('error'))
                toastr.error('{{ strip_tags(session('error')) }}', 'Error');
            @endif
            
            @if(session('warning'))
                toastr.warning('{{ strip_tags(session('warning')) }}', 'Warning');
            @endif
            
            @if(session('message'))
                toastr.info('{{ strip_tags(session('message')) }}', 'Info');
            @endif
        });
    </script>
    
    @stack('scripts')
</body>
</html>