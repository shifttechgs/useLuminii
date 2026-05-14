<x-crm::layout title="{{ $invoice->invoice_id }}">
<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.invoices.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Invoices</a>
            <span style="color:var(--color-ink-3);">/</span>
            <span style="font-size:0.875rem;">{{ $invoice->invoice_id }}</span>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <h1 class="crm-page-title">{{ $invoice->invoice_id }}</h1>
            @include('crm.partials.invoice-badge', ['status' => $invoice->status])
        </div>
    </div>
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
        @if(in_array($invoice->status, ['Draft','Sent','PartiallyPaid','Overdue']))
        <form method="POST" action="{{ route('crm.invoices.send', $invoice) }}">@csrf
            <button type="submit" class="crm-btn crm-btn-secondary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Send Email
            </button>
        </form>
        @endif
        <a href="{{ route('invoice.pdf', $invoice->invoice_id) }}" class="crm-btn crm-btn-secondary" target="_blank">Download PDF</a>
        <a href="{{ route('crm.invoices.edit', $invoice) }}" class="crm-btn crm-btn-primary">Edit</a>
    </div>
</div>

{{-- Record Payment Modal --}}
@if(!in_array($invoice->status, ['Paid','Cancelled']))
<div class="crm-card" style="margin-bottom:1.25rem;border-color:var(--color-success);background:var(--color-success-light);" x-data="{open:false}">
    <div class="crm-card-body" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
        <div>
            <p style="font-size:0.875rem;font-weight:600;color:var(--color-success-text);">Balance Due: R {{ number_format($invoice->balance, 2) }}</p>
            <p style="font-size:0.8125rem;color:var(--color-success-text);">Due {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '—' }}</p>
        </div>
        <button type="button" @click="open=true" class="crm-btn crm-btn-primary">Record Payment</button>
    </div>

    <div x-show="open" x-cloak class="crm-modal-overlay" @click.self="open=false">
        <form method="POST" action="{{ route('crm.invoices.payment', $invoice) }}" class="crm-modal" @click.stop>
            @csrf
            <div class="crm-modal-header">
                <h3 class="crm-modal-title">Record Payment</h3>
                <button type="button" @click="open=false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="crm-modal-body" style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <label class="crm-label">Amount (R) <span style="color:var(--color-danger);">*</span></label>
                    <input type="number" name="amount" class="crm-input" step="0.01" min="0.01" value="{{ $invoice->balance }}" required>
                </div>
                <div>
                    <label class="crm-label">Payment Method</label>
                    <select name="method" class="crm-select">
                        @foreach(['EFT','Cash','PayPal','Card','Cheque'] as $m)
                        <option value="{{ $m }}">{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Reference <span class="crm-label-hint">(optional)</span></label>
                    <input type="text" name="reference" class="crm-input" placeholder="Bank ref, receipt #…">
                </div>
            </div>
            <div class="crm-modal-footer">
                <button type="button" @click="open=false" class="crm-btn crm-btn-secondary">Cancel</button>
                <button type="submit" class="crm-btn crm-btn-primary">Save Payment</button>
            </div>
        </form>
    </div>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;">
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Line Items</span></div>
            <table class="crm-table">
                <thead><tr><th>Description</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead>
                <tbody>
                @forelse($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>R {{ number_format($item->unit_price, 2) }}</td>
                    <td style="font-weight:600;">R {{ number_format($item->line_total, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="crm-empty" style="padding:1rem;"><p class="crm-empty-text">No items</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
            <div class="crm-card-footer">
                <div style="margin-left:auto;min-width:220px;">
                    <div class="crm-detail-row"><span class="crm-detail-label">Subtotal</span><span class="crm-detail-value">R {{ number_format($invoice->sub_total, 2) }}</span></div>
                    @if($invoice->discount > 0)<div class="crm-detail-row"><span class="crm-detail-label">Discount</span><span class="crm-detail-value" style="color:var(--color-success-text);">– R {{ number_format($invoice->discount, 2) }}</span></div>@endif
                    <div class="crm-detail-row" style="font-size:1rem;font-weight:700;"><span class="crm-detail-label" style="font-weight:700;color:var(--color-ink-1);">Total</span><span class="crm-detail-value">R {{ number_format($invoice->total_amount, 2) }}</span></div>
                    @if($invoice->deposit_paid > 0)<div class="crm-detail-row"><span class="crm-detail-label">Paid</span><span class="crm-detail-value" style="color:var(--color-success-text);">– R {{ number_format($invoice->deposit_paid, 2) }}</span></div>@endif
                    <div class="crm-detail-row" style="font-size:1rem;font-weight:700;"><span class="crm-detail-label" style="font-weight:700;color:var(--color-ink-1);">Balance</span><span class="crm-detail-value" style="{{ $invoice->balance > 0 ? 'color:var(--color-warning-text);' : 'color:var(--color-success-text);' }}">R {{ number_format($invoice->balance, 2) }}</span></div>
                </div>
            </div>
        </div>
        @if($invoice->client_message)
        <div class="crm-card"><div class="crm-card-header"><span class="crm-card-title">Client Message</span></div><div class="crm-card-body"><p style="font-size:0.875rem;color:var(--color-ink-2);line-height:1.6;">{{ $invoice->client_message }}</p></div></div>
        @endif
        @if($invoice->internal_notes)
        <div class="crm-card"><div class="crm-card-header"><span class="crm-card-title">Internal Notes</span><span class="crm-badge crm-badge-warning">Internal</span></div><div class="crm-card-body"><p style="font-size:0.875rem;color:var(--color-ink-2);line-height:1.6;">{{ $invoice->internal_notes }}</p></div></div>
        @endif
    </div>

    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Details</span></div>
            <div class="crm-card-body">
                <div class="crm-detail-row"><span class="crm-detail-label">Invoice ID</span><span class="crm-detail-value crm-mono">{{ $invoice->invoice_id }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Client</span><span class="crm-detail-value"><a href="{{ route('crm.clients.show', $invoice->client) }}" style="color:var(--color-info-text);">{{ $invoice->client->full_name }}</a></span></div>
                @if($invoice->job)<div class="crm-detail-row"><span class="crm-detail-label">Job</span><span class="crm-detail-value"><a href="{{ route('crm.jobs.show', $invoice->job) }}" style="color:var(--color-info-text);">{{ $invoice->job->job_id }}</a></span></div>@endif
                <div class="crm-detail-row"><span class="crm-detail-label">Invoice Date</span><span class="crm-detail-value">{{ $invoice->invoice_date ? $invoice->invoice_date->format('d M Y') : '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Due Date</span><span class="crm-detail-value">{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '—' }}</span></div>
                @if($invoice->paid_at)<div class="crm-detail-row"><span class="crm-detail-label">Paid At</span><span class="crm-detail-value" style="color:var(--color-success-text);">{{ $invoice->paid_at->format('d M Y') }}</span></div>@endif
                <div class="crm-detail-row"><span class="crm-detail-label">Method</span><span class="crm-detail-value">{{ $invoice->payment_method ?? '—' }}</span></div>
                @if($invoice->payment_reference)<div class="crm-detail-row"><span class="crm-detail-label">Reference</span><span class="crm-detail-value">{{ $invoice->payment_reference }}</span></div>@endif
            </div>
        </div>
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Client Hub</span></div>
            <div class="crm-card-body">
                <p style="font-size:0.8125rem;color:var(--color-ink-3);margin-bottom:0.5rem;">Share with client:</p>
                <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-sm);padding:0.5rem 0.625rem;font-size:0.75rem;font-family:monospace;word-break:break-all;color:var(--color-ink-2);">{{ route('client-hub.invoice', $invoice->view_token) }}</div>
            </div>
        </div>
        <div class="crm-card" x-data="{ deleteOpen: false }">
            <div class="crm-card-body">
                <button type="button" @click="deleteOpen = true" class="crm-btn crm-btn-danger" style="width:100%;">Delete Invoice</button>
            </div>
            <div x-show="deleteOpen" x-cloak class="crm-modal-overlay" @click.self="deleteOpen = false">
                <div class="crm-modal" @click.stop>
                    <div class="crm-modal-header">
                        <h3 class="crm-modal-title">Delete Invoice</h3>
                        <button type="button" @click="deleteOpen = false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <div class="crm-modal-body">
                        <div class="crm-modal-icon crm-modal-icon--danger">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </div>
                        <p>Are you sure you want to delete <strong>{{ $invoice->invoice_id }}</strong>? This action cannot be undone.</p>
                    </div>
                    <div class="crm-modal-footer">
                        <button type="button" @click="deleteOpen = false" class="crm-btn crm-btn-secondary">Cancel</button>
                        <form method="POST" action="{{ route('crm.invoices.destroy', $invoice) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="crm-btn crm-btn-danger">Delete Invoice</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-crm::layout>

