/**
 * Dark Mode JavaScript
 * Theme Toggle Functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check saved theme on load
    var savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        var themeIcon = document.getElementById('themeIcon');
        if (themeIcon) {
            themeIcon.classList.remove('bi-moon-stars');
            themeIcon.classList.add('bi-sun');
        }
    }

    // Theme Toggle Function
    window.toggleTheme = function() {
        var body = document.body;
        var icon = document.getElementById('themeIcon');
        
        body.classList.toggle('dark-mode');
        
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
            if (icon) {
                icon.classList.remove('bi-moon-stars');
                icon.classList.add('bi-sun');
            }
        } else {
            localStorage.setItem('theme', 'light');
            if (icon) {
                icon.classList.remove('bi-sun');
                icon.classList.add('bi-moon-stars');
            }
        }
    };
});