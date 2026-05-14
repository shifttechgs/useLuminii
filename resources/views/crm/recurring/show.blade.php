<x-crm::layout title="Recurring Invoice">
<div class="crm-page-header">
    <div>
        <a href="{{ route('crm.recurring.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Recurring</a> / <span style="font-size:0.875rem;">{{ $recurringInvoice->recurring_invoice_id }}</span>
        <div style="display:flex;align-items:center;gap:0.75rem;margin-top:0.25rem;">
            <h1 class="crm-page-title">{{ $recurringInvoice->client->full_name ?? '—' }}</h1>
            @php $rcMap = ['Active'=>'crm-badge-success','Paused'=>'crm-badge-warning','Cancelled'=>'crm-badge-neutral']; @endphp
            <span class="crm-badge {{ $rcMap[$recurringInvoice->status] ?? 'crm-badge-neutral' }}">{{ $recurringInvoice->status }}</span>
        </div>
    </div>
    <div style="display:flex;gap:0.5rem;" x-data="{ deleteOpen: false }">
        <a href="{{ route('crm.recurring.edit', $recurringInvoice) }}" class="crm-btn crm-btn-primary">Edit</a>
        <button type="button" @click="deleteOpen = true" class="crm-btn crm-btn-secondary">Delete</button>
        <div x-show="deleteOpen" x-cloak class="crm-modal-overlay" @click.self="deleteOpen = false">
            <div class="crm-modal" @click.stop>
                <div class="crm-modal-header">
                    <h3 class="crm-modal-title">Delete Recurring Invoice</h3>
                    <button type="button" @click="deleteOpen = false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="crm-modal-body">
                    <div class="crm-modal-icon crm-modal-icon--danger">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <p>Are you sure you want to delete <strong>{{ $recurringInvoice->recurring_invoice_id }}</strong>? This action cannot be undone.</p>
                </div>
                <div class="crm-modal-footer">
                    <button type="button" @click="deleteOpen = false" class="crm-btn crm-btn-secondary">Cancel</button>
                    <form method="POST" action="{{ route('crm.recurring.destroy', $recurringInvoice) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="crm-btn crm-btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display:grid;grid-template-columns:1fr 280px;gap:1.25rem;">
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Line Items</span></div>
        <table class="crm-table">
            <thead><tr><th>Description</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead>
            <tbody>
            @forelse($recurringInvoice->items as $item)
            <tr><td>{{ $item->description }}</td><td>{{ $item->quantity }}</td><td>R {{ number_format($item->unit_price, 2) }}</td><td style="font-weight:600;">R {{ number_format($item->total, 2) }}</td></tr>
            @empty
            <tr><td colspan="4"><div class="crm-empty" style="padding:1rem;"><p class="crm-empty-text">No items</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="crm-card-footer">
            <div style="margin-left:auto;min-width:200px;">
                <div class="crm-detail-row" style="font-size:1rem;font-weight:700;">
                    <span class="crm-detail-label" style="font-weight:700;color:var(--color-ink-1);">Total per Invoice</span>
                    <span class="crm-detail-value">R {{ number_format($recurringInvoice->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Schedule</span></div>
        <div class="crm-card-body">
            <div class="crm-detail-row"><span class="crm-detail-label">ID</span><span class="crm-detail-value crm-mono">{{ $recurringInvoice->recurring_invoice_id }}</span></div>
            <div class="crm-detail-row"><span class="crm-detail-label">Frequency</span><span class="crm-detail-value">{{ $recurringInvoice->frequency }}</span></div>
            <div class="crm-detail-row"><span class="crm-detail-label">Start Date</span><span class="crm-detail-value">{{ $recurringInvoice->start_date?->format('d M Y') ?? '—' }}</span></div>
            <div class="crm-detail-row"><span class="crm-detail-label">End Date</span><span class="crm-detail-value">{{ $recurringInvoice->end_date?->format('d M Y') ?? 'No end' }}</span></div>
            <div class="crm-detail-row"><span class="crm-detail-label">Next Invoice</span><span class="crm-detail-value" style="color:var(--color-info-text);font-weight:600;">{{ $recurringInvoice->next_invoice_date ? \Carbon\Carbon::parse($recurringInvoice->next_invoice_date)->format('d M Y') : '—' }}</span></div>
        </div>
    </div>
</div>
</x-crm::layout>

