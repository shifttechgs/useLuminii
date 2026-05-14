<x-crm::layout title="Edit Team Member">
<div class="crm-page-header">
    <div><a href="{{ route('crm.team.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Team</a> / <span style="font-size:0.875rem;">Edit</span>
    <h1 class="crm-page-title">Edit Team Member</h1></div>
    <a href="{{ route('crm.team.index') }}" class="crm-btn crm-btn-secondary">Back to Team</a>
</div>
<form method="POST" action="{{ route('crm.team.update', $teamMember) }}">
@csrf @method('PUT')
<div style="max-width:560px;">
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">{{ $teamMember->user->name }}</span><span style="font-size:0.8125rem;color:var(--color-ink-3);">{{ $teamMember->user->email }}</span></div>
        <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">
            <div>
                <label class="crm-label">Role</label>
                <select name="role" class="crm-select">
                    @foreach(['Admin','SalesRep','Technician','Engineer','Accountant','Support'] as $r)
                    <option value="{{ $r }}" {{ old('role',$teamMember->role)==$r?'selected':'' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="crm-label">Job Title</label><input type="text" name="job_title" value="{{ old('job_title', $teamMember->job_title) }}" class="crm-input"></div>
            <div><label class="crm-label">Phone</label><input type="text" name="phone" value="{{ old('phone', $teamMember->phone) }}" class="crm-input"></div>
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $teamMember->is_active)?'checked':'' }}>
                <label for="is_active" class="crm-label" style="margin:0;cursor:pointer;">Active account</label>
            </div>
        </div>
    </div>
    <div style="margin-top:1rem;display:flex;gap:0.5rem;">
        <button type="submit" class="crm-btn crm-btn-primary">Save Changes</button>
        <a href="{{ route('crm.team.index') }}" class="crm-btn crm-btn-ghost">Cancel</a>
    </div>
</div>
</form>
</x-crm::layout>

