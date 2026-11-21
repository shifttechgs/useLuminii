@php
    $aud = $audience ?? 'business';
    $isPersonal = $aud === 'personal';
    $home = $isPersonal ? route('personal') : url('/');
    // One main action per place: the free trial. The demo is the quieter second choice.
    $ctaLabel = $isPersonal ? 'Create a quote' : 'Start free trial';
    $ctaHref = $isPersonal ? route('crm.quotes.create') : route('signup');

    // Platform menu: the four stages of the flow [title, description, link]
    $platformTiles = $isPersonal ? [
        ['Get found', 'A website, Google reviews and WhatsApp that bring work to you.', url('/') . '#features'],
        ['Win the job', 'A receptionist that answers first, 24/7, and quotes in two minutes.', url('/') . '#features'],
        ['Get paid', 'Invoice in one tap, online payments and polite auto-reminders.', url('/') . '#features'],
        ['Stay sorted', 'Expenses and SARS-ready reports, handled as you go.', url('/') . '#features'],
    ] : [
        ['Get noticed', 'Website, SEO, reviews and referrals that make you the obvious choice.', route('features')],
        ['Win jobs', 'A 24/7 receptionist, CRM and quotes that land before competitors reply.', route('features')],
        ['Work smarter', 'Scheduling, team management and client updates in one flow.', route('features')],
        ['Boost profits', 'Invoicing, expense tracking and SARS-ready compliance.', route('features')],
    ];
    $platformSide = [
        ['Receptionist, 24/7', 'Replies to every enquiry, day and night.', url('/') . '#features'],
        ['WhatsApp leads', 'Capture and quote in the chat.', url('/') . '#features'],
        ['Client Hub', 'Clients approve quotes and pay online.', url('/') . '#features'],
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
                    <img src="{{ asset('assets/images/logo/useluminii_logos/useluminii_dark.png') }}" alt="useLuminii" width="385" height="109" class="lp-hdr__logo-img lp-hdr__logo-img--dark">
                    <img src="{{ asset('assets/images/logo/useluminii_logos/useluminii_light.png') }}" alt="" aria-hidden="true" width="385" height="109" class="lp-hdr__logo-img lp-hdr__logo-img--light">
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
                    <a href="{{ route('crm.login') }}" class="lp-hdr__login">Sign in</a>
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

                        {{-- PLATFORM: numbered index of the four stages, what is included, and one quiet panel --}}
                        <div class="lp-menu lp-menu--platform" id="lp-menu-platform" data-menu-panel="platform" hidden>
                            <ol class="lp-mx">
                                @foreach($platformTiles as $i => [$title, $desc, $href])
                                    <li><a href="{{ $href }}" class="lp-mx__row">
                                        <span class="lp-mx__num">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="lp-mx__text"><span class="lp-mx__title">{{ $title }}</span><span class="lp-mx__desc">{{ $desc }}</span></span>
                                        <i class="ph ph-arrow-right lp-mx__go" aria-hidden="true"></i>
                                    </a></li>
                                @endforeach
                            </ol>
                            <div class="lp-mx-side">
                                <p class="lp-mx-side__label">Included</p>
                                <ul>
                                    @foreach($platformSide as [$title, $desc, $href])
                                        <li><a href="{{ $href }}"><span>{{ $title }}</span><small>{{ $desc }}</small></a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <a href="{{ url('/') }}#workflow" class="lp-mx-panel">
                                <span class="lp-mx-panel__title">One record, start to finish</span>
                                <span class="lp-mx-panel__desc">{{ $isPersonal ? 'From first enquiry to money in the bank, live in 48 hours.' : 'Every enquiry, quote, job and invoice in one connected flow.' }}</span>
                                <span class="lp-mx-panel__link">See how it works <i class="ph ph-arrow-right" aria-hidden="true"></i></span>
                            </a>
                        </div>

                        {{-- SOLUTIONS: two flat panels and a plain list of trades --}}
                        <div class="lp-menu lp-menu--solutions" id="lp-menu-solutions" data-menu-panel="solutions" hidden>
                            <a href="{{ route('solutions.business-operating-system') }}" class="lp-mx-sol">
                                <span class="lp-mx-sol__kicker">Business</span>
                                <span class="lp-mx-sol__title">Service businesses</span>
                                <span class="lp-mx-sol__desc">For growing teams that want leads, quotes, jobs, invoices and reports connected in one operating system.</span>
                                <span class="lp-mx-sol__meta">From R1,799 / month, 3 users included <i class="ph ph-arrow-right" aria-hidden="true"></i></span>
                            </a>
                            <a href="{{ route('personal') }}" class="lp-mx-sol">
                                <span class="lp-mx-sol__kicker">Personal</span>
                                <span class="lp-mx-sol__title">Solo operators</span>
                                <span class="lp-mx-sol__desc">For freelancers and sole traders who want to get found, quote fast and get paid on time, from their phone.</span>
                                <span class="lp-mx-sol__meta">Free to start, no sign-up <i class="ph ph-arrow-right" aria-hidden="true"></i></span>
                            </a>
                            <div class="lp-mx-side">
                                <p class="lp-mx-side__label">Built for</p>
                                <p class="lp-mx-trades">Plumbing, Electrical, Cleaning, Landscaping, HVAC &amp; Air, Pest Control</p>
                                <a href="{{ route('case-studies') }}" class="lp-mx-side__more">Read case studies <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
                            </div>
                        </div>

                        {{-- COMPANY: numbered index and the talk-to-a-person panel --}}
                        <div class="lp-menu lp-menu--company" id="lp-menu-company" data-menu-panel="company" hidden>
                            <ol class="lp-mx">
                                @foreach([
                                    ['About', 'Why we built an operating system for service businesses.', route('about')],
                                    ['Case studies', 'Real businesses and their numbers.', route('case-studies')],
                                    ['Security', 'How we protect your business and client data.', route('security')],
                                    ['Contact', 'Questions, partnerships or support.', route('contact.page')],
                                ] as $i => [$title, $desc, $href])
                                    <li><a href="{{ $href }}" class="lp-mx__row">
                                        <span class="lp-mx__num">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="lp-mx__text"><span class="lp-mx__title">{{ $title }}</span><span class="lp-mx__desc">{{ $desc }}</span></span>
                                        <i class="ph ph-arrow-right lp-mx__go" aria-hidden="true"></i>
                                    </a></li>
                                @endforeach
                            </ol>
                            <div class="lp-talk">
                                <span class="lp-talk__title">Talk to a person</span>
                                <span class="lp-talk__desc">Real people, not a bot. Usually replies in minutes.</span>
                                <a href="https://wa.me/27814303023" target="_blank" rel="noopener" class="lp-talk__row"><i class="ph ph-whatsapp-logo" aria-hidden="true"></i> WhatsApp us</a>
                                <a href="tel:+27814303023" class="lp-talk__row"><i class="ph ph-phone" aria-hidden="true"></i> +27 81 430 3023</a>
                            </div>
                        </div>

                        {{-- MOBILE (all menus in one accordion) --}}
                        <div class="lp-menu lp-menu--mobile" id="lp-menu-mobile" data-menu-panel="mobile" hidden>
                            <details class="lp-macc">
                                <summary>Platform <i class="ph ph-caret-down" aria-hidden="true"></i></summary>
                                @foreach($platformTiles as [$title, $desc, $href])
                                    <a href="{{ $href }}" class="lp-macc__link">{{ $title }}</a>
                                @endforeach
                            </details>
                            <details class="lp-macc">
                                <summary>Solutions <i class="ph ph-caret-down" aria-hidden="true"></i></summary>
                                <a href="{{ route('solutions.business-operating-system') }}" class="lp-macc__link">Service businesses</a>
                                <a href="{{ route('personal') }}" class="lp-macc__link">Solo operators</a>
                                <a href="{{ route('case-studies') }}" class="lp-macc__link">Case studies</a>
                            </details>
                            <details class="lp-macc">
                                <summary>Company <i class="ph ph-caret-down" aria-hidden="true"></i></summary>
                                <a href="{{ route('about') }}" class="lp-macc__link">About</a>
                                <a href="{{ route('security') }}" class="lp-macc__link">Security</a>
                                <a href="{{ route('contact.page') }}" class="lp-macc__link">Contact</a>
                            </details>
                            @unless($isPersonal)<a href="{{ route('pricing') }}" class="lp-macc__top">Pricing</a>@endunless
                            @unless($isPersonal)<a href="{{ $home }}#faq" class="lp-macc__top">FAQ</a>@endunless
                            <div class="lp-macc__actions">
                                @unless($isPersonal)<a href="{{ $ctaHref }}" class="lp-hdr__cta lp-hdr__cta--block">{{ $ctaLabel }}</a>@endunless
                                @unless($isPersonal)<a href="{{ $home }}#booking" class="lp-hdr__login lp-hdr__login--block">Book a demo</a>@endunless
                                <a href="{{ route('crm.login') }}" class="lp-hdr__login lp-hdr__login--block">Sign in</a>
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
