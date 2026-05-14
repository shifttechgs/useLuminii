<x-crm::layout title="Dashboard">

{{-- ── Greeting Header ── --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.75rem;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1 style="font-size:1.5rem;font-weight:700;color:var(--crm-text-1,#0d1b2e);letter-spacing:-0.03em;margin:0 0 0.25rem;">
            Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', auth()->user()->name)[0] }}
        </h1>
        <p style="font-size:0.875rem;color:var(--crm-text-3,#8898aa);margin:0;">
            {{ now()->format('l, d F Y') }} &middot; Here's what's happening today
        </p>
    </div>
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;align-items:center;">
        <button type="button" class="crm-btn crm-btn-primary" id="qcToggleBtn" onclick="crmQC.toggle()">
            <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Quick Capture
        </button>

        <div class="crm-more-actions" id="crmMoreActionsWrap">
            <button type="button" class="crm-btn crm-btn-secondary" onclick="crmMoreActions.toggle()" aria-haspopup="true">
                More actions
                <svg id="crmMoreActionsChevron" style="width:0.875rem;height:0.875rem;transition:transform 150ms ease;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="crm-more-actions-menu" id="crmMoreActionsMenu">
                <a href="{{ route('crm.clients.create') }}" class="crm-more-actions-item">
                    <svg style="width:0.875rem;height:0.875rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    New Client
                </a>
                <a href="{{ route('crm.quotes.create') }}" class="crm-more-actions-item">
                    <svg style="width:0.875rem;height:0.875rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    New Quote
                </a>
                <a href="{{ route('crm.jobs.create') }}" class="crm-more-actions-item">
                    <svg style="width:0.875rem;height:0.875rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    New Job
                </a>
                <a href="{{ route('crm.invoices.create') }}" class="crm-more-actions-item">
                    <svg style="width:0.875rem;height:0.875rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    New Invoice
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── Quick Capture Panel ── --}}
<div id="qcPanel" class="qc-panel" style="display:none;margin-bottom:1.5rem;">
    <div class="qc-panel-inner">
        <div class="qc-panel-header">
            <div>
                <h3 class="qc-panel-title">Quick Capture</h3>
                <p class="qc-panel-sub">On a call? Capture now, refine later.</p>
            </div>
            <button type="button" class="crm-icon-btn" onclick="crmQC.close()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Tabs --}}
        <div class="qc-tabs">
            <button type="button" class="qc-tab qc-tab-active" onclick="crmQC.switchTab('lead',this)">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:0.875rem;height:0.875rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                New Lead
            </button>
            <button type="button" class="qc-tab" onclick="crmQC.switchTab('request',this)">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:0.875rem;height:0.875rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Existing Client Request
            </button>
        </div>

        {{-- Tab: New Lead --}}
        <div id="qcPaneLead" class="qc-pane">
            <form method="POST" action="{{ route('crm.leads.store') }}">
            @csrf
            <div class="qc-grid-3">
                <div>
                    <label class="crm-label">Full Name <span style="color:var(--color-danger)">*</span></label>
                    <input type="text" name="name" class="crm-input" required placeholder="Jane Smith" autofocus>
                </div>
                <div>
                    <label class="crm-label">Phone</label>
                    <input type="text" name="phone" class="crm-input" placeholder="+27 …">
                </div>
                <div>
                    <label class="crm-label">Email</label>
                    <input type="email" name="email" class="crm-input" placeholder="jane@example.com">
                </div>
            </div>

            {{-- Source & Priority pills --}}
            <div style="display:flex;gap:1.5rem;flex-wrap:wrap;margin:1rem 0 0.5rem;">
                <div>
                    <div class="qc-pill-label">Source</div>
                    <div class="qc-pills" id="qcLeadSource">
                        <input type="hidden" name="source" value="call">
                        @foreach(\App\Models\Lead::sourceOptions() as $key => $label)
                        <button type="button" class="qc-pill {{ $key==='call'?'qc-pill-on':'' }}" data-val="{{ $key }}" onclick="crmQC.pill(this,'qcLeadSource','source')">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div class="qc-pill-label">Priority</div>
                    <div class="qc-pills" id="qcLeadPriority">
                        <input type="hidden" name="priority" value="">
                        @foreach(['Low','Normal','High','Urgent'] as $p)
                        <button type="button" class="qc-pill" data-val="{{ $p }}" onclick="crmQC.pill(this,'qcLeadPriority','priority')">{{ $p }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Services chips --}}
            @if($quickServices->count())
            <div style="margin-bottom:1rem;">
                <div class="qc-pill-label">Services Interested In</div>
                <div style="display:flex;flex-wrap:wrap;gap:0.375rem;">
                    @foreach($quickServices as $svc)
                    <label class="qc-chip">
                        <input type="checkbox" name="services_interested[]" value="{{ $svc->name }}" style="position:absolute;opacity:0;width:0;height:0;">
                        {{ $svc->name }}
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <input type="hidden" name="status" value="New">
            <div style="display:flex;justify-content:flex-end;gap:0.5rem;margin-top:0.75rem;">
                <button type="button" class="crm-btn crm-btn-ghost" onclick="crmQC.close()">Cancel</button>
                <button type="submit" class="crm-btn crm-btn-primary">Save Lead</button>
                <a href="{{ route('crm.leads.create') }}" class="crm-btn crm-btn-secondary" title="Full form">Full Form →</a>
            </div>
            </form>
        </div>

        {{-- Tab: New Request (existing client) --}}
        <div id="qcPaneRequest" class="qc-pane" style="display:none;">
            <form method="POST" action="{{ route('crm.requests.store') }}">
            @csrf
            <div class="qc-grid-3">
                <div style="grid-column:span 2;">
                    <label class="crm-label">Client <span style="color:var(--color-danger)">*</span></label>
                    <select name="client_id" class="crm-select" required>
                        <option value="">— Select Client —</option>
                        @foreach($quickClients as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Service Requested</label>
                    <select name="service_id" class="crm-select">
                        <option value="">— Service —</option>
                        @foreach($quickServices->groupBy('category') as $cat => $svcs)
                        <optgroup label="{{ $cat ?: 'General' }}">
                            @foreach($svcs as $svc)
                            <option value="{{ $svc->service_id }}">{{ $svc->name }}</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="margin-top:0.75rem;">
                <label class="crm-label">What do they need? <span style="color:var(--color-danger)">*</span></label>
                <input type="text" name="title" class="crm-input" required placeholder="e.g. New website, logo redesign, SEO audit…">
            </div>

            {{-- Priority pills --}}
            <div style="margin:1rem 0 0.5rem;">
                <div class="qc-pill-label">Priority</div>
                <div class="qc-pills" id="qcReqPriority">
                    <input type="hidden" name="priority" value="">
                    @foreach(['Low','Medium','High','Urgent'] as $p)
                    <button type="button" class="qc-pill" data-val="{{ $p }}" onclick="crmQC.pill(this,'qcReqPriority','priority')">{{ $p }}</button>
                    @endforeach
                </div>
            </div>

            <input type="hidden" name="status" value="New">
            <div style="display:flex;justify-content:flex-end;gap:0.5rem;margin-top:0.75rem;">
                <button type="button" class="crm-btn crm-btn-ghost" onclick="crmQC.close()">Cancel</button>
                <button type="submit" class="crm-btn crm-btn-primary">Save Request</button>
                <a href="{{ route('crm.requests.create') }}" class="crm-btn crm-btn-secondary" title="Full form">Full Form →</a>
            </div>
            </form>
        </div>

    </div>
</div>

{{-- ── Stats Row — 5 unified cards ── --}}
<div class="dash-stats-row">

    {{-- Total Clients --}}
    <div class="dash-stat">
        <div class="dash-stat-top">
            <span class="dash-stat-label">Total Clients</span>
            <span class="dash-stat-icon" style="background:rgba(99,91,255,0.08);">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" style="color:#635bff;"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128H5.228A2 2 0 013 17.16V17a6.002 6.002 0 017.5-5.804A5.98 5.98 0 0112 14.186a5.98 5.98 0 011.5-3.004M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </span>
        </div>
        <span class="dash-stat-value">{{ number_format($stats['total_clients']) }}</span>
        <span class="dash-stat-sub">
            @if($stats['new_clients_month'] > 0)
                <span class="dash-trend dash-trend-up">+{{ $stats['new_clients_month'] }}</span> this month
            @else
                <span style="color:var(--crm-text-3);">{{ $stats['leads'] }} leads</span>
            @endif
        </span>
    </div>

    {{-- Active Jobs --}}
    <div class="dash-stat">
        <div class="dash-stat-top">
            <span class="dash-stat-label">Active Jobs</span>
            <span class="dash-stat-icon" style="background:rgba(46,144,250,0.08);">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" style="color:#2e90fa;"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
            </span>
        </div>
        <span class="dash-stat-value">{{ $stats['active_jobs'] }}</span>
        <span class="dash-stat-sub">
            <span class="dash-trend dash-trend-up">{{ $stats['completed_month'] }}</span> completed this month
        </span>
    </div>

    {{-- Revenue --}}
    <div class="dash-stat">
        <div class="dash-stat-top">
            <span class="dash-stat-label">Revenue</span>
            <span class="dash-stat-icon" style="background:rgba(18,183,106,0.08);">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" style="color:#12b76a;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
            </span>
        </div>
        <span class="dash-stat-value" style="font-size:1.375rem;">R {{ number_format($stats['revenue_paid'], 2) }}</span>
        <span class="dash-stat-sub">
            @php $revDiff = $stats['revenue_last'] > 0 ? round((($stats['revenue_paid'] - $stats['revenue_last']) / $stats['revenue_last']) * 100) : 0; @endphp
            @if($revDiff > 0)
                <span class="dash-trend dash-trend-up">↑ {{ $revDiff }}%</span> vs last month
            @elseif($revDiff < 0)
                <span class="dash-trend dash-trend-down">↓ {{ abs($revDiff) }}%</span> vs last month
            @else
                <span style="color:var(--crm-text-3);">R {{ number_format($stats['revenue_pending'], 2) }} pending</span>
            @endif
        </span>
    </div>

    {{-- Overdue Invoices --}}
    <div class="dash-stat {{ $stats['overdue_count'] > 0 ? 'dash-stat-alert' : '' }}">
        <div class="dash-stat-top">
            <span class="dash-stat-label" {!! $stats['overdue_count'] > 0 ? 'style="color:#f04438;"' : '' !!}>Overdue</span>
            <span class="dash-stat-icon" style="background:{{ $stats['overdue_count'] > 0 ? 'rgba(240,68,56,0.08)' : 'rgba(136,152,170,0.08)' }};">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" style="color:{{ $stats['overdue_count'] > 0 ? '#f04438' : '#8898aa' }};"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            </span>
        </div>
        <span class="dash-stat-value" {!! $stats['overdue_count'] > 0 ? 'style="color:#f04438;"' : '' !!}>{{ $stats['overdue_count'] }}</span>
        <span class="dash-stat-sub">
            @if($stats['overdue_count'] > 0)
                <span style="color:#f04438;font-weight:500;">R {{ number_format($stats['overdue_value'], 2) }}</span> outstanding
            @else
                <span style="color:#12b76a;font-weight:500;">All clear</span>
            @endif
        </span>
    </div>

    {{-- Open Quotes --}}
    <div class="dash-stat">
        <div class="dash-stat-top">
            <span class="dash-stat-label">Open Quotes</span>
            <span class="dash-stat-icon" style="background:rgba(247,144,9,0.08);">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" style="color:#f79009;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </span>
        </div>
        <span class="dash-stat-value">{{ $stats['open_quotes'] }}</span>
        <span class="dash-stat-sub">
            <span style="color:var(--crm-text-2);font-weight:500;">R {{ number_format($stats['open_quotes_value'], 0) }}</span> pipeline
        </span>
    </div>

</div>

{{-- ── Quick Pulse Alerts ── --}}
@if($stats['website_leads'] > 0 || $stats['open_requests'] > 0)
<div class="dash-alerts">
    @if($stats['website_leads'] > 0)
    <a href="{{ route('crm.leads.index') }}" class="dash-alert dash-alert-info">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1rem;height:1rem;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
        <span><strong>{{ $stats['website_leads'] }} new website lead{{ $stats['website_leads'] > 1 ? 's' : '' }}</strong> awaiting response</span>
        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:0.875rem;height:0.875rem;margin-left:auto;flex-shrink:0;opacity:0.5;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
    </a>
    @endif
    @if($stats['open_requests'] > 0)
    <a href="{{ route('crm.requests.index') }}" class="dash-alert dash-alert-warning">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1rem;height:1rem;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
        <span><strong>{{ $stats['open_requests'] }} open request{{ $stats['open_requests'] > 1 ? 's' : '' }}</strong> need attention</span>
        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:0.875rem;height:0.875rem;margin-left:auto;flex-shrink:0;opacity:0.5;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
    </a>
    @endif
</div>
@endif

{{-- ── Revenue Chart + Activity Feed ── --}}
<div class="dash-grid-2" style="margin-bottom:1.25rem;">

    {{-- Revenue Chart --}}
    <div class="dash-card" style="flex:1.6;">
        <div class="dash-card-header">
            <div>
                <h3 class="dash-card-title">Revenue Overview</h3>
                <p class="dash-card-subtitle">Last 6 months &middot; Revenue vs Expenses</p>
            </div>
            <div style="display:flex;align-items:center;gap:1rem;">
                <span class="dash-legend"><span class="dash-legend-dot" style="background:#12b76a;"></span> Revenue</span>
                <span class="dash-legend"><span class="dash-legend-dot" style="background:#fecdca;"></span> Expenses</span>
            </div>
        </div>
        <div style="padding:0.5rem 1.5rem 1.25rem;height:240px;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Activity Feed --}}
    <div class="dash-card" style="flex:1;max-width:380px;">
        <div class="dash-card-header">
            <h3 class="dash-card-title">Recent Activity</h3>
        </div>
        <div class="dash-activity-feed">
            @forelse($recentActivity as $activity)
            <div class="dash-activity-item">
                <div class="dash-activity-avatar">
                    {{ $activity->user ? strtoupper(substr($activity->user->name, 0, 1)) : '?' }}
                </div>
                <div style="flex:1;min-width:0;">
                    <p class="dash-activity-text">
                        <strong>{{ $activity->user->name ?? 'System' }}</strong>
                        {{ $activity->description }}
                    </p>
                    <p class="dash-activity-time">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div style="padding:2rem 1.5rem;text-align:center;">
                <p style="font-size:0.8125rem;color:var(--crm-text-3);">No recent activity</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ── Upcoming Jobs + Overdue Invoices + Recent Quotes ── --}}
