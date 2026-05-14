@extends('layouts.app')

@section('title', 'Security and Privacy | useLuminii')
@section('description', 'How useLuminii approaches security, privacy, POPIA-aware handling, and operational trust for service businesses.')
@section('og_title', 'Security, Privacy, and Operational Trust')
@section('og_description', 'How useLuminii treats business data, access control, privacy, and record-keeping support.')

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
      "name": "Security",
      "item": "{{ route('security') }}"
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
                <div class="lp-section__label" data-aos="fade-up">Security</div>
                <h1 class="lp-ph__h1" data-aos="fade-up" data-aos-delay="60">Security, Privacy, <em>and Operational Trust</em></h1>
                <p class="lp-ph__sub" data-aos="fade-up" data-aos-delay="120">useLuminii is designed with privacy in mind and built to help service businesses keep operational records more organised, visible, and controlled.</p>
                <div class="lp-ph__breadcrumb" data-aos="fade-up" data-aos-delay="160">
                    <a href="{{ url('/') }}">Home</a>
                    <span>/</span>
                    <span>Security</span>
                </div>
            </div>
        </div>
    </section>

    <section class="lp-page">
        <div class="lp-wrap">
            <div class="lp-page__section">
                <h2>How useLuminii Treats <em>Business Data</em></h2>
                <p>Operational and customer data should be handled carefully. useLuminii is structured to keep information within a more organised system rather than scattered across unmanaged channels, repeated copies, and informal records.</p>
                <div class="lp-page__visual">
                    <div class="lp-page__visual-head">
                        <div class="lp-page__visual-title">Data handling focus</div>
                        <div class="lp-page__visual-badge">Designed for control</div>
                    </div>
                    <div class="lp-page__visual-rows">
                        <div class="lp-page__visual-row">
                            <div class="lp-page__visual-icon"><i class="ph ph-database"></i></div>
                            <div>
                                <strong>Reduce data sprawl</strong>
                                <span>Keep operational records in a clearer system instead of across unmanaged channels.</span>
                            </div>
                            <div class="lp-page__pill lp-page__pill--navy">Organised</div>
                        </div>
                        <div class="lp-page__visual-row">
                            <div class="lp-page__visual-icon"><i class="ph ph-files"></i></div>
                            <div>
                                <strong>Improve traceability</strong>
                                <span>Make it easier to understand which records relate to which customer, job, and transaction path.</span>
                            </div>
                            <div class="lp-page__pill lp-page__pill--teal">Traceable</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Access <em>Control</em></h2>
                <p>Access should reflect responsibility. The platform is designed to support role-based access and clearer separation of operational responsibilities so teams do not all depend on one shared, uncontrolled workflow.</p>
                <div class="lp-page__cards-3">
                    <div class="lp-page__point">
                        <h3>Role-aware access</h3>
                        <p>Teams should see what they need for their role instead of working through one shared view of everything.</p>
                    </div>
                    <div class="lp-page__point">
                        <h3>Cleaner responsibility lines</h3>
                        <p>Access patterns can support clearer ownership across sales, operations, and admin tasks.</p>
                    </div>
                    <div class="lp-page__point">
                        <h3>Less workflow fragility</h3>
                        <p>Operations are less dependent on one person manually controlling all information movement.</p>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Data Protection <em>Principles</em></h2>
                <p>We approach platform and customer information with practical data-handling discipline. That includes minimising unnecessary sprawl, supporting cleaner records, and keeping business-critical information easier to trace and manage.</p>
                <div class="lp-page__mini-grid">
                    <div class="lp-page__mini">
                        <strong>Minimise unnecessary duplication</strong>
                        <span>Reduce repeated copies of important records across chats, notes, and spreadsheets.</span>
                    </div>
                    <div class="lp-page__mini">
                        <strong>Keep records structured</strong>
                        <span>Support cleaner, more usable operational data for the team.</span>
                    </div>
                    <div class="lp-page__mini">
                        <strong>Make oversight easier</strong>
                        <span>Better structure helps teams review, trace, and manage critical information.</span>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>POPIA-Aware <em>Handling</em></h2>
                <p>useLuminii is intended to support POPIA-aware practices by helping teams keep customer and operational records more structured and easier to manage. It does not replace your own legal or internal compliance responsibilities.</p>
                <div class="lp-page__compare">
                    <div class="lp-page__compare-grid">
                        <div class="lp-page__compare-block lp-page__compare-block--soft">
                            <h3>What the system can support</h3>
                            <p>More organised records, cleaner internal handling, and better visibility into customer and job-linked information.</p>
                        </div>
                        <div class="lp-page__compare-block lp-page__compare-block--strong">
                            <h3>What customers still own</h3>
                            <p>Internal policy, staff behavior, legal compliance decisions, and the broader governance of data inside the business.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Operational <em>Reliability</em></h2>
                <p>Reliability matters because service businesses depend on response speed, job coordination, and financial follow-through. Keeping more of the business in one operating flow helps reduce avoidable operational blind spots.</p>
                <div class="lp-page__rail">
                    <div class="lp-page__rail-head">
                        <div>
                            <h3>Reliability in practice</h3>
                            <p>Operational trust is built through cleaner process continuity, not only technical language.</p>
                        </div>
                        <div class="lp-page__pill lp-page__pill--gold">Steadier flow</div>
                    </div>
                    <div class="lp-page__rail-steps">
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">1</div>
                            <div>
                                <strong>Faster response visibility</strong>
                                <span>Know where leads and follow-ups stand before they go cold.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">2</div>
                            <div>
                                <strong>Stronger job continuity</strong>
                                <span>Help teams move from quoting into work execution with fewer handoff gaps.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">3</div>
                            <div>
                                <strong>Cleaner financial follow-through</strong>
                                <span>Keep invoicing, expenses, and reporting closer to what actually happened operationally.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Compliance <em>Support</em></h2>
                <p>useLuminii helps teams keep records organised, supports better compliance tracking, and keeps financial and operational information closer together. It can improve readiness, but it does not make legal guarantees or replace professional advice.</p>
            </div>

            <div class="lp-page__section">
                <div class="lp-page__cta-band">
                    <h2>What Customers <em>Remain Responsible For</em></h2>
                    <p>Customers remain responsible for internal processes, access decisions, legal compliance, staff conduct, and how information is handled within their own organisation. Better systems help, but disciplined operations still matter.</p>
                    <div class="lp-page__links">
                        <a href="{{ route('privacy-policy') }}" class="lp-page__link-chip">Read privacy policy</a>
                        <a href="{{ route('terms') }}" class="lp-page__link-chip">Read terms</a>
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
