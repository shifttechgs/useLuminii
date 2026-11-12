@php
    $platformViews = [
        'enquiries' => ['title' => 'Enquiries', 'headline' => 'Know who needs a reply.', 'description' => 'Keep client details, requests and the next action together. Your team can pick up the conversation with the context already there.', 'icon' => 'ph-chat-circle-text'],
        'clients' => ['title' => 'Client history', 'headline' => 'The context stays with your business.', 'description' => 'Keep client details, requests and activity together, so the next person can pick up where the conversation left off.', 'icon' => 'ph-address-book'],
        'quotes' => ['title' => 'Quotes', 'headline' => 'See what is waiting on a yes.', 'description' => 'Build a quote, track its decision and keep the discussion against the client. An approved quote becomes the starting point for the job.', 'icon' => 'ph-file-text'],
        'jobs' => ['title' => 'Jobs', 'headline' => 'Give everyone the same plan.', 'description' => 'Bring the appointment, assigned technician and job status into one record. The office and the team work from the same information.', 'icon' => 'ph-calendar-check'],
        'payments' => ['title' => 'Payments', 'headline' => 'Know what is still outstanding.', 'description' => 'Connect the invoice to the work, record payments and see the remaining balance. Follow up with the full client history at hand.', 'icon' => 'ph-receipt'],
        'reports' => ['title' => 'Business reports', 'headline' => 'See the business behind the busy day.', 'description' => 'Bring revenue, expenses and outstanding invoices into view. Make the next decision with your business numbers in front of you.', 'icon' => 'ph-chart-line-up'],
    ];
@endphp

