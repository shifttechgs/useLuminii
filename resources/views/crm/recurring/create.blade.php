<x-crm::layout title="New Recurring Invoice">
<div class="crm-page-header">
    <div><a href="{{ route('crm.recurring.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Recurring</a> / <span style="font-size:0.875rem;">New</span>
    <h1 class="crm-page-title">New Recurring Invoice</h1></div>
</div>
<form method="POST" action="{{ route('crm.recurring.store') }}">
@csrf
<div style="display:grid;grid-template-columns:1fr 280px;gap:1.25rem;">
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Schedule Details</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Client <span style="color:var(--color-danger);">*</span></label>
                    <select name="client_id" class="crm-select" required>
                        <option value="">— Select Client —</option>
                        @foreach($clients as $c)
                        <option value="{{ $c->client_id }}" {{ old('client_id')==$c->client_id?'selected':'' }}>{{ $c->full_name }}{{ $c->company ? ' — '.$c->company : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Frequency <span style="color:var(--color-danger);">*</span></label>
                    <select name="frequency" class="crm-select" required>
                        @foreach(['Weekly','Monthly','Quarterly','Annually'] as $f)
                        <option value="{{ $f }}" {{ old('frequency','Monthly')==$f?'selected':'' }}>{{ $f }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Status</label>
                    <select name="status" class="crm-select">
                        @foreach(['Active','Paused','Cancelled'] as $s)
                        <option value="{{ $s }}" {{ old('status','Active')==$s?'selected':'' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Start Date <span style="color:var(--color-danger);">*</span></label>
                    <input type="date" name="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}" class="crm-input" required>
                </div>
                <div>
                    <label class="crm-label">End Date <span class="crm-label-hint">(optional)</span></label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="crm-input">
                </div>
                <div style="grid-column:1/-1;"><label class="crm-label">Client Message</label><textarea name="client_message" class="crm-textarea" rows="2">{{ old('client_message') }}</textarea></div>
                <div style="grid-column:1/-1;"><label class="crm-label">Internal Notes</label><textarea name="internal_notes" class="crm-textarea" rows="2">{{ old('internal_notes') }}</textarea></div>
            </div>
        </div>
        @include('crm.partials.line-items', ['items' => old('items', [])])
    </div>
    <div style="display:flex;flex-direction:column;gap:0.5rem;padding-top:3.5rem;">
        <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">Create Schedule</button>
        <a href="{{ route('crm.recurring.index') }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
    </div>
</div>
</form>
</x-crm::layout>

