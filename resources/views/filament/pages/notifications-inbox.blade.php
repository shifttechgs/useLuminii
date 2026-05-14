<x-filament-panels::page>
    @php
        $notifications = $this->getNotifications();
        $typeColors = [
            'success' => ['bg' => 'bg-emerald-50',  'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500', 'text' => 'text-emerald-700'],
            'warning' => ['bg' => 'bg-amber-50',    'border' => 'border-amber-200',   'dot' => 'bg-amber-500',   'text' => 'text-amber-700'],
            'danger'  => ['bg' => 'bg-rose-50',     'border' => 'border-rose-200',    'dot' => 'bg-rose-500',    'text' => 'text-rose-700'],
            'info'    => ['bg' => 'bg-blue-50',     'border' => 'border-blue-200',    'dot' => 'bg-blue-500',    'text' => 'text-blue-700'],
        ];
        $unreadCount = $notifications->where('is_read', false)->count();
    @endphp

    <div class="space-y-2">

        {{-- Unread banner --}}
        @if($unreadCount > 0)
        <div style="display:flex;align-items:center;gap:12px;background:rgba(255,214,10,0.10);border:1px solid rgba(255,214,10,0.30);border-radius:10px;padding:12px 20px;">
            <span style="width:8px;height:8px;border-radius:50%;background:#FFD60A;animation:pulse 2s cubic-bezier(0.4,0,0.6,1) infinite;flex-shrink:0;"></span>
            <p style="font-size:0.875rem;font-weight:600;color:#0d1b2e;">
                {{ $unreadCount }} unread notification{{ $unreadCount > 1 ? 's' : '' }}
            </p>
        </div>
        @endif

        {{-- Notification list --}}
        @forelse($notifications as $n)
        @php $c = $typeColors[$n->type] ?? $typeColors['info']; @endphp
        <div wire:key="notif-{{ $n->id }}"
             class="flex items-start gap-4 p-4 rounded-xl border {{ $n->is_read ? 'bg-white border-[#e4e9f0]' : $c['bg'] . ' border ' . $c['border'] }}"
             style="transition:opacity 150ms ease;{{ $n->is_read ? 'opacity:0.58;' : '' }}">

            {{-- Status dot --}}
            <div class="mt-1.5 flex-shrink-0">
                <span class="rounded-full block {{ $n->is_read ? 'bg-slate-300' : $c['dot'] }}"
                      style="width:8px;height:8px;"></span>
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p style="font-size:0.875rem;font-weight:600;color:{{ $n->is_read ? '#8898aa' : '#0d1b2e' }};">
                            {{ $n->title }}
                        </p>
                        @if($n->description)
                        <p style="font-size:0.8125rem;color:#5a6a7e;margin-top:2px;">{{ $n->description }}</p>
                        @endif
                        @if($n->link)
                        <a href="{{ $n->link }}"
                           style="font-size:0.8125rem;color:#0a1628;font-weight:500;text-decoration:none;display:inline-block;margin-top:4px;transition:opacity 120ms ease;"
                           onmouseover="this.style.opacity='0.65'" onmouseout="this.style.opacity='1'">
                            View &rarr;
                        </a>
                        @endif
                    </div>
                    <span style="font-size:0.75rem;color:#8898aa;flex-shrink:0;white-space:nowrap;">
                        {{ $n->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                @if(! $n->is_read)
                <button wire:click="markRead({{ $n->id }})"
                        title="Mark as read"
                        style="color:#cbd5e1;transition:color 120ms ease;padding:3px;"
                        onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#cbd5e1'">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
                @endif
                <button wire:click="deleteNotification({{ $n->id }})"
                        wire:confirm="Remove this notification?"
                        title="Delete"
                        style="color:#cbd5e1;transition:color 120ms ease;padding:3px;"
                        onmouseover="this.style.color='#f43f5e'" onmouseout="this.style.color='#cbd5e1'">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        @empty
        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:80px 24px;color:#8898aa;">
            <svg style="width:40px;height:40px;margin-bottom:12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <p style="font-size:0.9375rem;font-weight:600;color:#0d1b2e;margin-bottom:4px;">All caught up</p>
            <p style="font-size:0.8125rem;color:#8898aa;">No notifications to show</p>
        </div>
        @endforelse
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
