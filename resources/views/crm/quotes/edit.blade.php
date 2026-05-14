<x-crm::layout title="Edit Quote">

<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.quotes.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Quotes</a>
            <span style="color:var(--color-ink-3);">/</span>
            <a href="{{ route('crm.quotes.show', $quote) }}" style="color:var(--color-ink-3);font-size:0.875rem;">{{ $quote->quote_id }}</a>
            <span style="color:var(--color-ink-3);">/</span>
            <span style="font-size:0.875rem;">Edit</span>
        </div>
        <h1 class="crm-page-title">Edit Quote</h1>
    </div>
    <a href="{{ route('crm.quotes.show', $quote) }}" class="crm-btn crm-btn-secondary">View Quote</a>
</div>

<form method="POST" action="{{ route('crm.quotes.update', $quote) }}">
@csrf @method('PUT')
<div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;">

    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Quote Details</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Client</label>
                    <p style="font-size:0.875rem;color:var(--color-ink-1);font-weight:500;padding:0.5rem 0;">{{ $quote->client->full_name }}</p>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Quote Title / Scope <span style="color:var(--color-danger);">*</span></label>
                    <input type="text" name="job_title" value="{{ old('job_title', $quote->job_title) }}" class="crm-input" required>
                </div>
                <div>
                    <label class="crm-label">Quote Date</label>
                    <input type="date" name="quote_date" value="{{ old('quote_date', $quote->quote_date?->format('Y-m-d')) }}" class="crm-input">
                </div>
                <div>
                    <label class="crm-label">Expiry Date</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date', $quote->expiry_date?->format('Y-m-d')) }}" class="crm-input">
                </div>
                <div>
                    <label class="crm-label">Currency</label>
                    <select name="currency" class="crm-select">
                        @foreach(['ZAR' => 'ZAR – South African Rand', 'USD' => 'USD – US Dollar', 'EUR' => 'EUR – Euro', 'GBP' => 'GBP – British Pound'] as $code => $label)
                        <option value="{{ $code }}" {{ old('currency', $quote->currency ?? 'ZAR') === $code ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Required Deposit</label>
                    <input type="number" name="required_deposit" value="{{ old('required_deposit', $quote->required_deposit) }}" class="crm-input" min="0" step="0.01">
                </div>
                <div>
                    <label class="crm-label">Discount</label>
                    <input type="number" name="discount" value="{{ old('discount', $quote->discount) }}" class="crm-input" min="0" step="0.01">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Client Message</label>
                    <textarea name="client_notes" class="crm-textarea" rows="3">{{ old('client_notes', $quote->client_notes) }}</textarea>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Internal Notes</label>
                    <textarea name="internal_notes" class="crm-textarea" rows="2">{{ old('internal_notes', $quote->internal_notes) }}</textarea>
                </div>
            </div>
        </div>
        @php $quoteCurrencySymbol = \App\Models\BusinessSetup::currencySymbol(old('currency', $quote->currency ?? 'ZAR')); @endphp
        @include('crm.partials.line-items', ['items' => old('items', $quote->items->toArray()), 'currencySymbol' => $quoteCurrencySymbol])
    </div>

    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Status</span></div>
            <div class="crm-card-body">
                <select name="status" class="crm-select">
                    @foreach(['Draft','Sent','Accepted','Declined','Expired'] as $s)
                    <option value="{{ $s }}" {{ old('status',$quote->status)==$s?'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:0.5rem;">
            <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">Save Changes</button>
            <a href="{{ route('crm.quotes.show', $quote) }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
        </div>
    </div>

</div>
</form>

</x-crm::layout>

