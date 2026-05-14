<x-crm::layout title="Users">
<div class="crm-page-header">
    <div><h1 class="crm-page-title">Users</h1><p class="crm-page-subtitle">System user accounts and roles</p></div>
    <a href="{{ route('crm.users.create') }}" class="crm-btn crm-btn-primary">New User</a>
</div>
<div class="crm-table-wrap">
    <table class="crm-table">
        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Last Login</th><th></th></tr></thead>
        <tbody>
        @forelse($users as $u)
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    <div class="crm-avatar" style="background:var(--color-bg);color:var(--color-ink-2);border:1px solid var(--color-border);">{{ strtoupper(substr($u->name, 0, 2)) }}</div>
                    <span style="font-weight:500;">{{ $u->name }}</span>
                </div>
            </td>
            <td style="color:var(--color-ink-2);">{{ $u->email }}</td>
            <td><span class="crm-badge crm-badge-navy" style="font-size:0.6875rem;">{{ \App\Models\User::ROLES[$u->role] ?? $u->role }}</span></td>
            <td><span class="crm-badge {{ $u->is_active ? 'crm-badge-success' : 'crm-badge-neutral' }}">{{ $u->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td style="color:var(--color-ink-3);">{{ $u->last_login_at ? $u->last_login_at->diffForHumans() : 'Never' }}</td>
            <td><a href="{{ route('crm.users.edit', $u) }}" class="crm-btn crm-btn-ghost crm-btn-sm">Edit</a></td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="crm-empty"><p class="crm-empty-title">No users found</p></div></td></tr>
        @endforelse
        </tbody>
    </table>
    @if($users->hasPages())<div style="padding:1rem 1.25rem;border-top:1px solid var(--color-border);">{{ $users->links() }}</div>@endif
</div>
</x-crm::layout>

