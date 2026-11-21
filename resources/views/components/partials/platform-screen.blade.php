{{-- One view of the sample client record. Expects $key and $view. --}}
<div class="lp-pf-screen__head">
    <h4><i class="ph {{ $view['icon'] }}" aria-hidden="true"></i> {{ $view['title'] }}</h4>
    <span>TN Plumbing</span>
</div>

@if($key === 'enquiries')
    <table class="lp-pf-table">
        <caption class="lp-pf-sr">Illustrative enquiry records</caption>
        <thead><tr><th>Client</th><th>Status</th><th>Next action</th></tr></thead>
        <tbody>
            <tr class="is-focus"><td><strong>Amina Dlamini</strong><small>Water heater replacement · Riverside</small></td><td><span class="lp-pf-pill">New</span></td><td>Make first contact</td></tr>
            <tr><td><strong>Oakwood Offices</strong><small>Maintenance · Northside</small></td><td><span class="lp-pf-pill lp-pf-pill--amber">Contacted</span></td><td>Qualify request</td></tr>
            <tr><td><strong>David Jacobs</strong><small>Leak repair · Lakeview</small></td><td><span class="lp-pf-pill">Qualified</span></td><td>Send proposal</td></tr>
        </tbody>
    </table>
    <p class="lp-pf-note"><i class="ph ph-address-book" aria-hidden="true"></i><span>Client details, service request and next action. <strong>Ready for the next conversation.</strong></span></p>

@elseif($key === 'clients')
    <div class="lp-pf-client"><span>AD</span><div><strong>Amina Dlamini</strong><small>Riverside · Residential client</small></div></div>
    <ol class="lp-pf-history">
        <li><span>Request</span><div><strong>Water heater replacement</strong><small>Site visit requested</small></div></li>
        <li><span>Quote</span><div><strong>QUO-1042 · 8,500</strong><small>Accepted by client</small></div></li>
        <li><span>Job</span><div><strong>Assigned to Thabo</strong><small>Appointment scheduled</small></div></li>
    </ol>

@elseif($key === 'quotes')
    <div class="lp-pf-doc">
        <div class="lp-pf-doc__head"><span>QUOTE / QUO-1042</span><span class="lp-pf-pill lp-pf-pill--green">Accepted</span></div>
        <h5>Water heater replacement</h5>
        <p>Prepared for Amina Dlamini · Riverside</p>
        <dl class="lp-pf-lines">
            <div><dt>150L water heater supply</dt><dd>5,500</dd></div>
            <div><dt>Installation &amp; fittings</dt><dd>3,000</dd></div>
            <div class="is-total"><dt>Total</dt><dd>8,500</dd></div>
        </dl>
    </div>
    <p class="lp-pf-note"><i class="ph ph-check-circle" aria-hidden="true"></i><span>Quote accepted. <strong>Linked job created for scheduling.</strong></span></p>

@elseif($key === 'jobs')
    <div class="lp-pf-day"><span>Today's schedule</span><strong>3 jobs</strong></div>
    <ol class="lp-pf-schedule">
        <li><time>08:30</time><div><strong>Leak repair</strong><small>David Jacobs · Lakeview</small></div><span class="lp-pf-pill lp-pf-pill--green">Completed</span></li>
        <li class="is-focus"><time>11:00</time><div><strong>Water heater replacement</strong><small>Amina Dlamini · Riverside · Assigned to Thabo</small></div><span class="lp-pf-pill">Scheduled</span></li>
        <li><time>14:30</time><div><strong>Maintenance visit</strong><small>Oakwood Offices · Northside</small></div><span class="lp-pf-pill">Scheduled</span></li>
    </ol>
    <p class="lp-pf-note"><i class="ph ph-users-three" aria-hidden="true"></i><span>Appointment, technician and status in one record. <strong>The office and the team work from the same plan.</strong></span></p>

@elseif($key === 'payments')
    <div class="lp-pf-balance"><span>Outstanding balance</span><strong>8,500<small>.00</small></strong><em>INV-1042 · Amina Dlamini</em></div>
    <dl class="lp-pf-lines lp-pf-lines--plain">
        <div><dt>Job</dt><dd>Water heater replacement</dd></div>
        <div><dt>Invoice status</dt><dd><span class="lp-pf-pill lp-pf-pill--amber">Sent</span></dd></div>
        <div><dt>Total paid</dt><dd>0.00</dd></div>
        <div class="is-total"><dt>Balance due</dt><dd>8,500.00</dd></div>
    </dl>

@else
    <div class="lp-pf-report">
        <div class="lp-pf-report__top"><span>Revenue overview</span><strong>42,500<small>This month</small></strong></div>
        <div class="lp-pf-bars" aria-hidden="true">
            @foreach([38, 52, 46, 64, 58, 74, 92] as $bar)<span style="--v: {{ $bar }}%"></span>@endforeach
        </div>
        <div class="lp-pf-axis" aria-hidden="true"><span>Week 1</span><span>Week 2</span><span>Week 3</span><span>Week 4</span></div>
    </div>
    <dl class="lp-pf-totals">
        <div><dt>Revenue</dt><dd>42,500</dd></div>
        <div><dt>Expenses</dt><dd>18,200</dd></div>
        <div><dt>Outstanding</dt><dd>8,500</dd></div>
    </dl>
@endif