<section class="lp-platform lp-built" id="features" aria-labelledby="platform-heading">
    <div class="lp-wrap">
        <header class="lp-platform__intro">
            <div>
                <div class="lp-section__label">Built different</div>
                <h2 id="platform-heading">The details your business<br><em>cannot afford to miss.</em></h2>
            </div>
            <p>From the first enquiry to the final payment, your team works from the same client history, schedule and next step.</p>
        </header>

        <div class="lp-built__grid">
                @foreach($platformViews as $key => $view)
                    <article class="lp-platform__panel lp-built__card lp-built__card--{{ $key }}{{ $loop->first || $loop->last ? ' lp-built__card--wide' : '' }}" aria-labelledby="feature-title-{{ $key }}">
                        <div class="lp-platform__panel-copy">
                            <span class="lp-platform__eyebrow">/ 0{{ $loop->iteration }}</span>
                            <h3 id="feature-title-{{ $key }}">{{ $view['headline'] }}</h3>
                            <p>{{ $view['description'] }}</p>
                        </div>

                        <figure class="lp-platform__preview">
                            <div class="lp-platform__app-bar"><span class="lp-platform__wordmark">use<strong>Luminii</strong><span></span></span><span>Workspace / {{ $view['title'] }}</span><span class="lp-platform__avatar">TN</span></div>
                            <div class="lp-platform__app-body">
                                <div class="lp-platform__screen-title"><h4><i class="ph {{ $view['icon'] }}" aria-hidden="true"></i> {{ $view['title'] }}</h4><span>TN Plumbing</span></div>

                                @if($key === 'enquiries')
                                    <div class="lp-platform__table-wrap">
                                        <table class="lp-platform__table"><caption class="lp-platform__sr">Illustrative enquiry records</caption>
                                            <thead><tr><th>Client</th><th>Status</th><th>Next action</th></tr></thead>
                                            <tbody>
                                                <tr><td><strong>Amina Dlamini</strong><small>Geyser replacement · Sandton</small></td><td><span class="lp-platform__status">New</span></td><td>Make first contact</td></tr>
                                                <tr><td><strong>Oakwood Offices</strong><small>Maintenance · Rosebank</small></td><td><span class="lp-platform__status lp-platform__status--amber">Contacted</span></td><td>Qualify request</td></tr>
                                                <tr><td><strong>David Jacobs</strong><small>Leak repair · Bryanston</small></td><td><span class="lp-platform__status">Qualified</span></td><td>Send proposal</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="lp-platform__record-note"><i class="ph ph-address-book" aria-hidden="true"></i><span>Client details, service request and next action.<br><strong>Ready for the next conversation.</strong></span></div>
                                @elseif($key === 'quotes')
                                    <div class="lp-platform__document">
                                        <div class="lp-platform__document-head"><span>QUOTE / QUO-1042</span><span class="lp-platform__status lp-platform__status--green">Accepted</span></div>
                                        <h5>Geyser replacement</h5><p>Prepared for Amina Dlamini · Sandton</p>
                                        <dl class="lp-platform__line-items"><div><dt>150L geyser supply</dt><dd>R 5,500</dd></div><div><dt>Installation &amp; fittings</dt><dd>R 3,000</dd></div><div class="lp-platform__total"><dt>Total</dt><dd>R 8,500</dd></div></dl>
                                    </div>
                                    <div class="lp-platform__record-note"><i class="ph ph-check-circle" aria-hidden="true"></i><span>Quote accepted.<br><strong>Linked job created for scheduling.</strong></span></div>
                                @elseif($key === 'jobs')
                                    <div class="lp-platform__day"><span>Today's schedule</span><strong>3 jobs</strong></div>
                                    <ol class="lp-platform__schedule">
                                        <li><time>08:30</time><div><strong>Leak repair</strong><small>David Jacobs · Bryanston</small></div><span class="lp-platform__status lp-platform__status--green">Completed</span></li>
                                        <li class="lp-platform__schedule-current"><time>11:00</time><div><strong>Geyser replacement</strong><small>Amina Dlamini · Sandton</small><span class="lp-platform__assigned">Assigned to Thabo</span></div><span class="lp-platform__status">Scheduled</span></li>
                                        <li><time>14:30</time><div><strong>Maintenance visit</strong><small>Oakwood Offices · Rosebank</small></div><span class="lp-platform__status">Scheduled</span></li>
                                    </ol>
                                @elseif($key === 'payments')
                                    <div class="lp-platform__balance"><span>Outstanding balance</span><strong>R 8,500<span>.00</span></strong><small>INV-1042 · Amina Dlamini</small></div>
                                    <dl class="lp-platform__payment-details"><div><dt>Job</dt><dd>Geyser replacement</dd></div><div><dt>Invoice status</dt><dd><span class="lp-platform__status lp-platform__status--amber">Sent</span></dd></div><div><dt>Total paid</dt><dd>R 0.00</dd></div><div><dt>Balance due</dt><dd>R 8,500.00</dd></div></dl>
                                @elseif($key === 'clients')
                                    <div class="lp-built__client"><span>AD</span><div><strong>Amina Dlamini</strong><small>Sandton · Residential client</small></div></div>
                                    <ol class="lp-built__history"><li><span>Request</span><strong>Geyser replacement</strong><small>Site visit requested</small></li><li><span>Quote</span><strong>QUO-1042 · R 8,500</strong><small>Accepted by client</small></li><li><span>Job</span><strong>Assigned to Thabo</strong><small>Appointment scheduled</small></li></ol>
                                @else
                                    <div class="lp-built__report"><span>Revenue overview</span><strong>R 42,500<small>This month</small></strong><div class="lp-built__bars" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div><div class="lp-built__axis"><span>Week 1</span><span>Week 2</span><span>Week 3</span><span>Week 4</span></div></div>
                                    <dl class="lp-built__totals"><div><dt>Revenue</dt><dd>R 42,500</dd></div><div><dt>Expenses</dt><dd>R 18,200</dd></div><div><dt>Outstanding</dt><dd>R 8,500</dd></div></dl>
                                @endif
                            </div>
                            <figcaption>Illustrative product preview · Sample business and client data</figcaption>
                        </figure>
                    </article>
                @endforeach
        </div>

        <div class="lp-platform__footer"><p>One client record. The whole job history.</p><a href="{{ url('/') }}#booking">See it in a demo <i class="ph ph-arrow-right" aria-hidden="true"></i></a></div>
    </div>
</section>

