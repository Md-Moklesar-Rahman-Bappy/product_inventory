<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php
        $appName = \App\Models\Setting::get('app_name', 'Product Inventory');
        $faviconPath = \App\Models\Setting::get('favicon_path');
        $faviconUrl = asset('favicon.ico');
        if (!empty($faviconPath) && \Illuminate\Support\Facades\Storage::disk('public')->exists($faviconPath)) {
            $faviconUrl = Storage::url($faviconPath);
        }
        $faviconUrl = $faviconUrl . '?v=' . filemtime(public_path('favicon.ico'));
    ?>
    <title><?php echo e($appName); ?> - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
    
    <!-- Favicon - must be first -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e($faviconUrl); ?>">
    <link rel="icon" href="<?php echo e($faviconUrl); ?>" type="image/x-icon">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
    
    <!-- Page-specific styles -->
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?php echo e(route('dashboard')); ?>" class="brand">
                <i class="bi bi-box-seam-fill"></i>
                <span><?php echo e($appName); ?></span>
            </a>
            <button class="close-btn d-md-none" onclick="toggleSidebar()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                
                <li class="nav-item">
                    <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                        <i class="bi bi-grid-1x2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                
                <li class="nav-item">
                    <a href="<?php echo e(route('activity.logs')); ?>" class="nav-link <?php echo e(request()->routeIs('activity.logs') ? 'active' : ''); ?>">
                        <i class="bi bi-clock-history"></i>
                        <span>Activity Log</span>
                    </a>
                </li>
                
                
                <?php if(in_array(auth()->user()->permission, [0, 1])): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('categories.index')); ?>" class="nav-link <?php echo e(request()->routeIs('categories.*') ? 'active' : ''); ?>">
                        <i class="bi bi-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('brands.index')); ?>" class="nav-link <?php echo e(request()->routeIs('brands.*') ? 'active' : ''); ?>">
                        <i class="bi bi-award"></i>
                        <span>Brands</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('models.index')); ?>" class="nav-link <?php echo e(request()->routeIs('models.*') ? 'active' : ''); ?>">
                        <i class="bi bi-layers"></i>
                        <span>Models</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('products.index')); ?>" class="nav-link <?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>">
                        <i class="bi bi-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                
                
                <li class="nav-item">
                    <a href="<?php echo e(route('warranties.index')); ?>" class="nav-link <?php echo e(request()->routeIs('warranties.*') ? 'active' : ''); ?>">
                        <i class="bi bi-shield-check"></i>
                        <span>Warranty</span>
                    </a>
                </li>
                
                
                <li class="nav-item">
                    <a href="<?php echo e(route('maintenance.index')); ?>" class="nav-link <?php echo e(request()->routeIs('maintenance.*') ? 'active' : ''); ?>">
                        <i class="bi bi-tools"></i>
                        <span>Maintenance</span>
                    </a>
                </li>
                <?php endif; ?>
                
                
                <?php if(auth()->user()->permission === 0): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
                        <i class="bi bi-person-plus"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('settings.index')); ?>" class="nav-link <?php echo e(request()->routeIs('settings.*') ? 'active' : ''); ?>">
                        <i class="bi bi-gear"></i>
                        <span>Application Settings</span>
                    </a>
                </li>
                <?php endif; ?>
                
                
                <li class="nav-item">
                    <a href="<?php echo e(route('profile')); ?>" class="nav-link <?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">
                        <img src="<?php echo e(auth()->user()->profile_photo_url); ?>" alt="Profile" class="user-avatar-sm">
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
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
                        <h1 class="page-title"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
                    </div>
                    <div class="col-auto d-flex align-items-center gap-2">
                        <!-- Global Search -->
                        <div class="global-search d-none d-lg-block">
                            <form action="<?php echo e(route('products.index')); ?>" method="GET" class="d-flex">
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
                                    <img src="<?php echo e(auth()->user()->profile_photo_url); ?>" alt="Profile" class="user-avatar">
                                    <span class="user-name d-none d-md-inline"><?php echo e(auth()->user()->name); ?></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?php echo e(route('profile')); ?>"><i class="bi bi-person"></i> Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
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
                <?php echo $__env->yieldContent('contents'); ?>
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
                        <?php
                            $address = \App\Models\Setting::get('address');
                        ?>
                        <?php if($address): ?>
                            <p class="mb-0 small text-muted mt-1">
                                <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                <?php echo e($address); ?>

                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <?php
                            $website = \App\Models\Setting::get('website');
                            $footerCredit = \App\Models\Setting::get('footer_credit', 'DLRS SOCDS Project');
                            $phone = \App\Models\Setting::get('phone');
                            $email = \App\Models\Setting::get('email');
                        ?>
                        <?php if($website): ?>
                            <a href="<?php echo e($website); ?>" target="_blank" class="text-muted text-decoration-none me-3"><?php echo e($footerCredit); ?></a>
                        <?php else: ?>
                            <span class="text-muted me-3"><?php echo e($footerCredit); ?></span>
                        <?php endif; ?>
                        <?php if($phone): ?>
                            <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="text-muted text-decoration-none me-3">
                                <i class="fas fa-phone-alt me-1"></i><?php echo e($phone); ?>

                            </a>
                        <?php endif; ?>
                        <?php if($email): ?>
                            <a href="mailto:<?php echo e($email); ?>" class="text-muted text-decoration-none">
                                <i class="fas fa-envelope me-1"></i><?php echo e($email); ?>

                            </a>
                        <?php endif; ?>
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
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>
    
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
            <?php if(session('success')): ?>
                toastr.success('<?php echo e(strip_tags(session('success'))); ?>', 'Success');
            <?php endif; ?>
            
            <?php if(session('error')): ?>
                toastr.error('<?php echo e(strip_tags(session('error'))); ?>', 'Error');
            <?php endif; ?>
            
            <?php if(session('warning')): ?>
                toastr.warning('<?php echo e(strip_tags(session('warning'))); ?>', 'Warning');
            <?php endif; ?>
            
            <?php if(session('message')): ?>
                toastr.info('<?php echo e(strip_tags(session('message'))); ?>', 'Info');
            <?php endif; ?>
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\bug-fixes\resources\views/layouts/app.blade.php ENDPATH**/ ?>