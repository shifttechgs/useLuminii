@php
    $aud = $audience ?? 'business';
    $isPersonal = $aud === 'personal';
    $home = $isPersonal ? route('personal') : url('/');
    $ctaLabel = $isPersonal ? 'Create a quote' : 'Book a Demo';
    $ctaHref = $isPersonal ? route('crm.quotes.create') : url('/') . '#booking';

    // Platform mega menu: the four stages of the flow
    $platformTiles = $isPersonal ? [
        ['ph-magnifying-glass', 'Get found', 'A website, Google reviews and WhatsApp that bring work to you.', url('/') . '#features'],
        ['ph-handshake', 'Win the job', 'An AI receptionist that answers first, and quotes in two minutes.', url('/') . '#features'],
        ['ph-wallet', 'Get paid', 'Invoice in one tap, online payments and polite auto-reminders.', url('/') . '#features'],
        ['ph-shield-check', 'Stay sorted', 'Expenses and SARS-ready reports, handled as you go.', url('/') . '#features'],
    ] : [
        ['ph-megaphone', 'Get noticed', 'Website, SEO, reviews and referrals that make you the obvious choice.', route('features')],
        ['ph-trophy', 'Win jobs', 'AI receptionist, CRM and smart quotes that close before competitors reply.', route('features')],
        ['ph-gear-six', 'Work smarter', 'Scheduling, team management and client updates in one flow.', route('features')],
        ['ph-chart-line-up', 'Boost profits', 'Auto invoicing, expense tracking and SARS-ready compliance.', route('features')],
    ];
    $platformSide = [
        ['ph-robot', 'AI receptionist', 'Replies to every enquiry 24/7.', url('/') . '#features', true],
        ['ph-whatsapp-logo', 'WhatsApp leads', 'Capture and quote in the chat.', url('/') . '#features', false],
        ['ph-browser', 'Client Hub', 'Clients approve quotes and pay online.', url('/') . '#features', false],
    ];

    $menus = [
        'platform' => 'Platform',
        'solutions' => 'Solutions',
        'company' => 'Company',
    ];
