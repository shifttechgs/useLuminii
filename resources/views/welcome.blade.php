@extends('layouts.app')

@section('title', 'useLuminii - Business Operating System for Service Businesses')
@section('description', 'useLuminii is the business operating system for service businesses. Connect website leads, quotes, jobs, invoices, expenses, compliance, and reports in one controlled flow.')
@section('keywords', 'service business software, business operating system, CRM for service businesses, quote automation, invoicing, compliance, South Africa')
@section('og_title', 'useLuminii - Business Operating System for Service Businesses')
@section('og_description', 'Connect website leads, quotes, jobs, invoices, expenses, compliance, and reports in one controlled flow built for service businesses.')

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
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    {
      "@@type": "Question",
      "name": "How fast can I get set up?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "Most businesses are live within 48 hours. We handle setup, data migration, and team training before handover."
      }
    },
    {
      "@@type": "Question",
      "name": "How is this different from Jobber or ServiceM8?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "useLuminii combines implementation support with an operating system built around your business flow, from lead capture to invoicing and reporting."
      }
    },
    {
      "@@type": "Question",
      "name": "Is there a contract?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "No. Plans are month to month, with no long-term lock-in."
      }
    },
    {
      "@@type": "Question",
      "name": "Do I need to be tech-savvy to use it?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "No. We onboard your team in plain language and keep the system practical for day-to-day service operations."
      }
    },
    {
      "@@type": "Question",
      "name": "What payment methods are supported?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "useLuminii supports EFT, cards, and instant EFT options commonly used by South African businesses."
      }
    },
    {
      "@@type": "Question",
      "name": "Can I migrate data from my current system?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "Yes. We can migrate data from spreadsheets and other systems before go-live."
      }
    }
  ]
}
</script>
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
<div class="lp">
    @include('components.hero')
    @include('components.logos')
    @include('components.pain')
    @include('components.how-it-works')
    @include('components.features')
    @include('components.testimonials')
    @include('components.pricing')
    @include('components.faq')
    @include('components.cta')
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
        var cards = document.querySelectorAll('.lp-pain-card');
        if (!cards.length) return;

        if (!window.IntersectionObserver) {
            cards.forEach(function (card) { card.classList.add('lp-pain-card--visible'); });
            return;
        }

        var delays = [0, 100, 200, 300];
        cards.forEach(function (card, i) {
            card.style.transitionDelay = delays[i] + 'ms';
        });

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('lp-pain-card--visible');
                } else if (entry.boundingClientRect.top > 0) {
                    entry.target.classList.remove('lp-pain-card--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -80px 0px'
        });

        cards.forEach(function (card) { io.observe(card); });
    })();
})();
</script>
@endpush
