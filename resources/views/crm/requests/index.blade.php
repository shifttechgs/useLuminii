<x-crm::layout title="Client Requests">
<div class="crm-page-header">
    <div><h1 class="crm-page-title">Client Requests</h1><p class="crm-page-subtitle">Service requests and enquiries</p></div>
    <div style="display:flex;gap:0.5rem;">
        <a href="{{ route('crm.pipeline') }}" class="crm-btn crm-btn-secondary">Pipeline View</a>
        <a href="{{ route('crm.requests.create') }}" class="crm-btn crm-btn-primary">New Request</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="crm-stat"><span class="crm-stat-label">Total</span><span class="crm-stat-value">{{ $stats['total'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">New</span><span class="crm-stat-value" style="color:var(--color-info-text);">{{ $stats['new'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">In Review</span><span class="crm-stat-value">{{ $stats['in_review'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Quoted</span><span class="crm-stat-value" style="color:var(--color-success-text);">{{ $stats['quoted'] }}</span></div>
</div>

<div class="crm-table-wrap">
    <div class="crm-table-toolbar">
        <form method="GET" action="{{ route('crm.requests.index') }}" style="display:contents;">
            <div class="crm-search">
                <svg class="crm-search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search requests…">
            </div>
            <select name="status" class="crm-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(['New','InReview','Quoted','Approved','Closed'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
            </select>
            <button type="submit" class="crm-btn crm-btn-secondary crm-btn-sm">Search</button>
            @if(request('q')||request('status'))<a href="{{ route('crm.requests.index') }}" class="crm-btn crm-btn-ghost crm-btn-sm">Clear</a>@endif
        </form>
    </div>
    <table class="crm-table">
        <thead><tr><th>Title</th><th>Client</th><th>Priority</th><th>Status</th><th>Date</th><th></th></tr></thead>
        <tbody>
        @forelse($requests as $req)
        @php $prioMap = ['Low'=>'crm-badge-neutral','Medium'=>'crm-badge-info','High'=>'crm-badge-warning','Urgent'=>'crm-badge-danger']; @endphp
        <tr onclick="window.location='{{ route('crm.requests.show', $req) }}'">
            <td style="font-weight:500;">{{ $req->title }}</td>
            <td>{{ $req->client->full_name ?? '—' }}</td>
            <td>@if($req->priority)<span class="crm-badge {{ $prioMap[$req->priority] ?? 'crm-badge-neutral' }}">{{ $req->priority }}</span>@else —@endif</td>
            <td><span class="crm-badge crm-badge-info">{{ $req->status }}</span></td>
            <td style="color:var(--color-ink-3);">{{ $req->created_at->format('d M Y') }}</td>
            <td>
                <form method="POST" action="{{ route('crm.requests.convert', $req) }}" style="display:inline;" onsubmit="event.stopPropagation()">
                    @csrf<button type="submit" class="crm-btn crm-btn-ghost crm-btn-sm" onclick="event.stopPropagation()">→ Quote</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="crm-empty"><p class="crm-empty-title">No requests found</p></div></td></tr>
        @endforelse
        </tbody>
    </table>
    @if($requests->hasPages())<div style="padding:1rem 1.25rem;border-top:1px solid var(--color-border);">{{ $requests->links() }}</div>@endif
</div>
</x-crm::layout>

