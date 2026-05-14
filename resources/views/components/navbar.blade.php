<nav class="lp-nav" id="lp-nav">
    <div class="lp-nav__inner">
        <a href="{{ url('/') }}" class="lp-nav__logo">
            <img
                src="{{ asset('assets/images/logo/useluminii_logos/useluminii_dark.png') }}"
                alt="useLuminii"
                class="lp-nav__logo-img lp-nav__logo-img--dark"
            >
            <img
                src="{{ asset('assets/images/logo/useluminii_logos/useluminii_light.png') }}"
                alt="useLuminii"
                class="lp-nav__logo-img lp-nav__logo-img--light"
            >
        </a>

        <div class="lp-nav__links">
            <a href="{{ route('features') }}" class="lp-nav__link">Features</a>
            <a href="{{ url('/') }}#process" class="lp-nav__link">How It Works</a>
            <a href="{{ route('pricing') }}" class="lp-nav__link">Pricing</a>
            <a href="{{ url('/') }}#faq" class="lp-nav__link">FAQ</a>
        </div>

        <div class="lp-nav__right">
            <a href="{{ route('crm.login') }}" class="lp-btn lp-btn--outline lp-btn--sm">
                @auth Go to CRM @else Login @endauth
            </a>
            <a href="{{ url('/') }}#booking" class="lp-btn lp-btn--primary lp-btn--sm" id="lp-nav-cta">
                Book a Demo
            </a>
            <button class="lp-nav__mobile-btn" id="lp-menu-btn" aria-label="Open menu">
                <i class="ph ph-list"></i>
            </button>
        </div>
    </div>
</nav>

<div class="lp-mobile-menu" id="lp-mobile-menu">
    <a href="{{ route('features') }}" class="lp-mobile-link">Features</a>
    <a href="{{ url('/') }}#process" class="lp-mobile-link">How It Works</a>
    <a href="{{ route('pricing') }}" class="lp-mobile-link">Pricing</a>
    <a href="{{ url('/') }}#faq" class="lp-mobile-link">FAQ</a>
    <a href="{{ url('/') }}#booking" class="lp-btn lp-btn--primary" style="margin-top:8px;justify-content:center;">Book a Demo</a>
    <a href="{{ route('crm.login') }}" class="lp-btn lp-btn--outline" style="margin-top:4px;justify-content:center;">@auth Go to CRM @else Login @endauth</a>
</div>
