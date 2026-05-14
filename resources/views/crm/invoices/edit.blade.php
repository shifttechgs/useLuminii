<x-crm::layout title="Edit Invoice">
<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.invoices.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Invoices</a>
            <span style="color:var(--color-ink-3);">/</span>
            <a href="{{ route('crm.invoices.show', $invoice) }}" style="color:var(--color-ink-3);font-size:0.875rem;">{{ $invoice->invoice_id }}</a>
            <span style="color:var(--color-ink-3);">/</span><span style="font-size:0.875rem;">Edit</span>
        </div>
        <h1 class="crm-page-title">Edit Invoice</h1>
    </div>
    <a href="{{ route('crm.invoices.show', $invoice) }}" class="crm-btn crm-btn-secondary">View Invoice</a>
</div>

<form method="POST" action="{{ route('crm.invoices.update', $invoice) }}">
@csrf @method('PUT')
<div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;">
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Invoice Details</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Client</label>
                    <p style="font-size:0.875rem;font-weight:500;padding:0.5rem 0;">{{ $invoice->client->full_name }}</p>
                </div>
                <div>
                    <label class="crm-label">Invoice Date</label>
                    <input type="date" name="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date?->format('Y-m-d')) }}" class="crm-input">
                </div>
                <div>
                    <label class="crm-label">Due Date</label>
                    <input type="date" name="due_date" value="{{ old('due_date', $invoice->due_date?->format('Y-m-d')) }}" class="crm-input">
                </div>
                <div>
                    <label class="crm-label">Payment Method</label>
                    <select name="payment_method" class="crm-select">
                        @foreach(['EFT','Cash','PayPal','Card','Cheque'] as $m)
                        <option value="{{ $m }}" {{ old('payment_method',$invoice->payment_method)==$m?'selected':'' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Currency</label>
                    <select name="currency" class="crm-select">
                        @foreach(['ZAR' => 'ZAR – South African Rand', 'USD' => 'USD – US Dollar', 'EUR' => 'EUR – Euro', 'GBP' => 'GBP – British Pound'] as $code => $label)
                        <option value="{{ $code }}" {{ old('currency', $invoice->currency ?? 'ZAR') === $code ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Discount</label>
                    <input type="number" name="discount" value="{{ old('discount', $invoice->discount) }}" class="crm-input" min="0" step="0.01">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Client Message</label>
                    <textarea name="client_message" class="crm-textarea" rows="2">{{ old('client_message', $invoice->client_message) }}</textarea>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Internal Notes</label>
                    <textarea name="internal_notes" class="crm-textarea" rows="2">{{ old('internal_notes', $invoice->internal_notes) }}</textarea>
                </div>
            </div>
        </div>
        @php $invoiceCurrencySymbol = \App\Models\BusinessSetup::currencySymbol(old('currency', $invoice->currency ?? 'ZAR')); @endphp
        @include('crm.partials.line-items', ['items' => old('items', $invoice->items->toArray()), 'currencySymbol' => $invoiceCurrencySymbol])
    </div>
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Status</span></div>
            <div class="crm-card-body">
                <select name="status" class="crm-select">
                    @foreach(['Draft','Sent','PartiallyPaid','Paid','Overdue','Cancelled'] as $s)
                    <option value="{{ $s }}" {{ old('status',$invoice->status)==$s?'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:0.5rem;">
            <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">Save Changes</button>
            <a href="{{ route('crm.invoices.show', $invoice) }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
        </div>
    </div>
</div>
</form>
</x-crm::layout>

