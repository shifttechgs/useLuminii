<x-crm::layout title="Quotes">

<div class="crm-page-header">
    <div><h1 class="crm-page-title">Quotes</h1><p class="crm-page-subtitle">Create and send quotes to clients</p></div>
    <a href="{{ route('crm.quotes.create') }}" class="crm-btn crm-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Quote
    </a>
</div>

<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="crm-stat"><span class="crm-stat-label">Total</span><span class="crm-stat-value">{{ $stats['total'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Draft</span><span class="crm-stat-value">{{ $stats['draft'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Sent</span><span class="crm-stat-value">{{ $stats['sent'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Accepted</span><span class="crm-stat-value">{{ $stats['accepted'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Pipeline</span><span class="crm-stat-value" style="font-size:1.1rem;">R {{ number_format($stats['pipeline'], 0) }}</span></div>
</div>

<div class="crm-table-wrap">
    <div class="crm-table-toolbar">
        <form method="GET" action="{{ route('crm.quotes.index') }}" style="display:contents;">
            <div class="crm-search">
                <svg class="crm-search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search quotes…">
            </div>
            <select name="status" class="crm-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(['Draft','Sent','Accepted','Declined','Expired'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
            </select>
            <button type="submit" class="crm-btn crm-btn-secondary crm-btn-sm">Search</button>
            @if(request('q') || request('status'))<a href="{{ route('crm.quotes.index') }}" class="crm-btn crm-btn-ghost crm-btn-sm">Clear</a>@endif
        </form>
        <span style="margin-left:auto;font-size:0.8125rem;color:var(--color-ink-3);">{{ $quotes->total() }} records</span>
    </div>
    <table class="crm-table">
        <thead><tr><th>Quote ID</th><th>Client</th><th>Title</th><th>Amount</th><th>Status</th><th>Date</th><th></th></tr></thead>
        <tbody>
        @forelse($quotes as $q)
        <tr onclick="window.location='{{ route('crm.quotes.show', $q) }}'">
            <td class="crm-mono">{{ $q->quote_id }}</td>
            <td>{{ $q->client->full_name ?? '—' }}</td>
            <td>{{ $q->job_title }}</td>
            <td style="font-weight:600;">R {{ number_format($q->grand_total, 2) }}</td>
            <td>@include('crm.partials.quote-badge', ['status' => $q->status])</td>
            <td style="color:var(--color-ink-3);">{{ $q->quote_date ? $q->quote_date->format('d M Y') : '—' }}</td>
            <td>
                <a href="{{ route('crm.quotes.edit', $q) }}" class="crm-btn crm-btn-ghost crm-btn-sm" onclick="event.stopPropagation()">Edit</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="crm-empty"><div class="crm-empty-icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1.5rem;height:1.5rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><p class="crm-empty-title">No quotes found</p><a href="{{ route('crm.quotes.create') }}" class="crm-btn crm-btn-primary" style="margin-top:1rem;">New Quote</a></div></td></tr>
        @endforelse
        </tbody>
    </table>
    @if($quotes->hasPages())<div style="padding:1rem 1.25rem;border-top:1px solid var(--color-border);">{{ $quotes->links() }}</div>@endif
</div>

</x-crm::layout>

