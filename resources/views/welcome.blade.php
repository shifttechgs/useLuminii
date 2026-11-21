@extends('layouts.app')

@php
    $isPersonal = ($audience ?? 'business') === 'personal';

    // Personal has no FAQ section; only Business shows questions (and their FAQPage data).
    $faqs = $isPersonal ? [] : [
        ['q' => 'What happens in the demo?', 'a' => 'We walk through the platform from enquiry to invoice, discuss how your business currently works and help you identify the right plan and setup scope.'],
        ['q' => 'How long does setup take?', 'a' => 'Timing depends on the workspace, data migration and connections your business needs. We agree the scope and timeline with you before the build, then guide your team through the handover.'],
        ['q' => 'Can I bring my existing client data?', 'a' => 'We review your spreadsheets or current system with you and agree what can be brought into the new workspace. The migration requirements form part of your setup plan.'],
        ['q' => 'Does my team need technical experience?', 'a' => 'No. We configure the workspace and train your team in plain language, using the jobs and tasks they work with every day.'],
        ['q' => 'Which plan should I choose?', 'a' => 'Starter covers your website, enquiries, quotes and invoices for a solo operator. Business adds jobs, team scheduling, recurring invoices, expenses and reports, with 3 users included. Larger operations are scoped to their requirements. We can work through the choice during your demo.'],
        ['q' => 'How do billing and setup fees work?', 'a' => 'You can choose monthly or annual billing, and annual gives you 2 months free. Standard setup is included with Starter. Business setup depends on build scope on monthly billing and is waived with annual billing. Larger operations are quoted for their requirements. Full plan details are on the Pricing page.'],
    ];

    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($f) => [
            '@type' => 'Question',
            'name' => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $faqs),
    ];
@endphp

@if($isPersonal)
@section('title', 'useLuminii Personal - Quotes and Invoices for Sole Traders')
@section('description', 'Free quote and invoice maker for freelancers and sole traders. Create professional quotes and invoices, send them to clients and see what has been paid.')
@section('keywords', 'quotes and invoices app, invoicing for sole traders, freelancer invoicing, quote software, invoice app, free invoice app')
@section('og_title', 'useLuminii Personal - Quotes and Invoices for Sole Traders')
@section('og_description', 'Professional quotes and invoices your clients can accept and pay online. Built for freelancers and sole traders anywhere. Free to start.')
@else
@section('title', 'useLuminii - Business Operating System for Service Businesses')
@section('description', 'useLuminii is the business operating system for service businesses: website leads, quotes, jobs, invoices and reports in one connected flow.')
@section('keywords', 'service business software, business operating system, CRM for service businesses, quote automation, invoicing, compliance')
@section('og_title', 'useLuminii - Business Operating System for Service Businesses')
@section('og_description', 'Connect website leads, quotes, jobs, invoices, expenses, compliance, and reports in one controlled flow built for service businesses.')
@endif

{{-- Lean page: Bootstrap reboot only, no AOS (see layouts/app) --}}
@section('lean_css', '1')

