// Import Bootstrap (includes Popper)
import "bootstrap";

import "@fortawesome/fontawesome-free/css/all.min.css";

// Import custom CSS or SCSS
import "../css/app.css"; // Or use '../sass/app.scss' if you're using SCSS

// Font Awesome (icons)
import "@fortawesome/fontawesome-free/css/all.min.css";

// Animate.css (for UI transitions)
import "animate.css";

// Alpine.js (lightweight interactivity)
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

// jQuery (optional, only if needed for legacy Bootstrap plugins)
import $ from "jquery";
window.$ = $;

/**
 * ========================================
 * SOCDS Project - Dashboard JavaScript
 * Department of Land Record and Survey
 * ========================================
 */

// Dashboard Utilities Object
const Dashboard = {

    /**
     * Initialize all dashboard functionality
     */
    init: function() {
        this.initTooltips();
        this.initToggleDescription();
        this.initAutoRefresh();
        this.initTableEnhancements();
        console.log('Dashboard initialized successfully');
    },

    /**
     * Initialize Bootstrap tooltips (Enhanced version)
     */
    initTooltips: function() {
        // Check if Bootstrap is available
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    boundary: 'viewport',
                    placement: 'top',
                    trigger: 'hover focus'
                });
            });
            console.log(`Dashboard: Initialized ${tooltipList.length} tooltips`);
        } else {
            console.warn('Bootstrap is not available. Tooltips will not work.');
        }
    },

    /**
     * Initialize toggle description functionality
     */
    initToggleDescription: function() {
        // Make function available globally for onclick handlers
        window.toggleDescription = function(button) {
            try {
                const container = button.closest('.description-content');
                const fullText = button.getAttribute('data-full-text');

                if (!container || !fullText) {
                    console.error('Toggle description: Missing required elements');
                    return;
                }

                if (button.textContent.includes('Show more')) {
                    // Show full text
                    container.innerHTML = fullText + ' <button class="btn btn-link btn-sm p-0 text-decoration-none" onclick="toggleDescription(this)" data-full-text="' +
                        fullText.replace(/'/g, '&#39;') + '"><small>Show less...</small></button>';
                } else {
                    // Show truncated text
                    const truncatedText = fullText.replace(/<[^>]*>/g, '').substring(0, 100);
                    container.innerHTML = truncatedText + '... <button class="btn btn-link btn-sm p-0 text-decoration-none" onclick="toggleDescription(this)" data-full-text="' +
                        fullText.replace(/'/g, '&#39;') + '"><small>Show more...</small></button>';
                }
            } catch (error) {
                console.error('Error in toggleDescription:', error);
            }
        };
    },

    /**
     * Initialize auto-refresh functionality (optional)
     */
    initAutoRefresh: function() {
        // Auto-refresh activity logs every 5 minutes (disabled by default)
        // Uncomment the next lines to enable auto-refresh
        /*
        const refreshInterval = 5 * 60 * 1000; // 5 minutes in milliseconds
        setInterval(function() {
            if (confirm('Refresh the page to get latest activity logs?')) {
                window.location.reload();
            }
        }, refreshInterval);
        console.log('Auto-refresh enabled (5 minutes interval)');
        */
    },

    /**
     * Enhanced table functionality
     */
    initTableEnhancements: function() {
        // Add loading state to tables during refresh
        const tables = document.querySelectorAll('.table-responsive');

        tables.forEach(table => {
            // Add click handlers for row interactions
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('click', function(e) {
                    // Don't trigger if clicking on buttons or links
                    if (e.target.closest('button, a')) return;

                    // Add selection highlight
                    rows.forEach(r => r.classList.remove('table-active'));
                    this.classList.add('table-active');
                });
            });
        });

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Clear all selections
                document.querySelectorAll('.table-active').forEach(row => {
                    row.classList.remove('table-active');
                });
            }
        });
    },

    /**
     * Utility function to show loading state
     */
    showLoading: function(element) {
        if (element) {
            element.classList.add('loading');
        }
    },

    /**
     * Utility function to hide loading state
     */
    hideLoading: function(element) {
        if (element) {
            element.classList.remove('loading');
        }
    },

    /**
     * Utility function to refresh activity logs via AJAX (if needed)
     */
    refreshActivityLogs: function() {
        const logsContainer = document.querySelector('.card-body .table-responsive');
        if (!logsContainer) return;

        this.showLoading(logsContainer);

        // Example AJAX call (uncomment and modify as needed)
        /*
        fetch(window.location.href + '?ajax=1')
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newLogsContainer = doc.querySelector('.card-body .table-responsive');

                if (newLogsContainer) {
                    logsContainer.innerHTML = newLogsContainer.innerHTML;
                    this.initTooltips(); // Reinitialize tooltips for new content
                }
            })
            .catch(error => {
                console.error('Error refreshing logs:', error);
            })
            .finally(() => {
                this.hideLoading(logsContainer);
            });
        */
    }
};

