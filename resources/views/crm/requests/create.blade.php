<x-crm::layout title="New Request">
<div class="crm-page-header">
    <div>
        <a href="{{ route('crm.requests.index') }}" style="color:var(--crm-text-3);font-size:0.875rem;">Requests</a>
        <span style="color:var(--crm-text-3);font-size:0.875rem;"> / New</span>
        <h1 class="crm-page-title">New Client Request</h1>
    </div>
</div>

@if($fromLead)
<div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:10px;padding:0.875rem 1.125rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.75rem;">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1.125rem;height:1.125rem;flex-shrink:0;color:#0284c7;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span style="font-size:0.875rem;color:#0369a1;">Pre-filled from lead <strong>{{ $fromLead->name }}</strong>. Select the matching client below.</span>
</div>
@endif

@if($errors->any())
<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:0.875rem 1.125rem;margin-bottom:1.25rem;">
    <ul style="font-size:0.8125rem;color:#dc2626;margin:0;padding-left:1.25rem;">
        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('crm.requests.store') }}">
@csrf
<div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;align-items:start;">

    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Request Details</span></div>
        <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">
            <div>
                <label class="crm-label">Client <span style="color:var(--color-danger);">*</span></label>
                <select name="client_id" class="crm-select" required>
                    <option value="">— Select Client —</option>
                    @foreach($clients as $id => $label)
                    <option value="{{ $id }}" {{ old('client_id')===$id?'selected':'' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="crm-label">Service Requested</label>
                <select name="service_id" class="crm-select">
                    <option value="">— Select Service —</option>
                    @php $grouped = $services->groupBy('category'); @endphp
                    @foreach($grouped as $category => $svcs)
                    <optgroup label="{{ $category ?: 'General' }}">
                        @foreach($svcs as $svc)
                        <option value="{{ $svc->service_id }}" {{ old('service_id')===$svc->service_id?'selected':'' }}>
                            {{ $svc->name }}@if($svc->unit_price > 0) — R{{ number_format($svc->unit_price, 0) }}@endif
                        </option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="crm-label">Title <span style="color:var(--color-danger);">*</span></label>
                <input type="text" name="title" value="{{ old('title', $fromLead?->message ? \Illuminate\Support\Str::limit($fromLead->message, 60) : '') }}" class="crm-input" required placeholder="Brief description of the request">
            </div>
            <div>
                <label class="crm-label">Description</label>
                <textarea name="description" class="crm-textarea" rows="4" placeholder="Full details of what the client needs…">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="crm-label">Assessment Notes <span class="crm-label-hint">(internal)</span></label>
                <textarea name="assessment_notes" class="crm-textarea" rows="3" placeholder="Your initial assessment…">{{ old('assessment_notes') }}</textarea>
            </div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Classification</span></div>
            <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <label class="crm-label">Status</label>
                    <select name="status" class="crm-select">
                        @foreach(['New','InReview','Quoted','Approved','Closed'] as $s)
                        <option value="{{ $s }}" {{ old('status','New')===$s?'selected':'' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Priority</label>
                    <select name="priority" class="crm-select">
                        <option value="">— None —</option>
                        @foreach(['Low','Medium','High','Urgent'] as $p)
                        <option value="{{ $p }}" {{ old('priority')===$p?'selected':'' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Assigned To</label>
                    <select name="assigned_to" class="crm-select">
                        <option value="">— Unassigned —</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to')==$user->id?'selected':'' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">Create Request</button>
        <a href="{{ route('crm.requests.index') }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
    </div>

</div>
</form>
</x-crm::layout>
