<x-crm::layout title="Reports">
<div class="crm-page-header">
    <div><h1 class="crm-page-title">Reports</h1><p class="crm-page-subtitle">Financial overview and business analytics</p></div>
    <form method="GET" style="display:flex;gap:0.5rem;align-items:center;">
        <select name="period" class="crm-select" onchange="this.form.submit()">
            <option value="3months" {{ $period=='3months'?'selected':'' }}>Last 3 Months</option>
            <option value="6months" {{ $period=='6months'?'selected':'' }}>Last 6 Months</option>
            <option value="12months" {{ $period=='12months'?'selected':'' }}>Last 12 Months</option>
        </select>
    </form>
</div>

{{-- Summary Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="crm-stat"><span class="crm-stat-label">Total Revenue</span><span class="crm-stat-value" style="color:var(--color-success-text);font-size:1.2rem;">R {{ number_format($summary['revenue_total'], 2) }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Total Expenses</span><span class="crm-stat-value" style="color:var(--color-danger-text);font-size:1.2rem;">R {{ number_format($summary['expenses_total'], 2) }}</span></div>
    <div class="crm-stat" style="{{ $summary['profit'] >= 0 ? '' : 'border-color:#fecdca;' }}"><span class="crm-stat-label">Net Profit</span><span class="crm-stat-value" style="{{ $summary['profit'] >= 0 ? 'color:var(--color-success-text);' : 'color:var(--color-danger-text);' }}font-size:1.2rem;">R {{ number_format($summary['profit'], 2) }}</span></div>
    <div class="crm-stat" style="{{ $summary['overdue_total']>0?'border-color:#fecdca;':'' }}"><span class="crm-stat-label">Overdue</span><span class="crm-stat-value" style="{{ $summary['overdue_total']>0?'color:var(--color-danger-text);':'' }}font-size:1.2rem;">R {{ number_format($summary['overdue_total'], 2) }}</span></div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
    {{-- Revenue Chart --}}
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Revenue vs Expenses</span></div>
        <div class="crm-card-body"><canvas id="revenueChart" height="180"></canvas></div>
    </div>
    {{-- Invoice Breakdown --}}
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Invoice Status</span></div>
        <div class="crm-card-body">
            <canvas id="invoiceChart" height="180"></canvas>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
    {{-- Quote stats --}}
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Quote Conversion</span></div>
        <div class="crm-card-body">
            <div class="crm-detail-row"><span class="crm-detail-label">Total Quotes</span><span class="crm-detail-value">{{ $quoteStats['total'] }}</span></div>
            <div class="crm-detail-row"><span class="crm-detail-label">Accepted</span><span class="crm-detail-value" style="color:var(--color-success-text);">{{ $quoteStats['accepted'] }}</span></div>
            <div class="crm-detail-row"><span class="crm-detail-label">Declined</span><span class="crm-detail-value" style="color:var(--color-danger-text);">{{ $quoteStats['declined'] }}</span></div>
            <div class="crm-detail-row"><span class="crm-detail-label">Pending</span><span class="crm-detail-value" style="color:var(--color-warning-text);">{{ $quoteStats['pending'] }}</span></div>
            @if($quoteStats['total'] > 0)
            <div class="crm-detail-row">
                <span class="crm-detail-label">Conversion Rate</span>
                <span class="crm-detail-value" style="color:var(--color-success-text);">{{ round($quoteStats['accepted']/$quoteStats['total']*100) }}%</span>
            </div>
            @endif
        </div>
    </div>
    {{-- Job stats --}}
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Job Summary</span></div>
        <div class="crm-card-body">
            <div class="crm-detail-row"><span class="crm-detail-label">Total Jobs</span><span class="crm-detail-value">{{ $jobStats['total'] }}</span></div>
            <div class="crm-detail-row"><span class="crm-detail-label">Completed</span><span class="crm-detail-value" style="color:var(--color-success-text);">{{ $jobStats['completed'] }}</span></div>
            <div class="crm-detail-row"><span class="crm-detail-label">Active</span><span class="crm-detail-value" style="color:var(--color-info-text);">{{ $jobStats['active'] }}</span></div>
            @if($jobStats['total'] > 0)
            <div class="crm-detail-row"><span class="crm-detail-label">Completion Rate</span><span class="crm-detail-value">{{ round($jobStats['completed']/$jobStats['total']*100) }}%</span></div>
            @endif
        </div>
    </div>
</div>

{{-- Top Clients --}}
<div class="crm-card" style="margin-bottom:1.25rem;">
    <div class="crm-card-header"><span class="crm-card-title">Top Clients by Revenue</span></div>
    <table class="crm-table">
        <thead><tr><th>#</th><th>Client</th><th>Company</th><th>Revenue Paid</th></tr></thead>
        <tbody>
        @forelse($topClients as $i => $c)
        <tr onclick="window.location='{{ route('crm.clients.show', $c) }}'">
            <td style="color:var(--color-ink-3);">{{ $i+1 }}</td>
            <td style="font-weight:500;">{{ $c->full_name }}</td>
            <td style="color:var(--color-ink-2);">{{ $c->company ?? '—' }}</td>
            <td style="font-weight:700;color:var(--color-success-text);">R {{ number_format($c->paid_total ?? 0, 2) }}</td>
        </tr>
        @empty
        <tr><td colspan="4"><div class="crm-empty" style="padding:1rem;"><p class="crm-empty-text">No data yet</p></div></td></tr>
        @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
const labels = @json(collect($months)->pluck('label'));
const revenues = @json(collect($months)->pluck('revenue'));
const expenses = @json(collect($months)->pluck('expenses'));

new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels,
        datasets: [
            { label:'Revenue', data: revenues, backgroundColor:'rgba(18,183,106,0.7)', borderRadius:4 },
            { label:'Expenses', data: expenses, backgroundColor:'rgba(240,68,56,0.7)', borderRadius:4 }
        ]
    },
    options: { responsive:true, plugins:{ legend:{ labels:{ font:{family:'Inter',size:12}, color:'#5a6a7e', boxWidth:12 }}}, scales:{ x:{grid:{display:false}}, y:{grid:{color:'#e4e9f0'}, ticks:{ callback:v=>'R'+v }}}}
});

const ivData = @json($invoiceBreakdown);
new Chart(document.getElementById('invoiceChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(ivData),
        datasets:[{ data: Object.values(ivData), backgroundColor:['#e4e9f0','#bae0fd','#fedf89','#a7f3d0','#fecdca','#e4e9f0'], borderWidth:0 }]
    },
    options:{ responsive:true, plugins:{ legend:{ position:'right', labels:{ font:{family:'Inter',size:11}, color:'#5a6a7e', boxWidth:12 }}}}
});
</script>
@endpush
</x-crm::layout>

