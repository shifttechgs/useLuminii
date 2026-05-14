@extends('layouts.app')

@section('title', 'About useLuminii | Clarity for Service Businesses')
@section('description', 'Learn why useLuminii exists and why it focuses on connected workflows for service businesses.')
@section('og_title', 'Built to Help Service Businesses Run With Clarity')
@section('og_description', 'Why useLuminii exists and how it approaches workflow, control, and service-business operations.')

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
      "name": "About",
      "item": "{{ route('about') }}"
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
                <div class="lp-section__label" data-aos="fade-up">About</div>
                <h1 class="lp-ph__h1" data-aos="fade-up" data-aos-delay="60">Built to Help Service Businesses <em>Run With Clarity</em></h1>
                <p class="lp-ph__sub" data-aos="fade-up" data-aos-delay="120">useLuminii exists because too many good service businesses grow into operational chaos before they grow into operational control.</p>
                <div class="lp-ph__breadcrumb" data-aos="fade-up" data-aos-delay="160">
                    <a href="{{ url('/') }}">Home</a>
                    <span>/</span>
                    <span>About</span>
                </div>
            </div>
        </div>
    </section>

    <section class="lp-page">
        <div class="lp-wrap">
            <div class="lp-page__section">
                <h2>Why <em>useLuminii Exists</em></h2>
                <p>Many service businesses do not fail because demand is weak. They struggle because the business becomes harder to run as operations grow. Leads come in faster, teams get busier, admin expands, and the owner loses visibility across the flow.</p>
                <div class="lp-page__metrics">
                    <div class="lp-page__metrics-grid">
                        <div class="lp-page__metric">
                            <div class="lp-page__metric-value">More</div>
                            <strong>Demand pressure</strong>
                            <span>Growth creates more enquiries, more jobs, more admin, and more room for missed handoffs.</span>
                        </div>
                        <div class="lp-page__metric">
                            <div class="lp-page__metric-value">Less</div>
                            <strong>Operational clarity</strong>
                            <span>Without a connected flow, the owner sees less clearly as the business gets busier.</span>
                        </div>
                        <div class="lp-page__metric">
                            <div class="lp-page__metric-value">Need</div>
                            <strong>For a better system</strong>
                            <span>That gap is exactly why useLuminii exists.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>The Problem We Saw <em>in Service Businesses</em></h2>
                <p>Operational work was often spread across WhatsApp, spreadsheets, paper notes, email, and disconnected software. The result was more chasing, more uncertainty, and too much dependence on the owner keeping the business together manually.</p>
                <div class="lp-page__compare">
                    <div class="lp-page__compare-grid">
                        <div class="lp-page__compare-block lp-page__compare-block--soft">
                            <h3>What we kept seeing</h3>
                            <p>Teams duplicating admin, owners checking multiple channels, and important details living in the wrong place.</p>
                        </div>
                        <div class="lp-page__compare-block lp-page__compare-block--strong">
                            <h3>What needed to change</h3>
                            <p>A more disciplined operating flow where information stays connected from the first enquiry to final reporting.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Why We Focus on <em>Connected Workflows</em></h2>
                <p>Service businesses need more than a list of features. They need the work to move properly from lead to quote, from quote to job, and from job to financial control. That is why useLuminii is built around connected workflows rather than isolated modules.</p>
                <div class="lp-page__rail">
                    <div class="lp-page__rail-head">
                        <div>
                            <h3>Why workflow matters</h3>
                            <p>The value is not any one module on its own. It is the continuity between them.</p>
                        </div>
                        <div class="lp-page__pill lp-page__pill--gold">Connected</div>
                    </div>
                    <div class="lp-page__rail-steps">
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">1</div>
                            <div>
                                <strong>Lead to quote</strong>
                                <span>Sales activity should not lose context before it becomes real work.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">2</div>
                            <div>
                                <strong>Quote to job</strong>
                                <span>Approval should create operational momentum, not a new admin reset.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">3</div>
                            <div>
                                <strong>Job to control</strong>
                                <span>Financial follow-through and reporting should stay tied to the work itself.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Our <em>Approach</em></h2>
                <div class="lp-page__columns">
                    <div class="lp-page__point">
                        <h3>Start with the real flow</h3>
                        <p>We begin by understanding how work actually enters, moves through, and exits the business.</p>
                    </div>
                    <div class="lp-page__point">
                        <h3>Reduce operational drag</h3>
                        <p>The goal is not more software complexity. The goal is fewer handoff gaps, better control, and clearer visibility.</p>
                    </div>
                    <div class="lp-page__point">
                        <h3>Keep it practical</h3>
                        <p>Every change should support how service teams really operate in the field and in the office.</p>
                    </div>
                    <div class="lp-page__point">
                        <h3>Build for ownership</h3>
                        <p>The owner should be able to see what is happening without having to chase every detail manually.</p>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <div class="lp-page__cta-band">
                    <h2>Built on Partnership, <em>Driven by Results</em></h2>
                    <p>useLuminii takes a founder-led, practical approach. The focus is on helping service businesses operate with more clarity, more consistency, and less chaos, not on selling generic software language that does not reflect real operational pressure.</p>
                    <div class="lp-page__links">
                        <a href="{{ route('features') }}" class="lp-page__link-chip">Explore features</a>
                        <a href="{{ route('case-studies') }}" class="lp-page__link-chip">See case studies approach</a>
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
