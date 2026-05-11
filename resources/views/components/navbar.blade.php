<nav class="lp-nav" id="lp-nav">
    <div class="lp-nav__inner">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="lp-nav__logo">
            <div class="lp-nav__logo-mark">L</div>
            useLuminii
        </a>

        <!-- Links -->
        <div class="lp-nav__links">
            <a href="{{ url('/') }}#features" class="lp-nav__link">Features</a>
            <a href="{{ url('/') }}#process" class="lp-nav__link">How it works</a>
            <a href="{{ url('/') }}#pricing" class="lp-nav__link">Pricing</a>
            <a href="{{ url('/') }}#faq" class="lp-nav__link">FAQ</a>
        </div>

        <!-- Right -->
        <div class="lp-nav__right">
            <a href="{{ url('/') }}#booking" class="lp-btn lp-btn--primary lp-btn--sm" style="display:none;" id="lp-nav-cta">
                Book a Demo
            </a>
            <button class="lp-nav__mobile-btn" id="lp-menu-btn" aria-label="Open menu">
                <i class="ph ph-list"></i>
            </button>
        </div>

    </div>
</nav>

<!-- Mobile menu -->
<div class="lp-mobile-menu" id="lp-mobile-menu">
    <a href="{{ url('/') }}#features" class="lp-mobile-link">Features</a>
    <a href="{{ url('/') }}#process" class="lp-mobile-link">How it works</a>
    <a href="{{ url('/') }}#pricing" class="lp-mobile-link">Pricing</a>
    <a href="{{ url('/') }}#faq" class="lp-mobile-link">FAQ</a>
    <a href="{{ url('/') }}#booking" class="lp-btn lp-btn--primary" style="margin-top:8px;justify-content:center;">Book a Demo →</a>
</div>

<script>
/* Show nav CTA after scrolling past hero */
(function(){
    var cta = document.getElementById('lp-nav-cta');
    if (!cta) return;
    function check() {
        var hero = document.querySelector('.lp-hero');
        if (!hero) return;
        if (window.scrollY > hero.offsetHeight - 100) cta.style.display = 'inline-flex';
        else cta.style.display = 'none';
    }
    window.addEventListener('scroll', check, { passive: true });
    check();
})();
</script>
