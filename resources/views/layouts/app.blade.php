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
    
    <style>
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
        
</style>
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