@endphp
<header class="lp-hdr{{ request()->routeIs('home', 'personal') ? ' lp-hdr--light' : '' }}{{ $isPersonal ? ' lp-hdr--switch-only' : '' }}" id="lp-nav" data-audience="{{ $aud }}">
    {{-- Audience switch, Stitch-style: small pill above the bar, hides on scroll --}}
    <div class="lp-hdr__aud-row">
        @if($isPersonal)
            <a href="{{ route('personal') }}" class="lp-hdr__mini-logo" aria-label="useLuminii Personal home">
                <img src="{{ asset('assets/images/logo/useluminii_logos/useluminii_dark.png') }}" alt="useLuminii" width="385" height="109">
            </a>
        @endif
        <div class="lp-aud" data-active="{{ $aud }}" aria-label="Choose who useLuminii is for">
            <span class="lp-aud__thumb" aria-hidden="true"></span>
            <a href="{{ url('/') }}" class="lp-aud__opt{{ $isPersonal ? '' : ' is-active' }}" data-aud="business" @unless($isPersonal) aria-current="page" @endunless>Business</a>
            <a href="{{ route('personal') }}" class="lp-aud__opt{{ $isPersonal ? ' is-active' : '' }}" data-aud="personal" @if($isPersonal) aria-current="page" @endif>Personal</a>
        </div>
    </div>

    {{-- Personal is a single-purpose tool page: only the Business | Personal switch, no menu bar --}}
    @unless($isPersonal)
    <div class="lp-hdr__shell">
        <div class="lp-hdr__bar" id="lp-hdr-bar">
            <div class="lp-hdr__row">
                <a href="{{ $home }}" class="lp-hdr__logo" aria-label="useLuminii home">
                    <img src="{{ asset('assets/images/logo/useluminii_logos/useluminii_dark.png') }}" alt="useLuminii" class="lp-hdr__logo-img lp-hdr__logo-img--dark">
                    <img src="{{ asset('assets/images/logo/useluminii_logos/useluminii_light.png') }}" alt="" aria-hidden="true" class="lp-hdr__logo-img lp-hdr__logo-img--light">
                </a>

                <nav class="lp-hdr__links" aria-label="Main">
                    @foreach($menus as $key => $label)
                        <button type="button" class="lp-hdr__link lp-hdr__trigger" data-menu="{{ $key }}" aria-expanded="false" aria-controls="lp-menu-{{ $key }}">
                            {{ $label }}
                            <svg class="lp-hdr__chev" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                    @endforeach
                    @unless($isPersonal)<a href="{{ route('pricing') }}" class="lp-hdr__link">Pricing</a>@endunless
                </nav>

                <div class="lp-hdr__actions">
                    <a href="{{ route('crm.login') }}" class="lp-hdr__login">@auth Go to CRM @else Log in @endauth</a>
                    @unless($isPersonal)<a href="{{ $ctaHref }}" class="lp-hdr__cta" id="lp-nav-cta">{{ $ctaLabel }}</a>@endunless
                    <button type="button" class="lp-hdr__burger" id="lp-menu-btn" aria-label="Open menu" aria-expanded="false" aria-controls="lp-menu-mobile">
                        <span></span><span></span>
                    </button>
                </div>
            </div>

            {{-- Mega menu panel: the bar itself grows to reveal it --}}
            <div class="lp-hdr__panel" id="lp-hdr-panel">
                <div class="lp-hdr__panel-clip">
                    <div class="lp-hdr__panel-inner">

                        {{-- PLATFORM --}}
                        <div class="lp-menu lp-menu--platform" id="lp-menu-platform" data-menu-panel="platform" hidden>
                            <div class="lp-menu__tiles">
                                @foreach($platformTiles as [$icon, $title, $desc, $href])
                                    <a href="{{ $href }}" class="lp-tile">
                                        <span class="lp-tile__icon"><i class="ph {{ $icon }}"></i></span>
                                        <span class="lp-tile__body">
                                            <span class="lp-tile__title">{{ $title }} <i class="ph ph-arrow-right"></i></span>
                                            <span class="lp-tile__desc">{{ $desc }}</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                            <div class="lp-menu__stack">
                                @foreach($platformSide as [$icon, $title, $desc, $href, $isNew])
                                    <a href="{{ $href }}" class="lp-mini">
                                        <span class="lp-mini__title">{{ $title }} @if($isNew)<span class="lp-mini__badge">AI</span>@endif</span>
                                        <span class="lp-mini__desc">{{ $desc }}</span>
                                        <i class="ph ph-arrow-right lp-mini__arrow"></i>
                                    </a>
                                @endforeach
                            </div>
                            <a href="{{ url('/') }}#process" class="lp-feature-card">
                                <span class="lp-feature-card__glow" aria-hidden="true"></span>
                                <span class="lp-feature-card__flow" aria-hidden="true">
                                    <span>Lead</span><i class="ph ph-arrow-right"></i>
                                    <span>Quote</span><i class="ph ph-arrow-right"></i>
                                    <span>Job</span><i class="ph ph-arrow-right"></i>
                                    <span class="is-gold">Paid</span>
                                </span>
                                <span class="lp-feature-card__title">See the whole flow</span>
                                <span class="lp-feature-card__desc">{{ $isPersonal ? 'From first enquiry to money in the bank, live in 48 hours.' : 'One connected flow from first enquiry to final invoice.' }}</span>
                                <span class="lp-feature-card__link">How it works <i class="ph ph-arrow-right"></i></span>
                            </a>
                        </div>

                        {{-- SOLUTIONS --}}
                        <div class="lp-menu lp-menu--solutions" id="lp-menu-solutions" data-menu-panel="solutions" hidden>
                            <a href="{{ route('solutions.business-operating-system') }}" class="lp-sol lp-sol--business">
                                <span class="lp-sol__eyebrow">Business</span>
                                <span class="lp-sol__title">Service businesses <i class="ph ph-arrow-right"></i></span>
                                <span class="lp-sol__desc">For growing teams that want leads, quotes, jobs, invoices and reports connected in one operating system.</span>
                                <span class="lp-sol__meta">From R299 / user / month</span>
                            </a>
                            <a href="{{ route('personal') }}" class="lp-sol lp-sol--personal">
                                <span class="lp-sol__eyebrow">Personal</span>
                                <span class="lp-sol__title">Solo operators <i class="ph ph-arrow-right"></i></span>
                                <span class="lp-sol__desc">For freelancers and sole traders who want to get found, quote fast and get paid on time, from their phone.</span>
                                <span class="lp-sol__meta">From R999 / month, flat</span>
                            </a>
                            <div class="lp-menu__list">
                                <span class="lp-menu__list-label">Built for</span>
                                <ul>
                                    @foreach(['ph-wrench' => 'Plumbing', 'ph-lightning' => 'Electrical', 'ph-broom' => 'Cleaning', 'ph-tree' => 'Landscaping', 'ph-thermometer-simple' => 'HVAC & Air', 'ph-bug' => 'Pest Control'] as $icon => $trade)
                                        <li><i class="ph {{ $icon }}"></i> {{ $trade }}</li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('case-studies') }}" class="lp-menu__list-link">Read case studies <i class="ph ph-arrow-right"></i></a>
                            </div>
                        </div>

                        {{-- COMPANY --}}
                        <div class="lp-menu lp-menu--company" id="lp-menu-company" data-menu-panel="company" hidden>
                            <div class="lp-menu__tiles lp-menu__tiles--company">
                                @foreach([
                                    ['ph-sparkle', 'About', 'Why we built an operating system for service businesses.', route('about')],
                                    ['ph-trophy', 'Case studies', 'Real businesses and their numbers.', route('case-studies')],
                                    ['ph-lock-key', 'Security', 'How we protect your business and client data.', route('security')],
                                    ['ph-envelope-simple', 'Contact', 'Questions, partnerships or support.', route('contact.page')],
                                ] as [$icon, $title, $desc, $href])
                                    <a href="{{ $href }}" class="lp-tile lp-tile--compact">
                                        <span class="lp-tile__icon"><i class="ph {{ $icon }}"></i></span>
                                        <span class="lp-tile__body">
                                            <span class="lp-tile__title">{{ $title }} <i class="ph ph-arrow-right"></i></span>
                                            <span class="lp-tile__desc">{{ $desc }}</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                            <div class="lp-talk">
                                <span class="lp-talk__title">Talk to a person</span>
                                <span class="lp-talk__desc">Real people, not a bot. Usually replies in minutes.</span>
                                <a href="https://wa.me/27814303023" target="_blank" rel="noopener" class="lp-talk__row"><i class="ph ph-whatsapp-logo"></i> WhatsApp us</a>
                                <a href="tel:+27814303023" class="lp-talk__row"><i class="ph ph-phone"></i> +27 81 430 3023</a>
                            </div>
                        </div>

                        {{-- MOBILE (all menus in one accordion) --}}
                        <div class="lp-menu lp-menu--mobile" id="lp-menu-mobile" data-menu-panel="mobile" hidden>
                            <details class="lp-macc">
                                <summary>Platform <i class="ph ph-caret-down"></i></summary>
                                @foreach($platformTiles as [$icon, $title, $desc, $href])
                                    <a href="{{ $href }}" class="lp-macc__link"><i class="ph {{ $icon }}"></i> {{ $title }}</a>
                                @endforeach
                            </details>
                            <details class="lp-macc">
                                <summary>Solutions <i class="ph ph-caret-down"></i></summary>
                                <a href="{{ route('solutions.business-operating-system') }}" class="lp-macc__link"><i class="ph ph-buildings"></i> Service businesses</a>
                                <a href="{{ route('personal') }}" class="lp-macc__link"><i class="ph ph-user"></i> Solo operators</a>
                                <a href="{{ route('case-studies') }}" class="lp-macc__link"><i class="ph ph-trophy"></i> Case studies</a>
                            </details>
                            <details class="lp-macc">
                                <summary>Company <i class="ph ph-caret-down"></i></summary>
                                <a href="{{ route('about') }}" class="lp-macc__link"><i class="ph ph-sparkle"></i> About</a>
                                <a href="{{ route('security') }}" class="lp-macc__link"><i class="ph ph-lock-key"></i> Security</a>
                                <a href="{{ route('contact.page') }}" class="lp-macc__link"><i class="ph ph-envelope-simple"></i> Contact</a>
                            </details>
                            @unless($isPersonal)<a href="{{ route('pricing') }}" class="lp-macc__top">Pricing</a>@endunless
                            @unless($isPersonal)<a href="{{ $home }}#faq" class="lp-macc__top">FAQ</a>@endunless
                            <div class="lp-macc__actions">
                                @unless($isPersonal)<a href="{{ $ctaHref }}" class="lp-hdr__cta lp-hdr__cta--block">{{ $ctaLabel }}</a>@endunless
                                <a href="{{ route('crm.login') }}" class="lp-hdr__login lp-hdr__login--block">@auth Go to CRM @else Log in @endauth</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endunless
</header>
<div class="lp-hdr__scrim" id="lp-hdr-scrim" aria-hidden="true"></div>
