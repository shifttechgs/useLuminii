<x-crm::layout title="{{ $quote->quote_id }}">

<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.quotes.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Quotes</a>
            <span style="color:var(--color-ink-3);">/</span>
            <span style="font-size:0.875rem;">{{ $quote->quote_id }}</span>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <h1 class="crm-page-title">{{ $quote->job_title }}</h1>
            @include('crm.partials.quote-badge', ['status' => $quote->status])
        </div>
    </div>
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
        @if(in_array($quote->status, ['Draft','Sent']))
        <form method="POST" action="{{ route('crm.quotes.send', $quote) }}">@csrf
            <button type="submit" class="crm-btn crm-btn-secondary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Send Email
            </button>
        </form>
        @endif
        @if($quote->status === 'Accepted' && !$quote->job()->exists())
        <form method="POST" action="{{ route('crm.quotes.convert-to-job', $quote) }}">@csrf
            <button type="submit" class="crm-btn crm-btn-secondary">Convert to Job</button>
        </form>
        @endif
        <a href="{{ route('quote.pdf', $quote->quote_id) }}" class="crm-btn crm-btn-secondary" target="_blank">Download PDF</a>
        <a href="{{ route('crm.quotes.edit', $quote) }}" class="crm-btn crm-btn-primary">Edit</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;">

    {{-- Left --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        {{-- Line items --}}
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Line Items</span></div>
            <table class="crm-table">
                <thead><tr><th>Description</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead>
                <tbody>
                @forelse($quote->items as $item)
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
                    <div class="crm-detail-row"><span class="crm-detail-label">Subtotal</span><span class="crm-detail-value">R {{ number_format($quote->sub_total, 2) }}</span></div>
                    @if($quote->discount > 0)
                    <div class="crm-detail-row"><span class="crm-detail-label">Discount</span><span class="crm-detail-value" style="color:var(--color-success-text);">– R {{ number_format($quote->discount, 2) }}</span></div>
                    @endif
                    <div class="crm-detail-row" style="font-size:1rem;font-weight:700;">
                        <span class="crm-detail-label" style="font-weight:700;color:var(--color-ink-1);">Total</span>
                        <span class="crm-detail-value">R {{ number_format($quote->grand_total, 2) }}</span>
                    </div>
                    @if($quote->required_deposit > 0)
                    <div class="crm-detail-row"><span class="crm-detail-label">Deposit Required</span><span class="crm-detail-value" style="color:var(--color-warning-text);">R {{ number_format($quote->required_deposit, 2) }}</span></div>
                    @endif
                </div>
            </div>
        </div>

        @if($quote->client_notes)
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Client Message</span></div>
            <div class="crm-card-body"><p style="font-size:0.875rem;color:var(--color-ink-2);line-height:1.6;">{{ $quote->client_notes }}</p></div>
        </div>
        @endif
        @if($quote->internal_notes)
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Internal Notes</span><span class="crm-badge crm-badge-warning">Internal</span></div>
            <div class="crm-card-body"><p style="font-size:0.875rem;color:var(--color-ink-2);line-height:1.6;">{{ $quote->internal_notes }}</p></div>
        </div>
        @endif
    </div>

    {{-- Right --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Details</span></div>
            <div class="crm-card-body">
                <div class="crm-detail-row"><span class="crm-detail-label">Quote ID</span><span class="crm-detail-value crm-mono">{{ $quote->quote_id }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Client</span><span class="crm-detail-value"><a href="{{ route('crm.clients.show', $quote->client) }}" style="color:var(--color-info-text);">{{ $quote->client->full_name }}</a></span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Sales Rep</span><span class="crm-detail-value">{{ $quote->salesRep->name ?? '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Quote Date</span><span class="crm-detail-value">{{ $quote->quote_date ? $quote->quote_date->format('d M Y') : '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Expiry Date</span><span class="crm-detail-value">{{ $quote->expiry_date ? $quote->expiry_date->format('d M Y') : '—' }}</span></div>
                @if($quote->accepted_at)
                <div class="crm-detail-row"><span class="crm-detail-label">Accepted</span><span class="crm-detail-value" style="color:var(--color-success-text);">{{ $quote->accepted_at->format('d M Y') }}</span></div>
                @endif
            </div>
        </div>
        {{-- Client Hub Link --}}
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Client Hub</span></div>
            <div class="crm-card-body">
                <p style="font-size:0.8125rem;color:var(--color-ink-3);margin-bottom:0.75rem;">Share this link with your client:</p>
                <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-sm);padding:0.5rem 0.625rem;font-size:0.75rem;font-family:monospace;word-break:break-all;color:var(--color-ink-2);">
                    {{ route('client-hub.quote', $quote->accepted_token) }}
                </div>
            </div>
        </div>
        {{-- Danger --}}
        <div class="crm-card" x-data="{ deleteOpen: false }">
            <div class="crm-card-body">
                <button type="button" @click="deleteOpen = true" class="crm-btn crm-btn-danger" style="width:100%;">Delete Quote</button>
            </div>
            <div x-show="deleteOpen" x-cloak class="crm-modal-overlay" @click.self="deleteOpen = false">
                <div class="crm-modal" @click.stop>
                    <div class="crm-modal-header">
                        <h3 class="crm-modal-title">Delete Quote</h3>
                        <button type="button" @click="deleteOpen = false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <div class="crm-modal-body">
                        <div class="crm-modal-icon crm-modal-icon--danger">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </div>
                        <p>Are you sure you want to delete <strong>{{ $quote->quote_id }}</strong>? This action cannot be undone.</p>
                    </div>
                    <div class="crm-modal-footer">
                        <button type="button" @click="deleteOpen = false" class="crm-btn crm-btn-secondary">Cancel</button>
                        <form method="POST" action="{{ route('crm.quotes.destroy', $quote) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="crm-btn crm-btn-danger">Delete Quote</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</x-crm::layout>

