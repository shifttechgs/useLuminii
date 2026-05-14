@extends('layouts.app')

@section('title', 'Service Business Workflow Case Studies')
@section('description', 'See how useLuminii approaches real service-business workflow problems and why implementation stories are being documented carefully.')
@section('og_title', 'Service Business Systems Built Around Real Workflows')
@section('og_description', 'A practical look at the kinds of workflow problems useLuminii is built to solve.')

@push('head-styles')
@include('partials.marketing-page-styles')
@endpush

@push('head-scripts')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ url('/') }}"
    },
    {
      "@@type": "ListItem",
      "position": 2,
      "name": "Case Studies",
      "item": "{{ route('case-studies') }}"
    }
  ]
}
</script>
@endpush

@section('content')
<div class="lp">
    <section class="lp-ph">
        <div class="lp-wrap">
            <div class="lp-ph__inner">
                <div class="lp-section__label" data-aos="fade-up">Case Studies</div>
                <h1 class="lp-ph__h1" data-aos="fade-up" data-aos-delay="60">Service Business Systems <em>Built Around Real Workflows</em></h1>
                <p class="lp-ph__sub" data-aos="fade-up" data-aos-delay="120">We do not publish invented proof. Real implementation stories are being documented carefully so they reflect the operational work honestly.</p>
                <div class="lp-ph__breadcrumb" data-aos="fade-up" data-aos-delay="160">
                    <a href="{{ url('/') }}">Home</a>
                    <span>/</span>
                    <span>Case Studies</span>
                </div>
            </div>
        </div>
    </section>

    <section class="lp-page">
        <div class="lp-wrap">
            <div class="lp-page__section">
                <h2>What Our Case Studies <em>Will Show</em></h2>
                <p>As documented implementation stories become available, they will focus on how service businesses map their flow, where operational friction shows up, and how connected systems improve control. We would rather document real work properly than publish inflated marketing claims.</p>
                <div class="lp-page__cards-3">
                    <div class="lp-page__card">
                        <h3>Starting workflow</h3>
                        <p>What the business was using before, where information lived, and where handoffs were breaking down.</p>
                    </div>
                    <div class="lp-page__card">
                        <h3>Implementation logic</h3>
                        <p>How useLuminii was mapped to the actual flow of leads, quotes, jobs, billing, and control.</p>
                    </div>
                    <div class="lp-page__card">
                        <h3>Operational outcomes</h3>
                        <p>What became easier to manage, more visible, or more consistent after the workflow was connected.</p>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Common Business Problems <em>We Solve</em></h2>
                <div class="lp-page__columns">
                    <div class="lp-page__point">
                        <h3>Lost or delayed lead follow-up</h3>
                        <p>Owners and teams struggle to respond consistently when enquiries arrive across different channels.</p>
                    </div>
                    <div class="lp-page__point">
                        <h3>Slow quoting and approvals</h3>
                        <p>Work stalls when quoting depends on manual admin or fragmented customer context.</p>
                    </div>
                    <div class="lp-page__point">
                        <h3>Operational handoff gaps</h3>
                        <p>Approved work does not always move cleanly into execution and scheduling.</p>
                    </div>
                    <div class="lp-page__point">
                        <h3>Weak visibility after the job</h3>
                        <p>Invoicing, expense tracking, and reporting often happen too far away from operational reality.</p>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Example Workflow <em>Transformations</em></h2>
                <p>Without claiming specific outcomes that have not yet been published, the kinds of workflow shifts useLuminii is built for include moving from WhatsApp-only lead handling into structured follow-up, turning manual quote admin into a clearer quoting process, and keeping operational records closer to invoicing and reporting.</p>
                <p class="lp-page__note">This page is intentionally honest. If you want to understand what your own workflow would look like inside useLuminii, the best next step is an assessment.</p>
                <div class="lp-page__rail">
                    <div class="lp-page__rail-head">
                        <div>
                            <h3>Typical transformation path</h3>
                            <p>These are the kinds of workflow shifts we are documenting carefully.</p>
                        </div>
                        <div class="lp-page__pill lp-page__pill--gold">Practical</div>
                    </div>
                    <div class="lp-page__rail-steps">
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">1</div>
                            <div>
                                <strong>From scattered enquiries</strong>
                                <span>Move away from unmanaged chats, inboxes, and calls into a clearer lead intake process.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">2</div>
                            <div>
                                <strong>From manual quote chasing</strong>
                                <span>Build a more disciplined quoting path with visible follow-up and approval movement.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">3</div>
                            <div>
                                <strong>From weak job visibility</strong>
                                <span>Keep operations, invoicing, expenses, and reporting closer together once work starts moving.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <div class="lp-page__cta-band">
                    <h2>Book <em>an Assessment</em></h2>
                    <p>We can map your current business flow, identify the points where work breaks down, and show what a more connected service-business operating system would look like for your team.</p>
                    <div class="lp-page__links">
                        <a href="{{ route('features') }}" class="lp-page__link-chip">Explore features</a>
                        <a href="{{ route('solutions.business-operating-system') }}" class="lp-page__link-chip">See the operating system</a>
                        <a href="{{ route('contact.page') }}" class="lp-btn lp-btn--primary lp-btn--sm">Book a Demo</a>
                        <a href="{{ route('contact.page') }}" class="lp-btn lp-btn--outline lp-btn--sm">Get Your Business Flow Assessed</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.cta')
</div>
@endsection
