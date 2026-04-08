/**
 * Custom JavaScript for Product Inventory
 * Bootstrap 5 Custom Theme
 */

document.addEventListener('DOMContentLoaded', function() {
    // ===================================
    // Sidebar Toggle
    // ===================================
    window.toggleSidebar = function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (window.innerWidth < 992) {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }
    };

    // ===================================
    // Close sidebar on Escape key
    // ===================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (sidebar && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        }
    });

    // ===================================
    // Auto-hide alerts after 5 seconds
    // ===================================
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(function(alert) {
            if (bootstrap && bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } else {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }
        });
    }, 5000);

    // ===================================
    // Delete Confirmation (SweetAlert2)
    // ===================================
    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const title = this.getAttribute('data-title') || 'Are you sure?';
            const text = this.getAttribute('data-text') || 'This action cannot be undone.';
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            } else {
                if (confirm(text)) {
                    form.submit();
                }
            }
        });
    });

    // ===================================
    // Form Submit Loading State
    // ===================================
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitBtn && !submitBtn.classList.contains('no-loading')) {
                submitBtn.disabled = true;
                
                // Add spinner
                const originalHTML = submitBtn.innerHTML;
                submitBtn.setAttribute('data-original-text', originalHTML);
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...';
                
                // Re-enable after 10 seconds as fallback
                setTimeout(function() {
                    if (submitBtn.disabled) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHTML;
                    }
                }, 10000);
            }
        });
    });

    // ===================================
    // Dropdown close on click outside
    // ===================================
    document.addEventListener('click', function(e) {
        const dropdowns = document.querySelectorAll('.dropdown-menu.show');
        dropdowns.forEach(function(dropdown) {
            if (!dropdown.contains(e.target) && !dropdown.previousElementSibling.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    });

    // ===================================
    // Tooltip initialization
    // ===================================
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // ===================================
    // Per-page selector for pagination
    // ===================================
    window.updateQueryStringParameter = function(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        return url.toString();
    };

    // ===================================
    // Search filter auto-submit
    // ===================================
    const filterSelects = document.querySelectorAll('[data-auto-submit]');
    filterSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });

    // ===================================
    // Mobile table scroll indicator
    // ===================================
    const tables = document.querySelectorAll('.table-responsive');
    tables.forEach(function(container) {
        if (container.scrollWidth > container.clientWidth) {
            container.classList.add('has-scroll');
        }
    });

    // ===================================
    // Active menu highlighting based on current route
    // ===================================
    const currentPath = window.location.pathname;
    document.querySelectorAll('.sidebar-nav .nav-link').forEach(function(link) {
        const linkPath = new URL(link.href).pathname;
        if (currentPath === linkPath || currentPath.startsWith(linkPath + '/')) {
            link.classList.add('active');
        }
    });

    // ===================================
    // Handle window resize
    // ===================================
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }
    });
});