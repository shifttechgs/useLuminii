/**
 * Work Portfolio JavaScript
 * Handles filtering, animations, and interactions for the portfolio page
 */

(function() {
    'use strict';

    console.log('Portfolio JS loaded');

    // Check if we're on mobile
    const isMobile = window.innerWidth <= 768;

    /**
     * Utility: Throttle function
     */
    function throttle(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    /**
     * Filter Functionality
     */
    class PortfolioFilter {
        constructor() {
            this.filterButtons = document.querySelectorAll('.filter-btn');
            this.portfolioItems = document.querySelectorAll('.portfolio-item');
            this.currentFilter = 'all';
            this.isAnimating = false;

            console.log('Filter buttons found:', this.filterButtons.length);
            console.log('Portfolio items found:', this.portfolioItems.length);

            this.init();
        }

        init() {
            if (!this.filterButtons.length || !this.portfolioItems.length) {
                console.warn('Filter buttons or portfolio items not found');
                return;
            }

            // Bind event listeners
            this.filterButtons.forEach(btn => {
                btn.addEventListener('click', (e) => this.handleFilter(e));
            });

            console.log('Filter initialized successfully');
        }

        handleFilter(e) {
            e.preventDefault();

            if (this.isAnimating) {
                console.log('Animation in progress, skipping');
                return;
            }

            const button = e.currentTarget;
            const filter = button.getAttribute('data-filter');

            console.log('Filter clicked:', filter);

            // Update active state
            this.filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Store current filter
            this.currentFilter = filter;

            // Filter projects
            this.filterProjects(filter);
        }

        filterProjects(filter) {
            console.log('Filtering projects with:', filter);
            this.isAnimating = true;

            // Use CSS-based filtering for reliability
            this.filterWithCSS(filter);

            // Reset animation flag after transition
            setTimeout(() => {
                this.isAnimating = false;
            }, 500);
        }

        filterWithCSS(filter) {
            let visibleCount = 0;

            this.portfolioItems.forEach((item, index) => {
                const category = item.getAttribute('data-category');
                const shouldShow = filter === 'all' || category === filter;

                console.log(`Item ${index}: category=${category}, filter=${filter}, shouldShow=${shouldShow}`);

                if (shouldShow) {
                    visibleCount++;
                    // Fade in
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, index * 50);
                } else {
                    // Fade out
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });

            console.log(`Visible items: ${visibleCount}`);
        }
    }

    /**
     * Sticky Filter Bar
     */
    class StickyFilter {
        constructor() {
            this.filterSection = document.getElementById('filterControls');
            this.heroSection = document.querySelector('.work-hero');

            this.init();
        }

        init() {
            if (!this.filterSection || !this.heroSection) {
                console.warn('Filter section or hero section not found');
                return;
            }

            window.addEventListener('scroll', throttle(() => this.handleScroll(), 100));
            console.log('Sticky filter initialized');
        }

        handleScroll() {
            const heroBottom = this.heroSection.offsetTop + this.heroSection.offsetHeight;
            const scrollPosition = window.scrollY;

            if (scrollPosition > heroBottom) {
                this.filterSection.classList.add('scrolled');
            } else {
                this.filterSection.classList.remove('scrolled');
            }
        }
    }

    /**
     * Counter Animation
     */
    class CounterAnimation {
        constructor() {
            this.counters = document.querySelectorAll('.stat-item__number');
            this.animated = false;

            this.init();
        }

        init() {
            if (!this.counters.length) {
                console.warn('Counter elements not found');
                return;
            }

            // Use Intersection Observer for better performance
            const observer = new IntersectionObserver(
                (entries) => this.handleIntersection(entries),
                { threshold: 0.5 }
            );

            this.counters.forEach(counter => observer.observe(counter));
            console.log('Counter animation initialized');
        }

        handleIntersection(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.animated) {
                    this.animated = true;
                    this.animateCounters();
                }
            });
        }

        animateCounters() {
            this.counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000; // 2 seconds
                const increment = target / (duration / 16); // 60fps
                let current = 0;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                        // Add % or + suffix if needed
                        const label = counter.nextElementSibling.textContent.toLowerCase();
                        if (label.includes('satisfaction')) {
                            counter.textContent = target + '%';
                        } else if (label.includes('hour')) {
                            counter.textContent = target + 'hr';
                        } else {
                            counter.textContent = target + '+';
                        }
                    }
                };

                requestAnimationFrame(updateCounter);
            });
        }
    }

    /**
     * Lazy Loading Images
     */
    class LazyImageLoader {
        constructor() {
            this.images = document.querySelectorAll('.project-card__image img[loading="lazy"]');

            this.init();
        }

        init() {
            if (!this.images.length) return;

            // Use native lazy loading if supported
            if ('loading' in HTMLImageElement.prototype) {
                console.log('Using native lazy loading');
                return;
            }

            // Fallback to Intersection Observer
            console.log('Using Intersection Observer for lazy loading');
            const observer = new IntersectionObserver(
                (entries) => this.handleIntersection(entries),
                { rootMargin: '200px' }
            );

            this.images.forEach(img => {
                observer.observe(img);
                // Store the actual src in a data attribute
                img.setAttribute('data-src', img.src);
                img.src = '';
            });
        }

        handleIntersection(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.getAttribute('data-src');
                    img.removeAttribute('data-src');
                    entry.target.classList.add('loaded');
                }
            });
        }
    }

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
     * Add transition styles to portfolio items
     */
    function addTransitionStyles() {
        const style = document.createElement('style');
        style.textContent = `
            .portfolio-item {
                opacity: 1;
                transform: scale(1);
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Initialize all modules when DOM is ready
     */
    function initPortfolio() {
        console.log('Initializing portfolio...');

        // Add transition styles
        addTransitionStyles();

        // Initialize filter functionality
        const portfolioFilter = new PortfolioFilter();

        // Initialize sticky filter bar
        const stickyFilter = new StickyFilter();

        // Initialize counter animations
        const counterAnimation = new CounterAnimation();

        // Initialize lazy image loading
        const lazyImageLoader = new LazyImageLoader();

        // Initialize smooth scroll
        const smoothScroll = new SmoothScroll();

        console.log('Portfolio initialized successfully');
    }

    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPortfolio);
    } else {
        initPortfolio();
    }

})();
