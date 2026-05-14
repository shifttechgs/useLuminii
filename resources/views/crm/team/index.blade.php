<x-crm::layout title="Team Members">
<div class="crm-page-header">
    <div><h1 class="crm-page-title">Team Members</h1><p class="crm-page-subtitle">Manage your team and send invites</p></div>
    <a href="{{ route('crm.team.create') }}" class="crm-btn crm-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        Invite Member
    </a>
</div>

<div class="crm-table-wrap">
    <table class="crm-table">
        <thead><tr><th>Member</th><th>Role</th><th>Job Title</th><th>Phone</th><th>Status</th><th>Joined</th><th></th></tr></thead>
        <tbody>
        @forelse($members as $m)
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    <div class="crm-avatar" style="background:var(--color-bg);color:var(--color-ink-2);border:1px solid var(--color-border);">{{ strtoupper(substr($m->user->name ?? 'X', 0, 2)) }}</div>
                    <div>
                        <p style="font-weight:500;">{{ $m->user->name ?? '—' }}</p>
                        <p style="font-size:0.75rem;color:var(--color-ink-3);">{{ $m->user->email ?? '—' }}</p>
                    </div>
                </div>
            </td>
            <td><span class="crm-badge crm-badge-navy" style="font-size:0.6875rem;">{{ $m->role }}</span></td>
            <td style="color:var(--color-ink-2);">{{ $m->job_title ?? '—' }}</td>
            <td style="color:var(--color-ink-2);">{{ $m->phone ?? '—' }}</td>
            <td><span class="crm-badge {{ $m->is_active ? 'crm-badge-success' : 'crm-badge-neutral' }}">{{ $m->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td style="color:var(--color-ink-3);">{{ $m->joined_at ? $m->joined_at->format('d M Y') : ($m->invited_at ? 'Invited '.$m->invited_at->format('d M') : '—') }}</td>
            <td style="display:flex;gap:0.375rem;">
                <a href="{{ route('crm.team.edit', $m) }}" class="crm-btn crm-btn-ghost crm-btn-sm">Edit</a>
                <form method="POST" action="{{ route('crm.team.invite', $m) }}">@csrf
                    <button type="submit" class="crm-btn crm-btn-ghost crm-btn-sm" title="Resend invite">Resend</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="crm-empty"><p class="crm-empty-title">No team members yet</p><a href="{{ route('crm.team.create') }}" class="crm-btn crm-btn-primary" style="margin-top:1rem;">Invite Member</a></div></td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</x-crm::layout>

