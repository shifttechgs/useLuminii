@extends('layouts.app')

@section('title', 'Business Operating System for Service Businesses')
@section('description', 'A business operating system for service businesses that connects leads, quotes, jobs, invoices, expenses, and reporting.')
@section('keywords', 'business operating system for service businesses, service business software, service business CRM, business management system for service companies, service business automation software')
@section('og_title', 'A Business Operating System for Service Businesses')
@section('og_description', 'See how useLuminii gives service-business owners more clarity, control, and less chaos.')

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
      "name": "Solutions",
      "item": "{{ url('/solutions/business-operating-system-for-service-businesses') }}"
    },
    {
      "@@type": "ListItem",
      "position": 3,
      "name": "Business Operating System for Service Businesses",
      "item": "{{ route('solutions.business-operating-system') }}"
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
                <div class="lp-section__label" data-aos="fade-up">Solution</div>
                <h1 class="lp-ph__h1" data-aos="fade-up" data-aos-delay="60">A Business Operating System <em>for Service Businesses</em></h1>
                <p class="lp-ph__sub" data-aos="fade-up" data-aos-delay="120">useLuminii gives service businesses one connected flow for leads, quotes, jobs, invoicing, expenses, and reporting.</p>
                <div class="lp-ph__breadcrumb" data-aos="fade-up" data-aos-delay="160">
                    <a href="{{ url('/') }}">Home</a>
                    <span>/</span>
                    <span>Solutions</span>
                </div>
            </div>
        </div>
    </section>

    <section class="lp-page">
        <div class="lp-wrap">
            <div class="lp-page__section">
                <div class="lp-page__grid">
                    <div>
                        <div class="lp-page__eyebrow">Category Positioning</div>
                        <p class="lp-page__lead">This is not a basic CRM or a thin service layer. useLuminii is designed as the system that connects how service companies actually operate day to day.</p>
                        <div class="lp-page__links">
                            <a href="{{ route('features') }}" class="lp-page__link-chip">Explore features</a>
                            <a href="{{ route('pricing') }}" class="lp-page__link-chip">View pricing</a>
                            <a href="{{ route('contact.page') }}" class="lp-page__link-chip">Book a Demo</a>
                        </div>
                    </div>
                    <div class="lp-page__visual">
                        <div class="lp-page__visual-head">
                            <div class="lp-page__visual-title">What this category means</div>
                            <div class="lp-page__visual-badge">Operational clarity</div>
                        </div>
                        <div class="lp-page__visual-rows">
                            <div class="lp-page__visual-row">
                                <div class="lp-page__visual-icon"><i class="ph ph-user-gear"></i></div>
                                <div>
                                    <strong>Built for service business owners</strong>
                                    <span>Designed for businesses that need clearer control instead of more admin.</span>
                                </div>
                                <div class="lp-page__pill lp-page__pill--gold">Focused</div>
                            </div>
                            <div class="lp-page__visual-row">
                                <div class="lp-page__visual-icon"><i class="ph ph-chat-circle-dots"></i></div>
                                <div>
                                    <strong>Replaces fragmentation</strong>
                                    <span>Created for operations spread across WhatsApp, spreadsheets, paper, and memory.</span>
                                </div>
                                <div class="lp-page__pill lp-page__pill--navy">Unified</div>
                            </div>
                            <div class="lp-page__visual-row">
                                <div class="lp-page__visual-icon"><i class="ph ph-graph"></i></div>
                                <div>
                                    <strong>Connects the commercial and operational flow</strong>
                                    <span>Keeps leads, quoting, jobs, invoicing, expenses, and reporting linked.</span>
                                </div>
                                <div class="lp-page__pill lp-page__pill--teal">Connected</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Why Service Businesses <em>Become Chaotic</em></h2>
                <p>Growth makes the gaps harder to ignore. More enquiries, more quotes, more jobs, more chasing, and more admin all hit at once. Owners end up carrying too much of the business in their heads because the process is not connected.</p>
                <div class="lp-page__cards-3">
                        <div class="lp-page__card">
                            <h3>Demand increases pressure</h3>
                            <p>More leads and jobs expose weak handoffs faster than small teams can patch them manually.</p>
                        </div>
                        <div class="lp-page__card">
                            <h3>Admin expands silently</h3>
                            <p>Owners often do not notice how much manual checking and chasing has become normal.</p>
                        </div>
                        <div class="lp-page__card">
                            <h3>Visibility drops as complexity rises</h3>
                            <p>The business grows, but control does not grow with it unless the workflow is connected.</p>
                        </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>Why Disconnected <em>Tools Fail</em></h2>
                <p>One tool may hold leads, another handles billing, another lives in the team chat, and some information never leaves the owner's phone. That creates delays, missed follow-ups, duplicate effort, and weak visibility. The problem is the missing flow between them.</p>
                <div class="lp-page__compare">
                    <div class="lp-page__compare-grid">
                        <div class="lp-page__compare-block lp-page__compare-block--soft">
                            <h3>Disconnected stack</h3>
                            <p>Separate tools create separate truths, forcing the owner or admin team to glue the business together manually.</p>
                        </div>
                        <div class="lp-page__compare-block lp-page__compare-block--strong">
                            <h3>Connected operating system</h3>
                            <p>The workflow continues from one stage to the next, reducing re-entry, missed details, and hidden bottlenecks.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>The useLuminii <em>Operating Flow</em></h2>
                <div class="lp-page__rail">
                    <div class="lp-page__rail-head">
                        <div>
                            <h3>One operational spine</h3>
                            <p>The system is valuable because each stage feeds the next instead of restarting it.</p>
                        </div>
                        <div class="lp-page__pill lp-page__pill--gold">End-to-end</div>
                    </div>
                    <div class="lp-page__rail-steps">
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">1</div>
                            <div>
                                <strong>Lead to Response</strong>
                                <span>Capture website and inbound enquiries clearly and keep response activity visible.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">2</div>
                            <div>
                                <strong>Response to Quote</strong>
                                <span>Move customers into a clear quoting process without losing service context.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">3</div>
                            <div>
                                <strong>Quote to Job</strong>
                                <span>Turn approved work into scheduled, assigned, trackable operations.</span>
                            </div>
                        </div>
                        <div class="lp-page__rail-step">
                            <div class="lp-page__rail-num">4</div>
                            <div>
                                <strong>Job to Financial Control</strong>
                                <span>Link work completion to invoicing, expenses, records, and reporting.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>How the Owner <em>Gets Control</em></h2>
                <p>Control does not come from having more dashboards. It comes from having one connected system where the owner can see the next operational step, the current bottleneck, and the financial effect of what the team is doing.</p>
                <div class="lp-page__metrics">
                    <div class="lp-page__metrics-grid">
                        <div class="lp-page__metric">
                            <div class="lp-page__metric-value">Clear</div>
                            <strong>What is waiting</strong>
                            <span>See leads, quotes, and jobs that need action before they become hidden problems.</span>
                        </div>
                        <div class="lp-page__metric">
                            <div class="lp-page__metric-value">Live</div>
                            <strong>What is moving</strong>
                            <span>Track which work is active, assigned, completed, billed, or still stuck in handoff.</span>
                        </div>
                        <div class="lp-page__metric">
                            <div class="lp-page__metric-value">Visible</div>
                            <strong>Where money is going</strong>
                            <span>Keep invoicing, expenses, and reporting closer to the operational work that drives them.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                    <h2>Who <em>It Is For</em></h2>
                    <p>useLuminii is for service business owners, founder-led companies, and operations-heavy teams tired of piecing the business together through chat threads, inboxes, spreadsheets, and manual follow-ups.</p>
                <div class="lp-page__mini-grid">
                    <div class="lp-page__mini">
                        <strong>Founder-led businesses</strong>
                        <span>Where the owner is still carrying too much coordination and operational memory.</span>
                    </div>
                    <div class="lp-page__mini">
                        <strong>Local service companies</strong>
                        <span>Where enquiries, quoting, scheduling, and invoicing need tighter day-to-day control.</span>
                    </div>
                    <div class="lp-page__mini">
                        <strong>Operations-heavy teams</strong>
                        <span>Where field work, admin work, and financial follow-through need to stay aligned.</span>
                    </div>
                </div>
            </div>

            <div class="lp-page__section">
                <h2>What <em>It Replaces</em></h2>
                <p>It reduces scattered admin, disconnected CRM tools, manual handoffs, and fragile memory-based operations. It gives the business a more reliable system for how work moves from enquiry to control.</p>
            </div>

            <div class="lp-page__section">
                <div class="lp-page__card">
                    <div class="lp-page__eyebrow">Before and After</div>
                    <h2>See the difference <em>in one flow</em></h2>
                    <div class="lp-page__compare-grid">
                        <div class="lp-page__compare-block lp-page__compare-block--soft">
                            <h3>Before</h3>
                            <p>Leads are missed, quotes are slow, jobs are hard to track, and owners carry too much of the process manually.</p>
                        </div>
                        <div class="lp-page__compare-block lp-page__compare-block--strong">
                            <h3>After</h3>
                            <p>The business runs through one connected flow, making follow-up, execution, billing, and reporting easier to control.</p>
                        </div>
                    </div>
                    <div class="lp-page__links">
                        <a href="{{ route('features') }}" class="lp-page__link-chip">Explore features</a>
                        <a href="{{ route('pricing') }}" class="lp-page__link-chip">View pricing</a>
                        <a href="{{ route('contact.page') }}" class="lp-btn lp-btn--primary lp-btn--sm">Book a Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.cta')
</div>
@endsection
