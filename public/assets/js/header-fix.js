/**
 * Header Navigation Fix
 * Fixes z-index conflicts, event listener issues, and overlay problems
 */

(function() {
    'use strict';

    // Ensure side-overlay is properly hidden on page load
    document.addEventListener('DOMContentLoaded', function() {
        const sideOverlay = document.querySelector('.side-overlay');
        const overlay = document.querySelector('.overlay');

        // Force initial state
        if (sideOverlay) {
            sideOverlay.style.visibility = 'hidden';
            sideOverlay.style.opacity = '0';
            sideOverlay.style.pointerEvents = 'none';
        }

        if (overlay) {
            overlay.style.visibility = 'hidden';
            overlay.style.opacity = '0';
            overlay.style.pointerEvents = 'none';
        }

        // Ensure body overflow is reset
        document.body.style.overflow = '';
    });

    // Fix overlay state on window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // If screen is larger than mobile breakpoint, ensure overlays are hidden
            if (window.innerWidth > 991) {
                const sideOverlay = document.querySelector('.side-overlay');
                const overlay = document.querySelector('.overlay');
                const mobileMenu = document.querySelector('.mobile-menu');

                if (sideOverlay) {
                    sideOverlay.style.visibility = 'hidden';
                    sideOverlay.style.opacity = '0';
                    sideOverlay.style.pointerEvents = 'none';
                }

                if (overlay) {
                    overlay.style.visibility = 'hidden';
                    overlay.style.opacity = '0';
                    overlay.style.pointerEvents = 'none';
                }

                if (mobileMenu) {
                    mobileMenu.style.transform = 'translateX(-100%)';
                }

                // Reset body overflow
                document.body.style.overflow = '';
            }
        }, 250);
    });

    // Prevent event propagation on navigation links
    document.querySelectorAll('.nav-menu__link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Don't prevent default for dropdown toggles
            if (this.getAttribute('href') !== 'javascript:void(0)') {
                // Let the link work normally
                return true;
            }
        });
    });

    // Ensure submenu links work properly
    document.querySelectorAll('.nav-submenu__link, .submenu-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Ensure the link works
            if (this.getAttribute('href') && this.getAttribute('href') !== '#' && this.getAttribute('href') !== 'javascript:void(0)') {
                // Allow navigation
                return true;
            }
        });
    });

})();