@push('head-scripts')
@php
    $orgRef = ['@id' => url('/') . '#organization'];
    $monthly = fn (string $price, string $unit) => [
        '@type' => 'UnitPriceSpecification',
        'price' => $price,
        'priceCurrency' => 'ZAR',
        'billingDuration' => 'P1M',
        'unitText' => $unit,
    ];
    $appSchema = $isPersonal ? [
        '@context' => 'https://schema.org',
        '@type' => 'SoftwareApplication',
        'name' => 'useLuminii Personal',
        'url' => route('personal'),
        'operatingSystem' => 'Web',
        'applicationCategory' => 'BusinessApplication',
        'description' => 'A free quote and invoice maker for freelancers and sole traders. Create professional quotes and invoices, send them to clients and see what has been paid. No sign-up needed.',
        'offers' => [[
            '@type' => 'Offer',
            'name' => 'Personal',
            'price' => '0',
            'priceCurrency' => 'ZAR',
            'description' => 'Free quote and invoice maker. No sign-up.',
        ]],
        'provider' => $orgRef,
    ] : [
        '@context' => 'https://schema.org',
        '@type' => 'SoftwareApplication',
        'name' => 'useLuminii',
        'url' => url('/'),
        'operatingSystem' => 'Web',
        'applicationCategory' => 'BusinessApplication',
        'description' => 'The business operating system for service businesses. useLuminii connects website leads, quotes, jobs, invoices, expenses, compliance, and reports in one controlled flow.',
        'offers' => [
            [
                '@type' => 'Offer',
                'name' => 'Starter',
                'url' => route('pricing'),
                'price' => '999',
                'priceCurrency' => 'ZAR',
                'priceSpecification' => $monthly('999', 'per month, flat'),
                'description' => 'For solo operators: website, AI receptionist, quotes and invoices, lead capture, CRM and WhatsApp connection. Standard build included.',
            ],
            [
                '@type' => 'Offer',
                'name' => 'Business',
                'url' => route('pricing'),
                'price' => '1799',
                'priceCurrency' => 'ZAR',
                'priceSpecification' => $monthly('1799', 'per month, 3 users included; R299 per extra user'),
                'description' => 'Everything in Starter plus full CRM, pipeline, jobs and team scheduling, recurring invoices, expenses and reports. 3 users included, R299 per extra user per month.',
            ],
        ],
        'provider' => $orgRef,
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($appSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
@if(count($faqs))
<script type="application/ld+json">
{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG) !!}
</script>
@endif
@endpush

@section('content')
<div class="lp lp--{{ $isPersonal ? 'personal' : 'business' }}">
    @if($isPersonal)
        @include('components.personal.builder')
    @else
        @include('components.hero')
        @include('components.pain')
        @include('components.logos')
        @include('components.platform-showcase')
        @include('components.impact')
        @include('components.audience-paths')
        @include('components.workflow')
        @include('components.customer-voices')
        @include('components.setup')
        @include('components.pricing-summary')
    @endif
    @unless($isPersonal)
        @include('components.business-faq')
        @include('components.cta')
    @endunless
</div>
@endsection

@push('body-scripts')
<script>
(function () {
    // Platform: the record window follows whichever chapter crosses the middle of the viewport.
    (function () {
        var story = document.querySelector('[data-pf]');
        if (!story || !('IntersectionObserver' in window)) return;
        var chapters = story.querySelectorAll('[data-pf-chapter]');
        var navItems = story.querySelectorAll('[data-pf-nav]');
        var screens = story.querySelectorAll('[data-pf-screen]');
        var crumb = story.querySelector('[data-pf-crumb]');
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
        story.classList.add('is-ready');

        function setActive(key) {
            chapters.forEach(function (c) { c.classList.toggle('is-active', c.getAttribute('data-pf-chapter') === key); });
            navItems.forEach(function (n) {
                var on = n.getAttribute('data-pf-nav') === key;
                n.classList.toggle('is-active', on);
                if (on && crumb) crumb.textContent = n.textContent.trim();
            });
            screens.forEach(function (s) { s.classList.toggle('is-active', s.getAttribute('data-pf-screen') === key); });
        }

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) setActive(entry.target.getAttribute('data-pf-chapter'));
            });
        }, { rootMargin: '-48% 0px -48% 0px' });
        chapters.forEach(function (c) { io.observe(c); });

        // Clicking a view in the window scrolls its chapter into focus.
        navItems.forEach(function (n) {
            n.addEventListener('click', function () {
                var target = story.querySelector('[data-pf-chapter="' + n.getAttribute('data-pf-nav') + '"]');
                if (target) target.scrollIntoView({ block: 'center', behavior: reduce.matches ? 'auto' : 'smooth' });
            });
        });
    })();

    // Impact: circles drift together and figures roll in; hover re-rolls the figure (the ring sweep is CSS).
    (function () {
        var field = document.querySelector('[data-impact]');
        if (!field || !('IntersectionObserver' in window)) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        var items = field.querySelectorAll('[data-impact-item]');
        field.classList.add('is-armed');

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                field.classList.add('is-in');
                items.forEach(function (item) { item.classList.add('is-rolled'); });
                io.disconnect();
            });
        }, { threshold: 0.35 });
        io.observe(field);

        // Scroll-out: once the cluster's top reaches 8% of the viewport, the circles
        // drift apart and fade over the next 120% of its height. Scrolling back reverses it.
        var wide = window.matchMedia('(min-width: 561px)');
        var outTicking = false;
        function updateOut() {
            outTicking = false;
            if (!wide.matches) { field.style.removeProperty('--out'); return; }
            var r = field.getBoundingClientRect();
            var out = (window.innerHeight * 0.08 - r.top) / (r.height * 1.2);
            out = Math.max(0, Math.min(1, out));
            field.style.setProperty('--out', (out * out * (3 - 2 * out)).toFixed(3)); // smoothstep
        }
        function requestOut() {
            if (outTicking) return;
            outTicking = true;
            requestAnimationFrame(updateOut);
        }
        window.addEventListener('scroll', requestOut, { passive: true });
        window.addEventListener('resize', requestOut);
        updateOut();

        if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
        items.forEach(function (item) {
            var timer;
            item.addEventListener('pointerenter', function () {
                if (!field.classList.contains('is-in')) return;
                clearTimeout(timer);
                item.classList.add('is-rerolling');
                item.classList.remove('is-rolled');
                var reel = item.querySelector('.lp-impact__reel');
                reel.style.transition = 'none';
                void reel.offsetHeight; // commit the reset before rolling again
                reel.style.transition = '';
                item.classList.add('is-rolled');
                timer = setTimeout(function () { item.classList.remove('is-rerolling'); }, 1200);
            });
        });
    })();

    // Paths: hovering or focusing a row unfolds it; the last one opened stays open.
    (function () {
        var index = document.querySelector('[data-paths]');
        if (!index) return;
        var rows = index.querySelectorAll('[data-paths-row]');
        var desktop = window.matchMedia('(min-width: 901px)');
        index.classList.add('is-ready', 'has-open');

        function open(row) {
            rows.forEach(function (r) { r.classList.toggle('is-open', r === row); });
        }
        rows.forEach(function (row) {
            row.addEventListener('mouseenter', function () { if (desktop.matches) open(row); });
            row.addEventListener('focusin', function () { open(row); });
        });
    })();

    // Workflow: the record cascades in stage by stage; hovering or focusing a piece
    // traces it through every stage it travels to.
    (function () {
        var wf = document.querySelector('[data-wf]');
        if (!wf) return;
        var pieces = wf.querySelectorAll('[data-piece]');

        function trace(n) {
            wf.classList.toggle('is-tracing', !!n);
            pieces.forEach(function (p) { p.classList.toggle('is-lit', p.getAttribute('data-piece') === n); });
        }
        pieces.forEach(function (p) {
            p.addEventListener('pointerenter', function () { trace(p.getAttribute('data-piece')); });
            p.addEventListener('focus', function () { trace(p.getAttribute('data-piece')); });
            p.addEventListener('pointerleave', function () { trace(null); });
            p.addEventListener('blur', function () { trace(null); });
        });

        if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        wf.classList.add('is-armed');
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                wf.classList.add('is-in');
                io.disconnect();
                // once the cascade has played, drop the entrance rules so tracing owns opacity
                setTimeout(function () { wf.classList.remove('is-armed', 'is-in'); }, 1600);
            });
        }, { threshold: 0.3 });
        io.observe(wf);
    })();

    // Setup: steps fade up in turn as they enter (IntersectionObserver, so late layout shifts can't strand them).
    (function () {
        var list = document.querySelector('.lp-setup__steps');
        if (!list || !('IntersectionObserver' in window)) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        list.classList.add('is-armed');
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-in');
                io.unobserve(entry.target);
            });
        }, { threshold: 0.2 });
        list.querySelectorAll('[data-setup-step]').forEach(function (step) { io.observe(step); });
    })();

    // Execution gap: pin the frame, advance scenes, and resolve each one halfway through its scroll range.
    (function () {
        var track = document.querySelector('[data-gap]');
        if (!track) return;
        var pin = track.querySelector('.lp-gap__pin');
        var scenes = track.querySelectorAll('[data-gap-scene]');
        var steps = track.querySelectorAll('[data-gap-step]');
        var total = scenes.length;
        if (!pin || !total) return;

        var canPin = window.matchMedia('(min-width: 901px) and (min-height: 640px) and (prefers-reduced-motion: no-preference)');
        var ticking = false;

        function render(progress) {
            var position = progress * total;
            var active = Math.min(total - 1, Math.floor(position));
            scenes.forEach(function (scene, i) {
                var local = Math.max(0, Math.min(1, position - i));
                scene.classList.toggle('is-active', i === active);
                scene.classList.toggle('is-past', i < active);
                scene.classList.toggle('is-resolved', i < active || (i === active && local > 0.42));
            });
            steps.forEach(function (step, i) {
                var fill = Math.max(0, Math.min(1, position - i));
                step.style.setProperty('--fill', fill.toFixed(3));
                step.classList.toggle('is-active', i === active);
                step.classList.toggle('is-done', i < active);
            });
        }

        function update() {
            ticking = false;
            if (!canPin.matches) {
                track.classList.remove('is-pinned');
                return;
            }
            track.classList.add('is-pinned');
            var rect = track.getBoundingClientRect();
            var range = Math.max(1, track.offsetHeight - pin.offsetHeight);
            render(Math.max(0, Math.min(0.9999, -rect.top / range)));
        }

        function requestUpdate() {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(update);
        }

        window.addEventListener('scroll', requestUpdate, { passive: true });
        window.addEventListener('resize', requestUpdate);
        if (canPin.addEventListener) canPin.addEventListener('change', requestUpdate);
        update();
    })();
})();
</script>
@endpush
