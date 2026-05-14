<x-crm::layout title="{{ $client->full_name }}">

<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.clients.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Clients</a>
            <span style="color:var(--color-ink-3);">/</span>
            <span style="font-size:0.875rem;color:var(--color-ink-2);">{{ $client->full_name }}</span>
        </div>
        <h1 class="crm-page-title">{{ $client->full_name }}</h1>
        @php $typeMap = ['Client'=>'crm-badge-success','Lead'=>'crm-badge-info','Inactive'=>'crm-badge-neutral']; @endphp
        <span class="crm-badge {{ $typeMap[$client->client_type] ?? 'crm-badge-neutral' }}" style="margin-top:0.375rem;">{{ $client->client_type }}</span>
    </div>
    <div style="display:flex;gap:0.5rem;">
        <a href="{{ route('crm.clients.edit', $client) }}" class="crm-btn crm-btn-secondary">Edit Client</a>
        <a href="{{ route('crm.quotes.create', ['client_id' => $client->client_id]) }}" class="crm-btn crm-btn-primary">New Quote</a>
    </div>
</div>

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="crm-stat"><span class="crm-stat-label">Total Invoiced</span><span class="crm-stat-value" style="font-size:1.3rem;">R {{ number_format($stats['total_invoiced'], 2) }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Total Paid</span><span class="crm-stat-value" style="font-size:1.3rem;color:var(--color-success-text);">R {{ number_format($stats['total_paid'], 2) }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Open Quotes</span><span class="crm-stat-value">{{ $stats['open_quotes'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Active Jobs</span><span class="crm-stat-value">{{ $stats['active_jobs'] }}</span></div>
</div>

<div style="display:grid;grid-template-columns:320px 1fr;gap:1.25rem;">

    {{-- Left: Profile --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Contact Info</span></div>
            <div class="crm-card-body">
                <div class="crm-detail-row"><span class="crm-detail-label">ID</span><span class="crm-detail-value crm-mono">{{ $client->client_id }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Email</span><span class="crm-detail-value">{{ $client->email ?: '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Phone</span><span class="crm-detail-value">{{ $client->phone_number ?: '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Company</span><span class="crm-detail-value">{{ $client->company ?: '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Source</span><span class="crm-detail-value">{{ $client->lead_source ?: '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Rep</span><span class="crm-detail-value">{{ $client->assignedRep->name ?? '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Address</span>
                    <span class="crm-detail-value" style="text-align:right;">
                        {{ implode(', ', array_filter([$client->street, $client->city, $client->province, $client->postal_code])) ?: '—' }}
                    </span>
                </div>
            </div>
        </div>

        @if($client->notes)
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Notes</span></div>
            <div class="crm-card-body"><p style="font-size:0.875rem;color:var(--color-ink-2);line-height:1.6;">{{ $client->notes }}</p></div>
        </div>
        @endif

        {{-- Danger zone --}}
        <div class="crm-card" style="border-color:var(--color-border);" x-data="{ deleteOpen: false }">
            <div class="crm-card-header"><span class="crm-card-title" style="color:var(--color-danger-text);">Danger Zone</span></div>
            <div class="crm-card-body">
                <button type="button" @click="deleteOpen = true" class="crm-btn crm-btn-danger" style="width:100%;">Delete Client</button>
            </div>
            <div x-show="deleteOpen" x-cloak class="crm-modal-overlay" @click.self="deleteOpen = false">
                <div class="crm-modal" @click.stop>
                    <div class="crm-modal-header">
                        <h3 class="crm-modal-title">Delete Client</h3>
                        <button type="button" @click="deleteOpen = false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <div class="crm-modal-body">
                        <div class="crm-modal-icon crm-modal-icon--danger">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </div>
                        <p>Are you sure you want to delete <strong>{{ $client->full_name }}</strong>? This action cannot be undone.</p>
                    </div>
                    <div class="crm-modal-footer">
                        <button type="button" @click="deleteOpen = false" class="crm-btn crm-btn-secondary">Cancel</button>
                        <form method="POST" action="{{ route('crm.clients.destroy', $client) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="crm-btn crm-btn-danger">Delete Client</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Activity --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Quotes --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title">Quotes ({{ $client->quotes->count() }})</span>
                <a href="{{ route('crm.quotes.create', ['client_id' => $client->client_id]) }}" class="crm-btn crm-btn-secondary crm-btn-sm">New Quote</a>
            </div>
            <table class="crm-table">
                <thead><tr><th>Quote</th><th>Title</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                @forelse($client->quotes->sortByDesc('created_at')->take(5) as $q)
                <tr onclick="window.location='{{ route('crm.quotes.show', $q) }}'">
                    <td class="crm-mono">{{ $q->quote_id }}</td>
                    <td>{{ $q->job_title }}</td>
                    <td>R {{ number_format($q->grand_total, 2) }}</td>
                    <td>@include('crm.partials.quote-badge', ['status' => $q->status])</td>
                    <td style="color:var(--color-ink-3);">{{ $q->quote_date->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="crm-empty" style="padding:1rem;"><p class="crm-empty-text">No quotes yet</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Jobs --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title">Jobs ({{ $client->jobs->count() }})</span>
                <a href="{{ route('crm.jobs.create', ['client_id' => $client->client_id]) }}" class="crm-btn crm-btn-secondary crm-btn-sm">New Job</a>
            </div>
            <table class="crm-table">
                <thead><tr><th>Job</th><th>Title</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                @forelse($client->jobs->sortByDesc('created_at')->take(5) as $j)
                <tr onclick="window.location='{{ route('crm.jobs.show', $j) }}'">
                    <td class="crm-mono">{{ $j->job_id }}</td>
                    <td>{{ $j->job_title }}</td>
                    <td>@include('crm.partials.job-badge', ['status' => $j->job_status])</td>
                    <td style="color:var(--color-ink-3);">{{ $j->job_date_time ? $j->job_date_time->format('d M Y') : '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="crm-empty" style="padding:1rem;"><p class="crm-empty-text">No jobs yet</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Invoices --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title">Invoices ({{ $client->invoices->count() }})</span>
                <a href="{{ route('crm.invoices.create', ['client_id' => $client->client_id]) }}" class="crm-btn crm-btn-secondary crm-btn-sm">New Invoice</a>
            </div>
            <table class="crm-table">
                <thead><tr><th>Invoice</th><th>Amount</th><th>Balance</th><th>Status</th><th>Due</th></tr></thead>
                <tbody>
                @forelse($client->invoices->sortByDesc('created_at')->take(5) as $inv)
                <tr onclick="window.location='{{ route('crm.invoices.show', $inv) }}'">
                    <td class="crm-mono">{{ $inv->invoice_id }}</td>
                    <td>R {{ number_format($inv->total_amount, 2) }}</td>
                    <td style="font-weight:600;">R {{ number_format($inv->balance, 2) }}</td>
                    <td>@include('crm.partials.invoice-badge', ['status' => $inv->status])</td>
                    <td style="color:var(--color-ink-3);">{{ $inv->due_date ? $inv->due_date->format('d M Y') : '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="crm-empty" style="padding:1rem;"><p class="crm-empty-text">No invoices yet</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

</x-crm::layout>

