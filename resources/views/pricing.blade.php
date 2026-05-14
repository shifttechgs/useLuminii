@extends('layouts.app')

@section('title', 'Pricing - useLuminii for Service Businesses in South Africa')
@section('description', 'Simple, transparent pricing for South African service businesses. Starter from R999/mo. Growth from R299/user/mo. Connect leads, quotes, jobs, invoicing, expenses, and reporting in one flow.')
@section('keywords', 'CRM pricing South Africa, service business software cost, job management software pricing, useLuminii pricing, CRM for contractors price')
@section('og_title', 'useLuminii Pricing - Transparent Plans for Service Businesses')
@section('og_description', 'From R999/mo flat or R299/user/mo. One operating system for service businesses.')

@push('head-scripts')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "useLuminii Pricing",
  "url": "{{ url('/pricing') }}",
  "description": "Transparent pricing for useLuminii, the business operating system for service businesses.",
  "mainEntity": {
    "@@type": "ItemList",
    "itemListElement": [
      {
        "@@type": "ListItem",
        "position": 1,
        "item": {
          "@@type": "Offer",
          "name": "Starter Plan",
          "price": "999",
          "priceCurrency": "ZAR",
          "description": "Website, AI receptionist, lead capture, basic CRM, and WhatsApp connection."
        }
      },
      {
        "@@type": "ListItem",
        "position": 2,
        "item": {
          "@@type": "Offer",
          "name": "Growth Plan",
          "price": "299",
          "priceCurrency": "ZAR",
          "description": "Full CRM, pipeline, quoting, job scheduling, invoicing, expenses, and reports."
        }
      }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="lp">
    <section class="lp-ph">
        <div class="lp-wrap">
            <div class="lp-ph__inner">
                <div class="lp-section__label" data-aos="fade-up">Pricing</div>
                <h1 class="lp-ph__h1" data-aos="fade-up" data-aos-delay="60">Transparent pricing.<br><em>No surprises.</em></h1>
                <p class="lp-ph__sub" data-aos="fade-up" data-aos-delay="120">Choose the operating flow that fits your stage, then book a demo and we will assess what your business needs.</p>
                <div class="lp-ph__breadcrumb" data-aos="fade-up" data-aos-delay="160">
                    <a href="{{ url('/') }}">Home</a>
                    <span>/</span>
                    <span>Pricing</span>
                </div>
            </div>
        </div>
    </section>

    @include('components.pricing')

    <section class="lp-section lp-section--white" id="included">
        <div class="lp-wrap">
            <div class="lp-section__header lp-section__header--center">
                <div class="lp-section__label" data-aos="fade-up">Every Plan</div>
                <h2 class="lp-section__h2" data-aos="fade-up" data-aos-delay="60">What's always <em>included.</em></h2>
            </div>
            <div class="lp-pi__grid" data-aos="fade-up" data-aos-delay="100">
                <div class="lp-pi__item">
                    <i class="ph ph-shield-check lp-pi__icon"></i>
                    <div class="lp-pi__title">Initial audit</div>
                    <p class="lp-pi__desc">We map your workflow before we build anything. No guesswork.</p>
                </div>
                <div class="lp-pi__item">
                    <i class="ph ph-rocket lp-pi__icon"></i>
                    <div class="lp-pi__title">Live in 48 hours</div>
                    <p class="lp-pi__desc">Full setup, data migration, and team training before go-live.</p>
                </div>
                <div class="lp-pi__item">
                    <i class="ph ph-whatsapp-logo lp-pi__icon"></i>
                    <div class="lp-pi__title">WhatsApp connected</div>
                    <p class="lp-pi__desc">Your business stays reachable on the channel your clients already use.</p>
                </div>
                <div class="lp-pi__item">
                    <i class="ph ph-prohibit lp-pi__icon"></i>
                    <div class="lp-pi__title">No contracts</div>
                    <p class="lp-pi__desc">Month-to-month. Cancel with 30 days notice and no long-term lock-in.</p>
                </div>
                <div class="lp-pi__item">
                    <i class="ph ph-arrow-square-in lp-pi__icon"></i>
                    <div class="lp-pi__title">Data migration</div>
                    <p class="lp-pi__desc">We import from spreadsheets, Xero, QuickBooks, or any system.</p>
                </div>
                <div class="lp-pi__item">
                    <i class="ph ph-headset lp-pi__icon"></i>
                    <div class="lp-pi__title">Onboarding support</div>
                    <p class="lp-pi__desc">Dedicated onboarding session for you and every team member.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="lp-section lp-section--gray" id="pricing-faq">
        <div class="lp-wrap" style="max-width:720px;">
            <div class="lp-section__header lp-section__header--center">
                <div class="lp-section__label" data-aos="fade-up">Questions</div>
                <h2 class="lp-section__h2" data-aos="fade-up" data-aos-delay="60">Pricing questions <em>answered.</em></h2>
            </div>
            <div class="lp-faq__list" data-aos="fade-up" data-aos-delay="80">
                <div class="lp-faq-item">
                    <button class="lp-faq-btn" aria-expanded="false">
                        <span>Is the setup fee always required on Growth?</span>
                        <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                    </button>
                    <div class="lp-faq-body">
                        <div class="lp-faq-body-inner">It depends on what you need. New website and implementation scope can affect the setup fee. If you commit to an annual plan, the setup fee is waived.</div>
                    </div>
                </div>

                <div class="lp-faq-item">
                    <button class="lp-faq-btn" aria-expanded="false">
                        <span>What counts as a user on the Growth plan?</span>
                        <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                    </button>
                    <div class="lp-faq-body">
                        <div class="lp-faq-body-inner">A user is anyone who logs into the system to manage jobs, quotes, clients, or operations. Client portal access does not count as a paid user seat.</div>
                    </div>
                </div>

                <div class="lp-faq-item">
                    <button class="lp-faq-btn" aria-expanded="false">
                        <span>Can I start on Starter and upgrade later?</span>
                        <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                    </button>
                    <div class="lp-faq-body">
                        <div class="lp-faq-body-inner">Yes. Many businesses start on Starter, then upgrade to Growth once they are ready to connect the full operating flow.</div>
                    </div>
                </div>

                <div class="lp-faq-item">
                    <button class="lp-faq-btn" aria-expanded="false">
                        <span>How does annual billing work?</span>
                        <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                    </button>
                    <div class="lp-faq-body">
                        <div class="lp-faq-body-inner">Annual plans are billed upfront for 10 months, giving you 2 months free. On Growth, the setup fee is also waived when you pay annually.</div>
                    </div>
                </div>

                <div class="lp-faq-item">
                    <button class="lp-faq-btn" aria-expanded="false">
                        <span>What does Scale pricing look like?</span>
                        <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                    </button>
                    <div class="lp-faq-body">
                        <div class="lp-faq-body-inner">Scale pricing depends on team size, number of locations, and integration scope. We provide a custom proposal after a scoping call.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.cta')
</div>
@endsection

@push('head-styles')
<style>
.lp-ph {
    background: #060F1E;
    padding: 120px 0 80px;
    text-align: center;
    position: relative;
}
.lp-ph::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
}
.lp-ph__inner { position: relative; z-index: 2; }
.lp-ph__h1 em {
    font-style: normal;
    color: rgba(255,255,255,0.45);
}
.lp-ph__h1 {
    font-family: "Geist", system-ui, sans-serif;
    font-size: clamp(36px, 5vw, 60px);
    font-weight: 800;
    letter-spacing: -0.035em;
    line-height: 1.1;
    color: #fff;
    margin-bottom: 20px;
}
.lp-ph__sub {
    font-size: 17px;
    line-height: 1.65;
    color: rgba(255,255,255,0.6);
    max-width: 560px;
    margin: 0 auto 28px;
}
.lp-ph__breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: rgba(255,255,255,0.4);
}
.lp-ph__breadcrumb a {
    color: rgba(255,255,255,0.55);
    text-decoration: none;
}
.lp-ph__breadcrumb a:hover { color: #fff; }
.lp-pi__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    max-width: 900px;
    margin: 0 auto;
}
@media (max-width: 768px) { .lp-pi__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .lp-pi__grid { grid-template-columns: 1fr; } }
.lp-pi__item {
    background: #fff;
    border: 1px solid #E5EAF2;
    border-radius: 16px;
    padding: 24px;
}
.lp-pi__icon {
    font-size: 24px;
    color: #081D3A;
    margin-bottom: 12px;
    display: block;
}
.lp-pi__title {
    font-family: "Geist", system-ui, sans-serif;
    font-size: 15px;
    font-weight: 700;
    color: #081D3A;
    margin-bottom: 6px;
}
.lp-pi__desc {
    font-size: 13px;
    color: #647082;
    line-height: 1.55;
}
.lp-section--white { background: #fff; }
</style>
@endpush
