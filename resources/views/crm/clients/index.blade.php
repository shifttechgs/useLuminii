<x-crm::layout title="Clients">

{{-- Header --}}
<div class="crm-page-header">
    <div>
        <h1 class="crm-page-title">Clients</h1>
        <p class="crm-page-subtitle">Manage your clients and leads</p>
    </div>
    <a href="{{ route('crm.clients.create') }}" class="crm-btn crm-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Client
    </a>
</div>

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="crm-stat"><span class="crm-stat-label">Total</span><span class="crm-stat-value">{{ $stats['total'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Clients</span><span class="crm-stat-value">{{ $stats['clients'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Leads</span><span class="crm-stat-value">{{ $stats['leads'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Inactive</span><span class="crm-stat-value">{{ $stats['inactive'] }}</span></div>
</div>

{{-- Table --}}
<div class="crm-table-wrap">
    <div class="crm-table-toolbar">
        <form method="GET" action="{{ route('crm.clients.index') }}" style="display:contents;">
            <div class="crm-search">
                <svg class="crm-search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search clients…" style="border-radius:var(--radius-sm);">
            </div>
            <select name="type" class="crm-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="Lead" {{ request('type')=='Lead'?'selected':'' }}>Leads</option>
                <option value="Client" {{ request('type')=='Client'?'selected':'' }}>Clients</option>
                <option value="Inactive" {{ request('type')=='Inactive'?'selected':'' }}>Inactive</option>
            </select>
            <button type="submit" class="crm-btn crm-btn-secondary crm-btn-sm">Search</button>
            @if(request('q') || request('type'))
                <a href="{{ route('crm.clients.index') }}" class="crm-btn crm-btn-ghost crm-btn-sm">Clear</a>
            @endif
        </form>
        <span style="margin-left:auto;font-size:0.8125rem;color:var(--color-ink-3);">{{ $clients->total() }} records</span>
    </div>

    <table class="crm-table">
        <thead><tr>
            <th>Client</th><th>Company</th><th>Email</th><th>Phone</th><th>Type</th><th>Assigned To</th><th></th>
        </tr></thead>
        <tbody>
        @forelse($clients as $client)
        <tr onclick="window.location='{{ route('crm.clients.show', $client) }}'">
            <td>
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    <div class="crm-avatar" style="width:2rem;height:2rem;font-size:0.6875rem;background:var(--color-bg);color:var(--color-ink-2);border:1px solid var(--color-border);">
                        {{ strtoupper(substr($client->firstname, 0, 1) . substr($client->lastname, 0, 1)) }}
                    </div>
                    <div>
                        <p style="font-weight:500;">{{ $client->full_name }}</p>
                        <p style="font-size:0.75rem;color:var(--color-ink-3);">{{ $client->client_id }}</p>
                    </div>
                </div>
            </td>
            <td>{{ $client->company ?: '—' }}</td>
            <td style="color:var(--color-ink-2);">{{ $client->email ?: '—' }}</td>
            <td style="color:var(--color-ink-2);">{{ $client->phone_number ?: '—' }}</td>
            <td>
                @php $typeMap = ['Client'=>'crm-badge-success','Lead'=>'crm-badge-info','Inactive'=>'crm-badge-neutral']; @endphp
                <span class="crm-badge {{ $typeMap[$client->client_type] ?? 'crm-badge-neutral' }}">{{ $client->client_type }}</span>
            </td>
            <td style="font-size:0.875rem;color:var(--color-ink-2);">{{ $client->assignedRep->name ?? '—' }}</td>
            <td>
                <a href="{{ route('crm.clients.edit', $client) }}" class="crm-btn crm-btn-ghost crm-btn-sm" onclick="event.stopPropagation()">Edit</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="7">
            <div class="crm-empty">
                <div class="crm-empty-icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1.5rem;height:1.5rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                <p class="crm-empty-title">No clients found</p>
                <p class="crm-empty-text">Add your first client to get started</p>
                <a href="{{ route('crm.clients.create') }}" class="crm-btn crm-btn-primary" style="margin-top:1rem;">New Client</a>
            </div>
        </td></tr>
        @endforelse
        </tbody>
    </table>

    @if($clients->hasPages())
    <div style="padding:1rem 1.25rem;border-top:1px solid var(--color-border);">
        {{ $clients->links() }}
    </div>
    @endif
</div>

</x-crm::layout>

