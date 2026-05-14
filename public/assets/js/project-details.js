/**
 * Project Details Page JavaScript
 * Handles smooth scrolling and animations
 */

(function() {
    'use strict';

    console.log('Project details JS loaded');

    /**
     * Smooth Scroll to Anchor
     */
    class SmoothScroll {
        constructor() {
            this.links = document.querySelectorAll('a[href^="#"]');
            this.init();
        }

        init() {
            if (!this.links.length) return;

            this.links.forEach(link => {
                link.addEventListener('click', (e) => this.handleClick(e));
            });
        }

        handleClick(e) {
            const href = e.currentTarget.getAttribute('href');

            if (href === '#') return;

            const target = document.querySelector(href);
            if (!target) return;

            e.preventDefault();

            const offsetTop = target.offsetTop - 100; // Account for sticky header

            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    }

    /**
     * Initialize when DOM is ready
     */
    function initProjectDetails() {
        console.log('Initializing project details...');

        // Initialize smooth scroll
        new SmoothScroll();

        console.log('Project details initialized successfully');
    }

    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProjectDetails);
    } else {
        initProjectDetails();
    }

})();
