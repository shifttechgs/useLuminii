<x-crm::layout title="Edit User">
<div class="crm-page-header">
    <div><a href="{{ route('crm.users.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Users</a> / <span style="font-size:0.875rem;">Edit</span>
    <h1 class="crm-page-title">Edit User</h1></div>
    <a href="{{ route('crm.users.index') }}" class="crm-btn crm-btn-secondary">Back</a>
</div>
<div style="max-width:560px;" x-data="{ deactivateOpen: false }">
<form method="POST" action="{{ route('crm.users.update', $user) }}">
@csrf @method('PUT')
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">{{ $user->name }}</span><span style="font-size:0.8125rem;color:var(--color-ink-3);">{{ $user->email }}</span></div>
        <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">
            <div><label class="crm-label">Full Name</label><input type="text" name="name" value="{{ old('name', $user->name) }}" class="crm-input" required></div>
            <div><label class="crm-label">Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="crm-input" required></div>
            <div><label class="crm-label">New Password <span class="crm-label-hint">(leave blank to keep current)</span></label><input type="password" name="password" class="crm-input" minlength="8"></div>
            <div><label class="crm-label">Confirm Password</label><input type="password" name="password_confirmation" class="crm-input"></div>
            <div>
                <label class="crm-label">Role</label>
                <select name="role" class="crm-select">
                    @foreach(\App\Models\User::ROLES as $key => $label)
                    <option value="{{ $key }}" {{ old('role',$user->role)==$key?'selected':'' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $user->is_active?'checked':'' }}>
                <label for="is_active" class="crm-label" style="margin:0;cursor:pointer;">Active account</label>
            </div>
        </div>
    </div>
    <div style="margin-top:1rem;display:flex;gap:0.5rem;">
        <button type="submit" class="crm-btn crm-btn-primary">Save Changes</button>
        @if($user->id !== auth()->id())
        <button type="button" @click="deactivateOpen = true" class="crm-btn crm-btn-danger">Deactivate</button>
        @endif
        <a href="{{ route('crm.users.index') }}" class="crm-btn crm-btn-ghost">Cancel</a>
    </div>
</form>

@if($user->id !== auth()->id())
<div x-show="deactivateOpen" x-cloak class="crm-modal-overlay" @click.self="deactivateOpen = false">
    <div class="crm-modal" @click.stop>
        <div class="crm-modal-header">
            <h3 class="crm-modal-title">Deactivate User</h3>
            <button type="button" @click="deactivateOpen = false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="crm-modal-body">
            <div class="crm-modal-icon crm-modal-icon--danger">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
            <p>Are you sure you want to deactivate <strong>{{ $user->name }}</strong>? They will no longer be able to log in.</p>
        </div>
        <div class="crm-modal-footer">
            <button type="button" @click="deactivateOpen = false" class="crm-btn crm-btn-secondary">Cancel</button>
            <form method="POST" action="{{ route('crm.users.destroy', $user) }}">
                @csrf @method('DELETE')
                <button type="submit" class="crm-btn crm-btn-danger">Deactivate</button>
            </form>
        </div>
    </div>
</div>
@endif
</div>
</x-crm::layout>

