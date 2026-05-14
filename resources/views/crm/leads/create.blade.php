<x-crm::layout title="New Lead">

<div class="crm-page-header">
    <div>
        <a href="{{ route('crm.leads.index') }}" style="color:var(--crm-text-3);font-size:0.875rem;">Leads</a>
        <span style="color:var(--crm-text-3);font-size:0.875rem;"> / New</span>
        <h1 class="crm-page-title">Capture New Lead</h1>
        <p class="crm-page-subtitle">Add details from a call, referral, or other source</p>
    </div>
</div>

@if($errors->any())
<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:0.875rem 1.125rem;margin-bottom:1.25rem;">
    <p style="font-size:0.875rem;font-weight:600;color:#dc2626;margin:0 0 0.375rem;">Please fix the following:</p>
    <ul style="font-size:0.8125rem;color:#dc2626;margin:0;padding-left:1.25rem;">
        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('crm.leads.store') }}">
@csrf
<div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;align-items:start;">

    {{-- Left: contact + message --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Contact Information</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Full Name <span style="color:var(--color-danger);">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="crm-input" required autofocus placeholder="Jane Smith">
                </div>
                <div>
                    <label class="crm-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="crm-input" placeholder="jane@example.com">
                </div>
                <div>
                    <label class="crm-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="crm-input" placeholder="+27 …">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Company <span class="crm-label-hint">(optional)</span></label>
                    <input type="text" name="company" value="{{ old('company') }}" class="crm-input" placeholder="Acme Corp">
                </div>
            </div>
        </div>

        {{-- Services interested in --}}
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Services Interested In</span></div>
            <div class="crm-card-body">
                <p style="font-size:0.8125rem;color:var(--crm-text-3);margin:0 0 0.875rem;">Select all that apply</p>
                @php $grouped = $services->groupBy('category'); @endphp
                @foreach($grouped as $category => $svcs)
                <div style="margin-bottom:0.875rem;">
                    <div style="font-size:0.6875rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-3);margin-bottom:0.5rem;">{{ $category ?: 'General' }}</div>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                        @foreach($svcs as $svc)
                        @php $checked = in_array($svc->name, old('services_interested', [])); @endphp
                        <label class="qc-chip {{ $checked ? 'qc-chip-on' : '' }}" style="cursor:pointer;">
                            <input type="checkbox" name="services_interested[]" value="{{ $svc->name }}" {{ $checked ? 'checked' : '' }} style="position:absolute;opacity:0;width:0;height:0;">
                            {{ $svc->name }}
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
                @if($services->isEmpty())
                <p style="font-size:0.8125rem;color:var(--crm-text-3);">No active services. <a href="{{ route('crm.services.create') }}" style="color:var(--crm-accent);">Add services</a></p>
                @endif
            </div>
        </div>

        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Message / Notes</span></div>
            <div class="crm-card-body">
                <textarea name="message" class="crm-textarea" rows="4" placeholder="What did they say? What are they looking for?">{{ old('message') }}</textarea>
            </div>
        </div>

        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Internal Notes <span class="crm-label-hint">(not shared with client)</span></span></div>
            <div class="crm-card-body">
                <textarea name="admin_notes" class="crm-textarea" rows="3" placeholder="Gut feeling, next steps, context…">{{ old('admin_notes') }}</textarea>
            </div>
        </div>

    </div>

    {{-- Right: classification --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Classification</span></div>
            <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <label class="crm-label">Source <span style="color:var(--color-danger);">*</span></label>
                    <select name="source" class="crm-select" required>
                        @foreach(\App\Models\Lead::sourceOptions() as $key => $label)
                        <option value="{{ $key }}" {{ old('source','manual')===$key?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Status</label>
                    <select name="status" class="crm-select">
                        @foreach(array_keys(\App\Models\Lead::statusOptions()) as $s)
                        <option value="{{ $s }}" {{ old('status','New')===$s?'selected':'' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Priority</label>
                    <select name="priority" class="crm-select">
                        <option value="">— None —</option>
                        @foreach(['Low','Normal','High','Urgent'] as $p)
                        <option value="{{ $p }}" {{ old('priority')===$p?'selected':'' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Budget (R) <span class="crm-label-hint">(approx)</span></label>
                    <input type="number" name="budget" value="{{ old('budget') }}" class="crm-input" placeholder="0" min="0" step="500">
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

        <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">Save Lead</button>
        <a href="{{ route('crm.leads.index') }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
    </div>

</div>
</form>

@push('head')
<style>
.qc-chip {
    display: inline-flex; align-items: center;
    padding: 0.3125rem 0.75rem; border-radius: 999px;
    font-size: 0.8125rem; font-weight: 500;
    border: 1.5px solid var(--crm-border, #e4e9f0);
    background: #fff; color: var(--crm-text-2);
    transition: all 0.15s ease; user-select: none;
}
.qc-chip:hover { border-color: var(--crm-accent, #635bff); color: var(--crm-accent, #635bff); }
.qc-chip-on, .qc-chip:has(input:checked) {
    background: #f0f0ff; border-color: var(--crm-accent, #635bff);
    color: var(--crm-accent, #635bff);
}
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('.qc-chip input[type="checkbox"]').forEach(function(cb) {
    cb.addEventListener('change', function() {
        this.closest('.qc-chip').classList.toggle('qc-chip-on', this.checked);
    });
});
</script>
@endpush

</x-crm::layout>
