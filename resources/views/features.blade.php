@extends('layouts.app')

@section('title', 'Features for Service Business Flow | useLuminii')
@section('description', 'Connect leads, quotes, jobs, invoices, expenses, compliance, and reporting in one service business flow.')
@section('og_title', 'Features That Connect Your Service Business')
@section('og_description', 'See how useLuminii connects fragmented service business operations into one controlled flow.')

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
      "name": "Features",
      "item": "{{ route('features') }}"
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
                <div class="lp-section__label" data-aos="fade-up">Features</div>
                <h1 class="lp-ph__h1" data-aos="fade-up" data-aos-delay="60">Features That Connect <em>Your Service Business</em></h1>
                <p class="lp-ph__sub" data-aos="fade-up" data-aos-delay="120">From first enquiry to final report, useLuminii keeps the operating flow connected so owners can see what is happening, what needs attention, and where money is moving.</p>
                <div class="lp-ph__breadcrumb" data-aos="fade-up" data-aos-delay="160">
                    <a href="{{ url('/') }}">Home</a>
                    <span>/</span>
                    <span>Features</span>
                </div>
            </div>
        </div>
    </section>

    <section class="lp-page">
        <div class="lp-wrap">
            <div class="lp-page__section">
                <div class="lp-page__grid">
                    <div>
                        <div class="lp-page__eyebrow">Connected Business Flow</div>
                        <p class="lp-page__lead">UseLuminii is built around the full service-business journey: website leads, lead management, quotes, jobs, invoices, expenses, compliance support, and reports in one controlled operating system.</p>
                        <div class="lp-page__links">
                            <a href="{{ route('solutions.business-operating-system') }}" class="lp-page__link-chip">See the solution page</a>
                            <a href="{{ route('pricing') }}" class="lp-page__link-chip">View pricing</a>
                            <a href="{{ route('contact.page') }}" class="lp-page__link-chip">Book a demo</a>
                            <a href="{{ route('security') }}" class="lp-page__link-chip">Review security</a>
                        </div>
                    </div>
                    <div class="lp-page__visual">
                        <div class="lp-page__visual-head">
                            <div class="lp-page__visual-title">Business Flow Overview</div>
                            <div class="lp-page__visual-badge">Owner visibility</div>
                        </div>
                        <div class="lp-page__visual-rows">
                            <div class="lp-page__visual-row">
                                <div class="lp-page__visual-icon"><i class="ph ph-globe"></i></div>
                                <div>
                                    <strong>Website Leads</strong>
                                    <span>Capture enquiries from the website, forms, and inbound channels with the right context.</span>
                                </div>
                                <div class="lp-page__pill lp-page__pill--gold">Captured</div>
                            </div>
                            <div class="lp-page__visual-row">
                                <div class="lp-page__visual-icon"><i class="ph ph-address-book-tabs"></i></div>
                                <div>
                                    <strong>Lead to Quote</strong>
                                    <span>Move leads into a clear follow-up and quoting process without switching systems.</span>
                                </div>
                                <div class="lp-page__pill lp-page__pill--teal">In flow</div>
                            </div>
                            <div class="lp-page__visual-row">
                                <div class="lp-page__visual-icon"><i class="ph ph-calendar-check"></i></div>
                                <div>
                                    <strong>Quote to Job</strong>
                                    <span>Approved work becomes scheduled work with cleaner handoff into delivery.</span>
                                </div>
                                <div class="lp-page__pill lp-page__pill--navy">Assigned</div>
                            </div>
                            <div class="lp-page__visual-row">
                                <div class="lp-page__visual-icon"><i class="ph ph-chart-line-up"></i></div>
                                <div>
                                    <strong>Job to Control</strong>
                                    <span>Invoices, expenses, compliance support, and reporting stay tied to real activity.</span>
                                </div>
                                <div class="lp-page__pill lp-page__pill--teal">Visible</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>The Connected <em>Business Flow</em></h2>
                <p>Most service businesses do not struggle because they lack tools. They struggle because the tools do not share one operating flow. useLuminii connects the parts that usually live in WhatsApp chats, spreadsheets, notebooks, inboxes, and memory.</p>
                <div class="lp-page__metrics">
                    <div class="lp-page__metrics-grid">
                        <div class="lp-page__metric">
                            <div class="lp-page__metric-value">1</div>
                            <strong>Connected journey</strong>
                            <span>The customer flow stays in one operating path instead of being rebuilt at every handoff.</span>
                        </div>
                        <div class="lp-page__metric">
                            <div class="lp-page__metric-value">7</div>
                            <strong>Core control points</strong>
                            <span>Lead capture, quoting, jobs, invoicing, expenses, compliance support, and reporting.</span>
                        </div>
                        <div class="lp-page__metric">
                            <div class="lp-page__metric-value">0</div>
                            <strong>Need for guesswork</strong>
                            <span>Owners get a clearer operational picture without relying on memory or scattered chat threads.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Website <em>Lead Capture</em></h2>
                <p>The website is not treated like a separate marketing asset. It is the first step in the operating flow. Enquiries are captured clearly, routed properly, and kept attached to the customer record from the start.</p>
                <div class="lp-page__mini-grid">
                    <div class="lp-page__mini">
                        <strong>Cleaner intake</strong>
                        <span>Lead details arrive in a format the team can act on immediately.</span>
                    </div>
                    <div class="lp-page__mini">
                        <strong>Less dropped context</strong>
                        <span>Service type, customer details, and next-step needs remain tied to the enquiry.</span>
                    </div>
                    <div class="lp-page__mini">
                        <strong>Faster response</strong>
                        <span>Teams can move from first contact into follow-up without rebuilding the record.</span>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Lead <em>Management</em></h2>
                <p>Every enquiry needs a next step. useLuminii helps teams track response status, follow-up activity, and whether the business is losing leads before a quote even goes out.</p>
                <div class="lp-page__timeline">
                    <div class="lp-page__timeline-items">
                        <div class="lp-page__timeline-item">
                            <div class="lp-page__timeline-label">First contact</div>
                            <div class="lp-page__timeline-body">
                                <strong>See where new enquiries are sitting</strong>
                                <span>Know which leads still need response, who owns them, and what the next action should be.</span>
                            </div>
                        </div>
                        <div class="lp-page__timeline-item">
                            <div class="lp-page__timeline-label">Follow-up</div>
                            <div class="lp-page__timeline-body">
                                <strong>Keep response discipline visible</strong>
                                <span>Reduce the chance that hot leads disappear into inboxes or WhatsApp threads.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Quote <em>Management</em></h2>
                <p>Quotes are part of the business flow, not a disconnected document exercise. Teams can prepare, send, and track quotes while keeping pricing, service scope, and customer details linked to the same record.</p>
                <div class="lp-page__cards-3">
                    <div class="lp-page__card">
                        <h3>Quoting context</h3>
                        <p>Customer details, service requirements, and communication history stay close to the quote itself.</p>
                    </div>
                    <div class="lp-page__card">
                        <h3>Clear approval path</h3>
                        <p>Teams can see what is sent, what is waiting, and what is ready to become scheduled work.</p>
                    </div>
                    <div class="lp-page__card">
                        <h3>Less repeat admin</h3>
                        <p>Approved quotes do not need to be manually reconstructed to continue the workflow.</p>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Job <em>Management</em></h2>
                <p>Once work is approved, the next challenge is execution. Scheduling, assignment, visibility, and updates all need to happen without admin chaos. useLuminii helps teams keep jobs moving with fewer handoff mistakes.</p>
                <div class="lp-page__rail">
                    <div class="lp-page__rail-head">
                        <div>
                            <h3>Execution rail</h3>
                            <p>The handoff from approved work into delivery should be clear, visible, and controlled.</p>
                        </div>
                        <div class="lp-page__pill lp-page__pill--gold">Field-ready</div>
                    </div>
                    <div class="lp-page__rail-steps">
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">1</div>
                            <div>
                                <strong>Schedule the right work</strong>
                                <span>Turn approvals into scheduled jobs with the right service details already attached.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">2</div>
                            <div>
                                <strong>Assign with context</strong>
                                <span>Teams should not have to search multiple tools to understand what needs to be done.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">3</div>
                            <div>
                                <strong>Track completion cleanly</strong>
                                <span>Operational completion should feed straight into billing and reporting readiness.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Invoice <em>Management</em></h2>
                <p>Invoices should reflect real work completed, not another disconnected admin step. Keeping invoicing close to the job flow helps businesses bill faster and keep financial records cleaner.</p>
                <div class="lp-page__compare">
                    <div class="lp-page__compare-grid">
                        <div class="lp-page__compare-block lp-page__compare-block--soft">
                            <h3>Disconnected billing</h3>
                            <p>Teams chase job details after the fact, rebuild pricing, and lose time between work completed and money collected.</p>
                        </div>
                        <div class="lp-page__compare-block lp-page__compare-block--strong">
                            <h3>Connected invoicing</h3>
                            <p>Billing stays linked to approved work and completed jobs, helping owners move faster with cleaner records.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Expense <em>Tracking</em></h2>
                <p>When expenses sit outside the operating system, owners lose margin visibility. useLuminii helps keep records organised so job activity and cost visibility stay closer together.</p>
                <div class="lp-page__cards-3">
                    <div class="lp-page__point">
                        <h3>Closer margin visibility</h3>
                        <p>Keep cost records closer to the operational work that created them.</p>
                    </div>
                    <div class="lp-page__point">
                        <h3>Cleaner month-end</h3>
                        <p>Reduce the scramble that happens when expenses are spread across receipts, messages, and memory.</p>
                    </div>
                    <div class="lp-page__point">
                        <h3>Better owner oversight</h3>
                        <p>Understand where money is moving without building a second admin system outside the platform.</p>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Compliance <em>Tracking</em></h2>
                <p>Service businesses often need better discipline around records, documents, and financial traceability. useLuminii supports better compliance tracking by keeping the operational record more organised.</p>
                <div class="lp-page__visual">
                    <div class="lp-page__visual-head">
                        <div class="lp-page__visual-title">Compliance support view</div>
                        <div class="lp-page__visual-badge">POPIA-aware</div>
                    </div>
                    <div class="lp-page__visual-rows">
                        <div class="lp-page__visual-row">
                            <div class="lp-page__visual-icon"><i class="ph ph-folders"></i></div>
                            <div>
                                <strong>Organised records</strong>
                                <span>Keep documents, customer context, and job-linked records easier to find and manage.</span>
                            </div>
                            <div class="lp-page__pill lp-page__pill--navy">Structured</div>
                        </div>
                        <div class="lp-page__visual-row">
                            <div class="lp-page__visual-icon"><i class="ph ph-shield-check"></i></div>
                            <div>
                                <strong>Cleaner traceability</strong>
                                <span>Support better operational discipline around what happened, when, and against which customer or job.</span>
                            </div>
                            <div class="lp-page__pill lp-page__pill--teal">Tracked</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <div class="lp-page__cta-band">
                    <h2>Reports and <em>Control</em></h2>
                    <p>Owners need to see what is coming in, what is stuck, what has been completed, and where pressure is building. Reports matter when they stay connected to real operational activity.</p>
                    <div class="lp-page__links">
                        <a href="{{ route('pricing') }}" class="lp-page__link-chip">View pricing</a>
                        <a href="{{ route('security') }}" class="lp-page__link-chip">Review security</a>
                        <a href="{{ route('contact.page') }}" class="lp-btn lp-btn--primary lp-btn--sm">Book a Demo</a>
                        <a href="{{ route('solutions.business-operating-system') }}" class="lp-btn lp-btn--outline lp-btn--sm">Get Your Business Flow Assessed</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.cta')
</div>
@endsection