// Tooltip initialization (Bootstrap) - Enhanced version
document.addEventListener("DOMContentLoaded", () => {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.forEach((tooltipTriggerEl) => {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize Dashboard
    Dashboard.init();
});

// Toast auto-dismiss (Bootstrap)
document.addEventListener("DOMContentLoaded", () => {
    const toastElList = [].slice.call(document.querySelectorAll(".toast"));
    toastElList.forEach((toastEl) => {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
});

// Product Table Tooltips (for title attributes)
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips for elements with title attributes (for product table)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            placement: 'top',
            trigger: 'hover'
        });
    });

    // Initialize tooltips for elements with data-bs-toggle="tooltip"
    var bsTooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var bsTooltipList = bsTooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Enhanced table row interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations to table rows
    const tableRows = document.querySelectorAll('.product-table tbody tr');

    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.2s ease-in-out';
        });

        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
});

// Search functionality enhancements
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');

    if (searchInput) {
        // Add search input animations
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 0.2s ease';
        });

        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });

        // Clear search functionality
        const clearSearch = document.createElement('button');
        clearSearch.innerHTML = '<i class="fas fa-times"></i>';
        clearSearch.className = 'btn btn-outline-secondary btn-sm ms-1';
        clearSearch.type = 'button';
        clearSearch.title = 'Clear search';
        clearSearch.style.display = searchInput.value ? 'inline-block' : 'none';

        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            window.location.href = window.location.pathname;
        });

        searchInput.addEventListener('input', function() {
            clearSearch.style.display = this.value ? 'inline-block' : 'none';
        });

        // Insert clear button after search button
        const searchButton = searchInput.parentElement.querySelector('button[type="submit"]');
        if (searchButton) {
            searchButton.parentElement.insertBefore(clearSearch, searchButton.nextSibling);
        }
    }
});

// Alert auto-dismiss enhancement
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-dismissible');

    alerts.forEach(alert => {
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const closeButton = alert.querySelector('.btn-close');
            if (closeButton && alert.classList.contains('show')) {
                closeButton.click();
            }
        }, 5000);

        // Add fade-out animation
        alert.addEventListener('close.bs.alert', function() {
            this.style.transition = 'opacity 0.3s ease';
            this.style.opacity = '0';
        });
    });
});

// Confirmation dialogs enhancement
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('form[onsubmit*="confirm"] button[type="submit"]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Create custom confirmation dialog
            const productName = this.closest('tr')?.querySelector('.tooltip-cell')?.textContent?.trim() || 'this item';

            if (confirm(`Are you sure you want to delete "${productName}"? This action cannot be undone.`)) {
                this.closest('form').submit();
            }
        });

        // Remove the inline onsubmit handler since we're handling it with JavaScript
        const form = button.closest('form');
        if (form) {
            form.removeAttribute('onsubmit');
        }
    });
});

// Loading states for buttons
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitButton.disabled = true;

                // Re-enable button after 3 seconds (fallback)
                setTimeout(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }, 3000);
            }
        });
    });
});

/**
 * ========================================
 * Additional Utility Functions
 * ========================================
 */

/**
 * Debounce function to limit function calls
 */
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction() {
        const context = this;
        const args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

/**
 * Copy text to clipboard utility
 */
function copyToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
        return navigator.clipboard.writeText(text);
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
        } catch (err) {
            console.error('Unable to copy to clipboard', err);
        }
        document.body.removeChild(textArea);
    }
}

// Make Dashboard available globally
window.Dashboard = Dashboard;

// Export Dashboard object for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Dashboard;
}

// Optional: Custom JS scripts
// import './custom'; // Add your own JS logic here

console.log("App.js loaded successfully with Dashboard enhancements");