<div class="dash-grid-3">

    {{-- Upcoming Jobs --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <h3 class="dash-card-title">Upcoming Jobs</h3>
            <a href="{{ route('crm.jobs.index') }}" class="dash-link">View all →</a>
        </div>
        <div class="dash-card-table">
            <table>
                <thead><tr><th>Job</th><th>Client</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                @forelse($upcomingJobs as $job)
                <tr onclick="window.location='{{ route('crm.jobs.show', $job) }}'" style="cursor:pointer;">
                    <td>
                        <span class="dash-cell-primary">{{ Str::limit($job->job_title, 24) }}</span>
                        <span class="dash-cell-secondary">{{ $job->job_id }}</span>
                    </td>
                    <td class="dash-cell-text">{{ $job->client->full_name ?? '—' }}</td>
                    <td>@include('crm.partials.job-badge', ['status' => $job->job_status])</td>
                    <td class="dash-cell-muted">{{ $job->job_date_time ? $job->job_date_time->format('d M') : '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="dash-empty-cell">No upcoming jobs</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Overdue Invoices --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <h3 class="dash-card-title" {!! $overdueInvoices->count() > 0 ? 'style="color:#f04438;"' : '' !!}>Overdue Invoices</h3>
            <a href="{{ route('crm.invoices.index', ['status' => 'Overdue']) }}" class="dash-link">View all →</a>
        </div>
        <div class="dash-card-table">
            <table>
                <thead><tr><th>Invoice</th><th>Client</th><th>Amount</th><th>Due</th></tr></thead>
                <tbody>
                @forelse($overdueInvoices as $inv)
                <tr onclick="window.location='{{ route('crm.invoices.show', $inv) }}'" style="cursor:pointer;">
                    <td class="dash-cell-mono">{{ $inv->invoice_id }}</td>
                    <td class="dash-cell-text">{{ $inv->client->full_name ?? '—' }}</td>
                    <td style="font-weight:600;color:#f04438;font-size:0.8125rem;">R {{ number_format($inv->balance, 2) }}</td>
                    <td class="dash-cell-muted" style="color:#f04438;">{{ $inv->due_date ? $inv->due_date->format('d M') : '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="dash-empty-cell" style="color:#12b76a;">
                    ✓ No overdue invoices
                </td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Quotes --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <h3 class="dash-card-title">Open Quotes</h3>
            <a href="{{ route('crm.quotes.index') }}" class="dash-link">View all →</a>
        </div>
        <div class="dash-card-table">
            <table>
                <thead><tr><th>Quote</th><th>Client</th><th>Amount</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($recentQuotes as $q)
                <tr onclick="window.location='{{ route('crm.quotes.show', $q) }}'" style="cursor:pointer;">
                    <td class="dash-cell-mono">{{ $q->quote_id }}</td>
                    <td class="dash-cell-text">{{ $q->client->full_name ?? '—' }}</td>
                    <td style="font-weight:600;font-size:0.8125rem;color:var(--crm-text-1);">R {{ number_format($q->grand_total, 2) }}</td>
                    <td>
                        @php
                            $qCls = match($q->status) {
                                'Draft' => 'crm-badge-neutral',
                                'Sent' => 'crm-badge-info',
                                'Accepted' => 'crm-badge-success',
                                'Declined' => 'crm-badge-danger',
                                default => 'crm-badge-neutral',
                            };
                        @endphp
                        <span class="crm-badge {{ $qCls }}"><span class="crm-badge-dot"></span>{{ $q->status }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="dash-empty-cell">No open quotes</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('revenueChart');
const labels = @json(collect($revenueChart)->pluck('label'));
const revenues = @json(collect($revenueChart)->pluck('revenue'));
const expenses = @json(collect($revenueChart)->pluck('expenses'));

new Chart(ctx, {
    type: 'bar',
    data: {
        labels,
        datasets: [
            {
                label: 'Revenue',
                data: revenues,
                backgroundColor: '#12b76a',
                borderRadius: 4,
                borderSkipped: false,
                barPercentage: 0.6,
                categoryPercentage: 0.7,
            },
            {
                label: 'Expenses',
                data: expenses,
                backgroundColor: '#fecdca',
                borderRadius: 4,
                borderSkipped: false,
                barPercentage: 0.6,
                categoryPercentage: 0.7,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#0d1b2e',
                titleFont: { family: 'Inter', size: 12, weight: '600' },
                bodyFont: { family: 'Inter', size: 12 },
                padding: 10,
                cornerRadius: 8,
                callbacks: { label: ctx => ctx.dataset.label + ': R ' + ctx.raw.toLocaleString('en-ZA', { minimumFractionDigits: 2 }) }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { font: { family: 'Inter', size: 11, weight: '500' }, color: '#8898aa' },
                border: { display: false }
            },
            y: {
                grid: { color: '#f0f2f5', drawBorder: false },
                ticks: {
                    font: { family: 'Inter', size: 11 },
                    color: '#8898aa',
                    callback: v => 'R' + (v >= 1000 ? (v/1000).toFixed(0) + 'k' : v),
                    maxTicksLimit: 5
                },
                border: { display: false }
            }
        }
    }
});
</script>
@endpush

@push('head')
<style>
/* ── Dashboard Stats Row ── */
.dash-stats-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 0;
    margin-bottom: 1.5rem;
    background: #fff;
    border: 1px solid var(--crm-border, #e4e9f0);
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(13,27,46,0.04);
    overflow: hidden;
}
.dash-stat {
    padding: 1.25rem 1.375rem;
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
    border-right: 1px solid var(--crm-border, #e4e9f0);
    transition: background 0.15s ease;
}
.dash-stat:last-child { border-right: none; }
.dash-stat:hover { background: #fafbfc; }
.dash-stat-alert { background: #fffbfa; }
.dash-stat-alert:hover { background: #fef3f2; }
.dash-stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.dash-stat-label {
    font-size: 0.6875rem;
    font-weight: 600;
    color: var(--crm-text-3, #8898aa);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.dash-stat-icon {
    width: 2rem;
    height: 2rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.dash-stat-icon svg { width: 1.125rem; height: 1.125rem; }
.dash-stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--crm-text-1, #0d1b2e);
    letter-spacing: -0.04em;
    line-height: 1;
}
.dash-stat-sub {
    font-size: 0.8125rem;
    color: var(--crm-text-3, #8898aa);
}
.dash-trend { font-weight: 600; font-size: 0.8125rem; }
.dash-trend-up { color: #12b76a; }
.dash-trend-down { color: #f04438; }

/* ── Alerts ── */
.dash-alerts { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.5rem; }
.dash-alert {
    display: flex; align-items: center; gap: 0.625rem;
    padding: 0.75rem 1rem; border-radius: 10px;
    font-size: 0.8125rem; text-decoration: none; transition: all 0.15s ease;
}
.dash-alert:hover { filter: brightness(0.97); }
.dash-alert-info { background: #eff8ff; border: 1px solid #b2ddff; color: #175cd3; }
.dash-alert-warning { background: #fffaeb; border: 1px solid #fedf89; color: #b54708; }

/* ── Cards ── */
.dash-card {
    background: #fff; border: 1px solid var(--crm-border, #e4e9f0);
    border-radius: 12px; box-shadow: 0 1px 3px rgba(13,27,46,0.04); overflow: hidden;
}
.dash-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.5rem; border-bottom: 1px solid var(--crm-border, #e4e9f0);
}
.dash-card-title { font-size: 0.875rem; font-weight: 600; color: var(--crm-text-1, #0d1b2e); margin: 0; }
.dash-card-subtitle { font-size: 0.75rem; color: var(--crm-text-3, #8898aa); margin: 0.125rem 0 0; }
.dash-link { font-size: 0.75rem; font-weight: 500; color: var(--crm-accent, #635bff); text-decoration: none; white-space: nowrap; }
.dash-link:hover { text-decoration: underline; }

/* ── Legend ── */
.dash-legend { display: flex; align-items: center; gap: 0.375rem; font-size: 0.6875rem; font-weight: 500; color: var(--crm-text-3, #8898aa); }
.dash-legend-dot { width: 8px; height: 8px; border-radius: 2px; flex-shrink: 0; }

/* ── Tables in cards ── */
.dash-card-table { overflow-x: auto; }
.dash-card-table table { width: 100%; border-collapse: collapse; font-size: 0.8125rem; }
.dash-card-table thead th {
    padding: 0.625rem 1rem; font-size: 0.6875rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.04em; color: var(--crm-text-3, #8898aa);
    background: #fafbfc; border-bottom: 1px solid var(--crm-border, #e4e9f0); text-align: left; white-space: nowrap;
}
.dash-card-table tbody tr { border-bottom: 1px solid #f0f2f5; transition: background 0.1s ease; }
.dash-card-table tbody tr:hover { background: #fafbfc; }
.dash-card-table tbody tr:last-child { border-bottom: none; }
.dash-card-table tbody td { padding: 0.625rem 1rem; vertical-align: middle; }
.dash-cell-primary { display: block; font-weight: 500; color: var(--crm-text-1); font-size: 0.8125rem; }
.dash-cell-secondary { display: block; font-size: 0.6875rem; color: var(--crm-text-3); font-family: 'SF Mono','Fira Code',monospace; }
.dash-cell-text { font-size: 0.8125rem; color: var(--crm-text-2, #5a6a7e); }
.dash-cell-muted { font-size: 0.75rem; color: var(--crm-text-3, #8898aa); }
.dash-cell-mono { font-size: 0.8125rem; font-weight: 500; font-family: 'SF Mono','Fira Code',monospace; color: var(--crm-text-2); }
.dash-empty-cell { text-align: center; padding: 2rem 1rem !important; color: var(--crm-text-3); font-size: 0.8125rem; }

/* ── Activity Feed ── */
.dash-activity-feed { max-height: 340px; overflow-y: auto; }
.dash-activity-item {
    display: flex; gap: 0.75rem; padding: 0.75rem 1.25rem;
    border-bottom: 1px solid #f0f2f5; transition: background 0.1s ease;
}
.dash-activity-item:hover { background: #fafbfc; }
.dash-activity-item:last-child { border-bottom: none; }
.dash-activity-avatar {
    width: 2rem; height: 2rem; border-radius: 50%;
    background: var(--crm-bg, #f4f6f9); color: var(--crm-text-2);
    font-size: 0.6875rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.dash-activity-text { font-size: 0.8125rem; color: var(--crm-text-2); line-height: 1.4; margin: 0; }
.dash-activity-text strong { color: var(--crm-text-1); font-weight: 600; }
.dash-activity-time { font-size: 0.6875rem; color: var(--crm-text-3); margin: 0.125rem 0 0; }

/* ── Grid Layouts ── */
.dash-grid-2 { display: flex; gap: 1.25rem; }
.dash-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }

@media (max-width: 1200px) {
    .dash-stats-row { grid-template-columns: repeat(3, 1fr); }
    .dash-stat:nth-child(3) { border-right: none; }
    .dash-grid-3 { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 900px) {
    .dash-stats-row { grid-template-columns: repeat(2, 1fr); }
    .dash-grid-2 { flex-direction: column; }
    .dash-grid-2 .dash-card { max-width: 100% !important; }
    .dash-grid-3 { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .dash-stats-row { grid-template-columns: 1fr; }
    .dash-stat { border-right: none !important; border-bottom: 1px solid var(--crm-border); }
    .dash-stat:last-child { border-bottom: none; }
}

/* ── Quick Capture Panel ── */
.qc-panel {
    background: #fff;
    border: 1.5px solid var(--crm-accent, #635bff);
    border-radius: 14px;
    box-shadow: 0 4px 24px rgba(99,91,255,0.12), 0 1px 4px rgba(13,27,46,0.06);
    overflow: hidden;
}
.qc-panel-inner { padding: 1.25rem 1.5rem; }
.qc-panel-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    margin-bottom: 1rem;
}
.qc-panel-title { font-size: 1rem; font-weight: 700; color: var(--crm-text-1); margin: 0; }
.qc-panel-sub { font-size: 0.8125rem; color: var(--crm-text-3); margin: 0.125rem 0 0; }

.qc-tabs {
    display: flex; gap: 0.25rem;
    background: var(--crm-bg, #f4f6f9);
    border-radius: 8px; padding: 0.25rem;
    margin-bottom: 1.25rem; width: fit-content;
}
.qc-tab {
    display: flex; align-items: center; gap: 0.375rem;
    padding: 0.4375rem 0.875rem;
    border-radius: 6px; border: none;
    background: transparent; color: var(--crm-text-3);
    font-size: 0.8125rem; font-weight: 500; cursor: pointer;
    transition: all 0.15s ease;
}
.qc-tab:hover { color: var(--crm-text-2); background: rgba(255,255,255,0.7); }
.qc-tab-active {
    background: #fff; color: var(--crm-text-1);
    box-shadow: 0 1px 3px rgba(13,27,46,0.1);
}

.qc-pane { animation: qcFadeIn 150ms ease; }

.qc-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
}
@media (max-width: 700px) { .qc-grid-3 { grid-template-columns: 1fr; } }

.qc-pill-label {
    font-size: 0.6875rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.06em;
    color: var(--crm-text-3); margin-bottom: 0.375rem;
}
.qc-pills { display: flex; flex-wrap: wrap; gap: 0.375rem; }
.qc-pill {
    padding: 0.25rem 0.75rem; border-radius: 999px;
    border: 1.5px solid var(--crm-border, #e4e9f0);
    background: #fff; color: var(--crm-text-2);
    font-size: 0.8125rem; font-weight: 500;
    cursor: pointer; transition: all 0.15s ease;
}
.qc-pill:hover { border-color: var(--crm-accent, #635bff); color: var(--crm-accent, #635bff); }
.qc-pill-on {
    background: var(--crm-accent, #635bff);
    border-color: var(--crm-accent, #635bff);
    color: #fff;
}
.qc-chip {
    display: inline-flex; align-items: center;
    padding: 0.25rem 0.75rem; border-radius: 999px;
    border: 1.5px solid var(--crm-border, #e4e9f0);
    background: #fff; color: var(--crm-text-2);
    font-size: 0.8125rem; font-weight: 500;
    cursor: pointer; transition: all 0.15s ease; user-select: none;
}
.qc-chip:hover { border-color: var(--crm-accent, #635bff); color: var(--crm-accent, #635bff); }
.qc-chip-on, .qc-chip:has(input:checked) {
    background: #f0f0ff; border-color: var(--crm-accent, #635bff);
    color: var(--crm-accent, #635bff);
}

@keyframes qcSlideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes qcSlideUp {
    from { opacity: 1; transform: translateY(0); }
    to   { opacity: 0; transform: translateY(-8px); }
}
@keyframes qcFadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    var wrap    = document.getElementById('crmMoreActionsWrap');
    var menu    = document.getElementById('crmMoreActionsMenu');
    var chevron = document.getElementById('crmMoreActionsChevron');
    var isOpen  = false;

    function open()  { isOpen = true;  menu.style.display = 'block'; chevron.style.transform = 'rotate(180deg)'; }
    function close() { isOpen = false; menu.style.display = 'none';  chevron.style.transform = 'rotate(0deg)'; }

    window.crmMoreActions = { toggle: function () { isOpen ? close() : open(); } };

    document.addEventListener('click', function (e) {
        if (isOpen && !wrap.contains(e.target)) close();
    });
})();

window.crmQC = (function () {
    var panel   = document.getElementById('qcPanel');
    var btnOpen = document.getElementById('qcToggleBtn');
    var visible = false;

    function open() {
        panel.style.display = 'block';
        panel.style.animation = 'qcSlideDown 200ms ease';
        visible = true;
        var first = panel.querySelector('input[type="text"],input[type="email"]');
        if (first) setTimeout(function(){ first.focus(); }, 220);
    }
    function close() {
        panel.style.animation = 'qcSlideUp 180ms ease';
        setTimeout(function(){ panel.style.display = 'none'; }, 170);
        visible = false;
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && visible) close();
    });

    // Chip toggle
    document.querySelectorAll('.qc-chip input[type="checkbox"]').forEach(function(cb) {
        cb.addEventListener('change', function() {
            this.closest('.qc-chip').classList.toggle('qc-chip-on', this.checked);
        });
    });

    return {
        toggle: function() { visible ? close() : open(); },
        close: close,
        switchTab: function(tab, btn) {
            document.querySelectorAll('#qcPanel .qc-tab').forEach(function(t){ t.classList.remove('qc-tab-active'); });
            btn.classList.add('qc-tab-active');
            document.getElementById('qcPaneLead').style.display    = tab === 'lead'    ? 'block' : 'none';
            document.getElementById('qcPaneRequest').style.display  = tab === 'request' ? 'block' : 'none';
            var first = document.getElementById(tab === 'lead' ? 'qcPaneLead' : 'qcPaneRequest').querySelector('input[type="text"],select');
            if (first) first.focus();
        },
        pill: function(btn, groupId, inputName) {
            var group = document.getElementById(groupId);
            var isOn  = btn.classList.contains('qc-pill-on');
            group.querySelectorAll('.qc-pill').forEach(function(p){ p.classList.remove('qc-pill-on'); });
            if (!isOn) {
                btn.classList.add('qc-pill-on');
                group.querySelector('input[name="' + inputName + '"]').value = btn.dataset.val;
            } else {
                group.querySelector('input[name="' + inputName + '"]').value = '';
            }
        }
    };
})();
</script>
@endpush

</x-crm::layout>

