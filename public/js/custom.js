/**
 * Custom JavaScript for Product Inventory
 * Bootstrap 5 Custom Theme
 */

document.addEventListener('DOMContentLoaded', function() {
    // ===================================
    // Live Search Functionality
    // ===================================
    const liveSearch = document.getElementById('liveSearch');
    const searchResults = document.getElementById('searchResults');
    const searchForm = document.getElementById('searchForm');
    const searchHiddenInput = document.getElementById('searchInput');
    let debounceTimer;

    if (liveSearch) {
        document.addEventListener('click', function(e) {
            if (!liveSearch.contains(e.target) && searchResults && !searchResults.contains(e.target)) {
                searchResults.classList.remove('show');
            }
        });

        liveSearch.addEventListener('keyup', function() {
            const query = this.value.trim();
            clearTimeout(debounceTimer);
            
            if (query.length < 2) {
                if (searchResults) searchResults.classList.remove('show');
                return;
            }

            debounceTimer = setTimeout(function() {
                fetch('/products/search?q=' + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        if (searchResults) {
                            if (data.length === 0) {
                                searchResults.innerHTML = '<div class="p-3 text-muted text-center">No products found</div>';
                            } else {
                                searchResults.innerHTML = data.map(product => `
                                    <a href="/products/${product.id}" class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold text-dark">${product.product_name}</div>
                                            <small class="text-muted">${product.serial_no || 'No serial'}</small>
                                        </div>
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    </a>
                                `).join('');
                            }
                            searchResults.classList.add('show');
                        }
                    })
                    .catch(error => console.error('Search error:', error));
            }, 300);
        });

        liveSearch.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (searchHiddenInput && searchForm) {
                    searchHiddenInput.value = liveSearch.value;
                    searchForm.submit();
                }
            }
        });
    }

    // ===================================
    // Sidebar Toggle - Only on mobile
    // ===================================
    window.toggleSidebar = function() {
        if (window.innerWidth < 992) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (sidebar) {
                sidebar.classList.toggle('open');
            }
            if (overlay) {
                overlay.classList.toggle('active');
            }
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
    // Auto-hide alerts after 5 seconds (except password requirements)
    // ===================================
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            // Skip password requirements alerts - they should stay visible
            if (alert.classList.contains('password-requirements')) return;
            if (alert.textContent && alert.textContent.includes('Password Requirements')) return;
            
            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
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

// ===================================
// Toastr Helper Functions
// ===================================
window.showToast = function(type, message, title = '') {
    const toastTypes = {
        'success': toastr.success,
        'error': toastr.error,
        'warning': toastr.warning,
        'info': toastr.info
    };
    
    if (toastTypes[type]) {
        toastTypes[type](message, title);
    }
};

// Convenience methods
window.toastSuccess = function(message, title = 'Success') {
    toastr.success(message, title);
};

window.toastError = function(message, title = 'Error') {
    toastr.error(message, title);
};

window.toastWarning = function(message, title = 'Warning') {
    toastr.warning(message, title);
};

window.toastInfo = function(message, title = 'Info') {
    toastr.info(message, title);
};