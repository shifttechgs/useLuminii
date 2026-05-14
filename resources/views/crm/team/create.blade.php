<x-crm::layout title="Invite Team Member">
<div class="crm-page-header">
    <div><a href="{{ route('crm.team.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Team</a> / <span style="font-size:0.875rem;">Invite</span>
    <h1 class="crm-page-title">Invite Team Member</h1></div>
</div>
<form method="POST" action="{{ route('crm.team.store') }}">
@csrf
<div style="max-width:560px;">
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Member Details</span></div>
        <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">
            <div><label class="crm-label">Full Name <span style="color:var(--color-danger);">*</span></label><input type="text" name="name" value="{{ old('name') }}" class="crm-input" required></div>
            <div><label class="crm-label">Email <span style="color:var(--color-danger);">*</span></label><input type="email" name="email" value="{{ old('email') }}" class="crm-input" required></div>
            <div>
                <label class="crm-label">Role <span style="color:var(--color-danger);">*</span></label>
                <select name="role" class="crm-select" required>
                    <option value="">— Select Role —</option>
                    @foreach(['Admin','SalesRep','Technician','Engineer','Accountant','Support'] as $r)
                    <option value="{{ $r }}" {{ old('role')==$r?'selected':'' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="crm-label">Job Title</label><input type="text" name="job_title" value="{{ old('job_title') }}" class="crm-input" placeholder="e.g. Senior Developer"></div>
            <div><label class="crm-label">Phone</label><input type="text" name="phone" value="{{ old('phone') }}" class="crm-input"></div>
        </div>
        <div class="crm-card-footer" style="background:var(--color-bg);">
            <p style="font-size:0.8125rem;color:var(--color-ink-3);">A temporary password will be generated and emailed to the new member.</p>
        </div>
    </div>
    <div style="margin-top:1rem;display:flex;gap:0.5rem;">
        <button type="submit" class="crm-btn crm-btn-primary">Send Invite</button>
        <a href="{{ route('crm.team.index') }}" class="crm-btn crm-btn-ghost">Cancel</a>
    </div>
</div>
</form>
</x-crm::layout>

