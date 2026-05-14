<x-crm::layout title="Recurring Invoices">
<div class="crm-page-header">
    <div><h1 class="crm-page-title">Recurring Invoices</h1><p class="crm-page-subtitle">Auto-generate invoices on a schedule</p></div>
    <a href="{{ route('crm.recurring.create') }}" class="crm-btn crm-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Recurring
    </a>
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="crm-stat"><span class="crm-stat-label">Active</span><span class="crm-stat-value" style="color:var(--color-success-text);">{{ $stats['active'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Paused</span><span class="crm-stat-value">{{ $stats['paused'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Monthly Revenue</span><span class="crm-stat-value" style="font-size:1.2rem;">R {{ number_format($stats['monthly'], 2) }}</span></div>
</div>

<div class="crm-table-wrap">
    <div class="crm-table-toolbar">
        <form method="GET" style="display:contents;">
            <select name="status" class="crm-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(['Active','Paused','Cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
            </select>
        </form>
        <span style="margin-left:auto;font-size:0.8125rem;color:var(--color-ink-3);">{{ $recurring->total() }} records</span>
    </div>
    <table class="crm-table">
        <thead><tr><th>Client</th><th>Frequency</th><th>Amount</th><th>Status</th><th>Next Invoice</th><th></th></tr></thead>
        <tbody>
        @forelse($recurring as $r)
        <tr onclick="window.location='{{ route('crm.recurring.show', $r) }}'">
            <td style="font-weight:500;">{{ $r->client->full_name ?? '—' }}</td>
            <td>{{ $r->frequency }}</td>
            <td style="font-weight:600;">R {{ number_format($r->total_amount, 2) }}</td>
            <td>
                @php $rcMap = ['Active'=>'crm-badge-success','Paused'=>'crm-badge-warning','Cancelled'=>'crm-badge-neutral']; @endphp
                <span class="crm-badge {{ $rcMap[$r->status] ?? 'crm-badge-neutral' }}"><span class="crm-badge-dot"></span>{{ $r->status }}</span>
            </td>
            <td style="color:var(--color-ink-3);">{{ $r->next_invoice_date ? \Carbon\Carbon::parse($r->next_invoice_date)->format('d M Y') : '—' }}</td>
            <td x-data="{ open: false }">
                <a href="{{ route('crm.recurring.edit', $r) }}" class="crm-btn crm-btn-ghost crm-btn-sm" onclick="event.stopPropagation()">Edit</a>
                <button type="button" @click.stop="open = true" class="crm-btn crm-btn-ghost crm-btn-sm" style="color:var(--color-danger-text);">Delete</button>
                <div x-show="open" x-cloak class="crm-modal-overlay" @click.self="open=false">
                    <div class="crm-modal" @click.stop>
                        <div class="crm-modal-header">
                            <h3 class="crm-modal-title">Delete Recurring Invoice</h3>
                            <button type="button" @click="open=false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        <div class="crm-modal-body">
                            <div class="crm-modal-icon crm-modal-icon--danger">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                            <p>Are you sure you want to delete <strong>{{ $r->recurring_invoice_id }}</strong>? This action cannot be undone.</p>
                        </div>
                        <div class="crm-modal-footer">
                            <button type="button" @click="open=false" class="crm-btn crm-btn-secondary">Cancel</button>
                            <form method="POST" action="{{ route('crm.recurring.destroy', $r) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="crm-btn crm-btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="crm-empty"><p class="crm-empty-title">No recurring invoices</p><a href="{{ route('crm.recurring.create') }}" class="crm-btn crm-btn-primary" style="margin-top:1rem;">Create One</a></div></td></tr>
        @endforelse
        </tbody>
    </table>
    @if($recurring->hasPages())<div style="padding:1rem 1.25rem;border-top:1px solid var(--color-border);">{{ $recurring->links() }}</div>@endif
</div>
</x-crm::layout>

