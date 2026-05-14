<x-crm::layout title="Notifications">
<div class="crm-page-header">
    <div><h1 class="crm-page-title">Notifications</h1><p class="crm-page-subtitle">{{ $unread }} unread</p></div>
    @if($unread > 0)
    <form method="POST" action="{{ route('crm.notifications.read-all') }}">@csrf
        <button type="submit" class="crm-btn crm-btn-secondary">Mark all read</button>
    </form>
    @endif
</div>

<div class="crm-card">
    @forelse($notifications as $n)
    @php
    $typeColors = ['success'=>['bg'=>'#ecfdf3','icon'=>'#12b76a'],'warning'=>['bg'=>'#fffaeb','icon'=>'#f79009'],'danger'=>['bg'=>'#fef3f2','icon'=>'#f04438'],'info'=>['bg'=>'#eff8ff','icon'=>'#2e90fa']];
    $tc = $typeColors[$n->type] ?? $typeColors['info'];
    @endphp
    <div style="display:flex;align-items:flex-start;gap:0.875rem;padding:1rem 1.25rem;border-bottom:1px solid var(--color-border);{{ !$n->is_read ? 'background:#fafbff;' : '' }}">
        <div style="width:2.25rem;height:2.25rem;border-radius:var(--radius-md);background:{{ $tc['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            @if($n->type === 'success')
            <svg fill="none" viewBox="0 0 24 24" stroke="{{ $tc['icon'] }}" style="width:1.125rem;height:1.125rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            @elseif($n->type === 'danger')
            <svg fill="none" viewBox="0 0 24 24" stroke="{{ $tc['icon'] }}" style="width:1.125rem;height:1.125rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @elseif($n->type === 'warning')
            <svg fill="none" viewBox="0 0 24 24" stroke="{{ $tc['icon'] }}" style="width:1.125rem;height:1.125rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            @else
            <svg fill="none" viewBox="0 0 24 24" stroke="{{ $tc['icon'] }}" style="width:1.125rem;height:1.125rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @endif
        </div>
        <div style="flex:1;min-width:0;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;">
                <div>
                    <p style="font-size:0.875rem;font-weight:{{ $n->is_read ? '400' : '600' }};color:var(--color-ink-1);">{{ $n->title }}</p>
                    <p style="font-size:0.8125rem;color:var(--color-ink-2);margin-top:0.125rem;">{{ $n->description }}</p>
                </div>
                <div style="display:flex;align-items:center;gap:0.5rem;flex-shrink:0;">
                    <span style="font-size:0.75rem;color:var(--color-ink-3);">{{ $n->created_at->diffForHumans() }}</span>
                    @if(!$n->is_read)
                    <form method="POST" action="{{ route('crm.notifications.read', $n) }}">@csrf
                        <button type="submit" class="crm-btn crm-btn-ghost crm-btn-sm" title="Mark read">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:0.875rem;height:0.875rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </form>
                    @endif
                    @if($n->link)
                    <a href="{{ $n->link }}" class="crm-btn crm-btn-ghost crm-btn-sm">View →</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="crm-empty" style="padding:3rem;">
        <div class="crm-empty-icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1.5rem;height:1.5rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg></div>
        <p class="crm-empty-title">All clear</p>
        <p class="crm-empty-text">No notifications</p>
    </div>
    @endforelse
    @if($notifications->hasPages())
    <div style="padding:1rem 1.25rem;border-top:1px solid var(--color-border);">{{ $notifications->links() }}</div>
    @endif
</div>
</x-crm::layout>

