<x-crm::layout title="New User">
<div class="crm-page-header">
    <div><a href="{{ route('crm.users.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Users</a> / <span style="font-size:0.875rem;">New</span>
    <h1 class="crm-page-title">New User</h1></div>
</div>
<form method="POST" action="{{ route('crm.users.store') }}">
@csrf
<div style="max-width:560px;">
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Account Details</span></div>
        <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">
            <div><label class="crm-label">Full Name <span style="color:var(--color-danger);">*</span></label><input type="text" name="name" value="{{ old('name') }}" class="crm-input" required></div>
            <div><label class="crm-label">Email <span style="color:var(--color-danger);">*</span></label><input type="email" name="email" value="{{ old('email') }}" class="crm-input" required></div>
            <div><label class="crm-label">Password <span style="color:var(--color-danger);">*</span></label><input type="password" name="password" class="crm-input" required minlength="8"></div>
            <div><label class="crm-label">Confirm Password</label><input type="password" name="password_confirmation" class="crm-input" required></div>
            <div>
                <label class="crm-label">Role <span style="color:var(--color-danger);">*</span></label>
                <select name="role" class="crm-select" required>
                    <option value="">— Select Role —</option>
                    @foreach(\App\Models\User::ROLES as $key => $label)
                    <option value="{{ $key }}" {{ old('role')==$key?'selected':'' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                <label for="is_active" class="crm-label" style="margin:0;cursor:pointer;">Active account</label>
            </div>
        </div>
    </div>
    <div style="margin-top:1rem;display:flex;gap:0.5rem;">
        <button type="submit" class="crm-btn crm-btn-primary">Create User</button>
        <a href="{{ route('crm.users.index') }}" class="crm-btn crm-btn-ghost">Cancel</a>
    </div>
</div>
</form>
</x-crm::layout>

