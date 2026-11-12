@extends('layouts.app')

@php
    $isPersonal = ($audience ?? 'business') === 'personal';

    // Personal has no FAQ section; only Business shows questions (and their FAQPage data).
    $faqs = $isPersonal ? [] : [
        ['q' => 'What happens in the demo?', 'a' => 'We walk through the platform from enquiry to invoice, discuss how your business currently works and help you identify the right plan and setup scope.'],
        ['q' => 'How long does setup take?', 'a' => 'Timing depends on the workspace, data migration and connections your business needs. We agree the scope and timeline with you before the build, then guide your team through the handover.'],
        ['q' => 'Can I bring my existing client data?', 'a' => 'We review your spreadsheets or current system with you and agree what can be brought into the new workspace. The migration requirements form part of your setup plan.'],
        ['q' => 'Does my team need technical experience?', 'a' => 'No. We configure the workspace and train your team in plain language, using the jobs and tasks they work with every day.'],
        ['q' => 'Which plan should I choose?', 'a' => 'Starter covers your website, enquiry capture and basic CRM. Growth adds the full flow across quotes, jobs, invoices and reports. Scale is scoped for larger or more complex operations. We can work through the choice during your demo.'],
        ['q' => 'How do billing and setup fees work?', 'a' => 'You can choose monthly or annual billing. Standard setup is included with Starter. Growth setup depends on build scope on monthly billing and is waived with annual billing. Scale is quoted for your requirements. Full plan details are on the Pricing page.'],
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
@section('description', 'Create professional quotes and invoices, send them to clients, and see what has been paid. useLuminii Personal is built for freelancers and sole traders anywhere. Free to start.')
@section('keywords', 'quotes and invoices app, invoicing for sole traders, freelancer invoicing, quote software, invoice app, free invoice app')
@section('og_title', 'useLuminii Personal - Quotes and Invoices for Sole Traders')
@section('og_description', 'Professional quotes and invoices your clients can accept and pay online. Built for freelancers and sole traders anywhere. Free to start.')
@else
@section('title', 'useLuminii - Business Operating System for Service Businesses')
@section('description', 'useLuminii is the business operating system for service businesses. Connect website leads, quotes, jobs, invoices, expenses, compliance, and reports in one controlled flow.')
@section('keywords', 'service business software, business operating system, CRM for service businesses, quote automation, invoicing, compliance, South Africa')
@section('og_title', 'useLuminii - Business Operating System for Service Businesses')
@section('og_description', 'Connect website leads, quotes, jobs, invoices, expenses, compliance, and reports in one controlled flow built for service businesses.')
@endif

@push('head-scripts')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "SoftwareApplication",
  "name": "useLuminii",
  "url": "{{ url('/') }}",
  "operatingSystem": "Web",
  "applicationCategory": "BusinessApplication",
  "description": "The business operating system for service businesses. useLuminii connects website leads, quotes, jobs, invoices, expenses, compliance, and reports in one controlled flow.",
  "offers": [
    {
      "@@type": "Offer",
      "name": "Starter",
      "price": "999",
      "priceCurrency": "ZAR",
      "description": "Website, AI receptionist, lead capture, basic CRM, and WhatsApp connection."
    },
    {
      "@@type": "Offer",
      "name": "Growth",
      "price": "299",
      "priceCurrency": "ZAR",
      "description": "Full CRM, pipeline, quoting, job scheduling, invoicing, expenses, and reports."
    }
  ],
  "provider": {
    "@@type": "Organization",
    "name": "useLuminii",
    "url": "{{ url('/') }}"
  }
}
</script>
@if(count($faqs))
<script type="application/ld+json">
{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG) !!}
</script>
@endif
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Organization",
  "name": "useLuminii",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('assets/images/logo/useluminii.png') }}",
  "contactPoint": {
    "@@type": "ContactPoint",
    "telephone": "+27814303023",
    "contactType": "sales",
    "areaServed": "ZA",
    "availableLanguage": "English"
  }
}
</script>
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
    document.querySelectorAll('.lp-faq-btn').forEach(function (faqBtn) {
        faqBtn.addEventListener('click', function () {
            var item = faqBtn.closest('.lp-faq-item');
            var isOpen = item.classList.contains('open');

            document.querySelectorAll('.lp-faq-item.open').forEach(function (openItem) {
                openItem.classList.remove('open');
                openItem.querySelector('.lp-faq-btn').setAttribute('aria-expanded', 'false');
            });

            if (!isOpen) {
                item.classList.add('open');
                faqBtn.setAttribute('aria-expanded', 'true');
            }
        });
    });

    document.querySelectorAll('.lp-ftabs__btn').forEach(function (tabBtn) {
        tabBtn.addEventListener('click', function () {
            var tab = tabBtn.getAttribute('data-tab');
            var container = tabBtn.closest('.lp-ftabs');
            container.querySelectorAll('.lp-ftabs__btn').forEach(function (button) {
                button.classList.remove('lp-ftabs__btn--active');
            });
            container.querySelectorAll('.lp-ftabs__panel').forEach(function (panel) {
                panel.classList.remove('lp-ftabs__panel--active');
            });
            tabBtn.classList.add('lp-ftabs__btn--active');
            container.querySelector('[data-panel="' + tab + '"]').classList.add('lp-ftabs__panel--active');
        });
    });

    (function () {
        var stack = document.querySelector('[data-gap-stack]');
        var stage = stack && stack.querySelector('.lp-gap__stack-stage');
        var cards = document.querySelectorAll('[data-gap-stack-card]');
        if (!stack || !stage || !cards.length) return;

        var compact = window.matchMedia('(max-width: 900px)');
        var ticking = false;

        function setActive(index) {
            cards.forEach(function (card) {
                var cardIndex = Number(card.getAttribute('data-gap-stack-card'));
                card.classList.toggle('is-active', cardIndex === index);
                card.classList.toggle('is-past', cardIndex < index);
            });
        }

        function update() {
            ticking = false;
            if (compact.matches) {
                stack.classList.remove('is-scroll-ready');
                setActive(0);
                return;
            }

            stack.classList.add('is-scroll-ready');
            var topOffset = parseFloat(window.getComputedStyle(stage).top) || 0;
            var rect = stack.getBoundingClientRect();
            var range = Math.max(1, stack.offsetHeight - stage.offsetHeight);
            var progress = Math.max(0, Math.min(1, (topOffset - rect.top) / range));
            var index = Math.min(cards.length - 1, Math.floor(progress * cards.length));
            setActive(index);
        }

        function requestUpdate() {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(update);
        }

        window.addEventListener('scroll', requestUpdate, { passive: true });
        window.addEventListener('resize', requestUpdate);
        if (compact.addEventListener) compact.addEventListener('change', requestUpdate);
        update();
    })();
})();
</script>
@endpush
