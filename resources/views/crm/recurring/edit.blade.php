<x-crm::layout title="Edit Recurring Invoice">
<div class="crm-page-header">
    <div><a href="{{ route('crm.recurring.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Recurring</a> / <span style="font-size:0.875rem;">Edit</span>
    <h1 class="crm-page-title">Edit Recurring Invoice</h1></div>
    <a href="{{ route('crm.recurring.show', $recurringInvoice) }}" class="crm-btn crm-btn-secondary">View</a>
</div>
<form method="POST" action="{{ route('crm.recurring.update', $recurringInvoice) }}">
@csrf @method('PUT')
<div style="display:grid;grid-template-columns:1fr 280px;gap:1.25rem;">
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Schedule Details</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;"><label class="crm-label">Client</label><p style="font-size:0.875rem;font-weight:500;padding:0.5rem 0;">{{ $recurringInvoice->client->full_name }}</p></div>
                <div>
                    <label class="crm-label">Frequency</label>
                    <select name="frequency" class="crm-select">
                        @foreach(['Weekly','Monthly','Quarterly','Annually'] as $f)
                        <option value="{{ $f }}" {{ old('frequency',$recurringInvoice->frequency)==$f?'selected':'' }}>{{ $f }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Status</label>
                    <select name="status" class="crm-select">
                        @foreach(['Active','Paused','Cancelled'] as $s)
                        <option value="{{ $s }}" {{ old('status',$recurringInvoice->status)==$s?'selected':'' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="crm-label">Start Date</label><input type="date" name="start_date" value="{{ old('start_date', $recurringInvoice->start_date?->format('Y-m-d')) }}" class="crm-input"></div>
                <div><label class="crm-label">End Date</label><input type="date" name="end_date" value="{{ old('end_date', $recurringInvoice->end_date?->format('Y-m-d')) }}" class="crm-input"></div>
                <div style="grid-column:1/-1;"><label class="crm-label">Client Message</label><textarea name="client_message" class="crm-textarea" rows="2">{{ old('client_message', $recurringInvoice->client_message) }}</textarea></div>
                <div style="grid-column:1/-1;"><label class="crm-label">Internal Notes</label><textarea name="internal_notes" class="crm-textarea" rows="2">{{ old('internal_notes', $recurringInvoice->internal_notes) }}</textarea></div>
            </div>
        </div>
        @include('crm.partials.line-items', ['items' => old('items', $recurringInvoice->items->toArray())])
    </div>
    <div style="display:flex;flex-direction:column;gap:0.5rem;padding-top:3.5rem;">
        <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">Save Changes</button>
        <a href="{{ route('crm.recurring.index') }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
    </div>
</div>
</form>
</x-crm::layout>

