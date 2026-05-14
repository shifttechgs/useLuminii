<x-filament-panels::page>
@php
    $columns       = $this->getColumns();
    $leadsByStatus = $this->getLeads();

    $priorityBorder = [
        'Low'    => '#e2e8f0',
        'Normal' => '#2e90fa',
        'High'   => '#f79009',
        'Urgent' => '#f04438',
    ];

    $totalByStatus = [];
    foreach ($leadsByStatus as $status => $cards) {
        $totalByStatus[$status] = array_sum(array_column($cards, 'budget'));
    }
@endphp

<style>
.pl-card { transition: box-shadow 140ms ease, transform 140ms ease; }
.pl-card:hover { box-shadow: 0 8px 24px rgba(13,27,46,0.10) !important; transform: translateY(-1px); }
.pl-actions { opacity: 0; transition: opacity 120ms; }
.pl-card:hover .pl-actions { opacity: 1; }
.pl-next { opacity: 0; pointer-events: none; transition: opacity 120ms; }
.pl-card:hover .pl-next { opacity: 1; pointer-events: auto; }
</style>

{{-- Page Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <p style="font-size:0.8125rem;color:#8898aa;margin:0;">
            {{ array_sum(array_map('count', $leadsByStatus)) }} active leads
            @php $totalPipeline = array_sum($totalByStatus); @endphp
            @if($totalPipeline > 0)
            &nbsp;·&nbsp; R {{ number_format($totalPipeline, 0) }} pipeline value
            @endif
        </p>
    </div>
    <a href="{{ route('filament.admin.resources.leads.create') }}"
       style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;background:#0a1628;color:#fff;font-size:0.8125rem;font-weight:600;border-radius:6px;text-decoration:none;letter-spacing:0.01em;transition:background 120ms ease;"
       onmouseover="this.style.background='#0f2040'" onmouseout="this.style.background='#0a1628'">
        <svg style="width:13px;height:13px;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        New Lead
    </a>
</div>

{{-- Kanban Board --}}
<div style="display:flex;gap:16px;overflow-x:auto;padding-bottom:24px;min-height:72vh;align-items:flex-start;">

    @foreach($columns as $status => $col)
    @php
        $cards     = $leadsByStatus[$status] ?? [];
        $colTotal  = $totalByStatus[$status] ?? 0;
        $cardCount = count($cards);
    @endphp

    <div style="flex-shrink:0;width:264px;display:flex;flex-direction:column;"
         x-data
         @dragover.prevent
         @drop="$wire.moveCard($event.dataTransfer.getData('leadId'), '{{ $status }}')">

        {{-- Column Header --}}
        <div style="margin-bottom:10px;padding:10px 12px;background:#fff;border-radius:8px;border:1px solid #e8edf2;">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:{{ $col['color'] }};flex-shrink:0;display:inline-block;"></span>
                    <span style="font-size:0.6875rem;font-weight:700;color:#0d1b2e;letter-spacing:0.04em;text-transform:uppercase;">
                        {{ $col['label'] }}
                    </span>
                    <span style="font-size:0.625rem;font-weight:700;color:#8898aa;">{{ $cardCount }}</span>
                </div>
                @if($colTotal > 0)
                <span style="font-size:0.6875rem;font-weight:600;color:#5a6a7e;">
                    R {{ number_format($colTotal, 0) }}
                </span>
                @endif
            </div>
        </div>

        {{-- Cards --}}
        <div style="display:flex;flex-direction:column;gap:8px;flex:1;">
            @forelse($cards as $card)
            @php
                $leadId   = $card['lead_id'] ?? '';
                $name     = $card['name'] ?? '';
                $email    = $card['email'] ?? '';
                $company  = $card['company'] ?? '';
                $priority = $card['priority'] ?? 'Normal';
                $budget   = $card['budget'] ?? null;
                $created  = $card['created_at'] ? \Carbon\Carbon::parse($card['created_at']) : null;
                $pb       = $priorityBorder[$priority] ?? '#2e90fa';
                $ageDays  = $created ? $created->diffInDays(now()) : 0;
                $isStale  = $ageDays > 3 && in_array($status, ['New', 'Contacted']);

                // Next Action
                $nextAction = match(true) {
                    in_array($status, ['Converted', 'Closed'])   => null,
                    $status === 'New' && $priority === 'Urgent'  => ['label' => 'Call immediately', 'color' => '#b42318', 'bg' => '#fef3f2'],
                    $status === 'New' && $priority === 'High'    => ['label' => 'Call today',       'color' => '#b54708', 'bg' => '#fffaeb'],
                    $status === 'New' && $ageDays > 2            => ['label' => 'Overdue outreach', 'color' => '#b42318', 'bg' => '#fef3f2'],
                    $status === 'New'                             => ['label' => 'Reach out',        'color' => '#1849a9', 'bg' => '#eff8ff'],
                    $status === 'Contacted' && $ageDays > 3      => ['label' => 'Follow up now',    'color' => '#b42318', 'bg' => '#fef3f2'],
                    $status === 'Contacted'                       => ['label' => 'Qualify lead',     'color' => '#5b21b6', 'bg' => '#f5f3ff'],
                    $status === 'Qualified'                       => ['label' => 'Send proposal',    'color' => '#027a48', 'bg' => '#ecfdf3'],
                    $status === 'Proposal Sent' && $ageDays > 5  => ['label' => 'Chase decision',   'color' => '#b42318', 'bg' => '#fef3f2'],
                    $status === 'Proposal Sent'                   => ['label' => 'Awaiting decision','color' => '#b54708', 'bg' => '#fffaeb'],
                    default                                       => null,
                };

                // Next stage
                $stageOrder   = array_keys($columns);
                $currentIdx   = array_search($status, $stageOrder);
                $nextStage    = ($currentIdx !== false && isset($stageOrder[$currentIdx + 1])) ? $stageOrder[$currentIdx + 1] : null;
                $nextStageLbl = $nextStage ? $columns[$nextStage]['label'] : null;
                $nextStageCl  = $nextStage ? $columns[$nextStage]['color'] : null;

                // Assignee
                $assignee = is_array($card['assigned_to'] ?? null) ? ($card['assigned_to']['name'] ?? null) : null;
            @endphp

            <div class="pl-card"
                 style="background:#fff;border-radius:10px;border:1px solid #e8edf2;border-left:3px solid {{ $pb }};padding:14px 15px 12px;cursor:grab;box-shadow:0 1px 3px rgba(13,27,46,0.04);position:relative;"
                 draggable="true"
                 @dragstart="$event.dataTransfer.setData('leadId', '{{ $leadId }}')">

                {{-- Name row + hover edit --}}
                <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:3px;">
                    <p style="font-size:0.875rem;font-weight:700;color:#0d1b2e;line-height:1.3;margin:0;flex:1;padding-right:6px;">{{ $name }}</p>
                    <div class="pl-actions" style="display:flex;gap:2px;flex-shrink:0;margin-top:1px;">
                        <a href="{{ route('filament.admin.resources.leads.edit', $leadId) }}"
                           style="color:#c8d0db;padding:3px;border-radius:4px;display:flex;align-items:center;transition:color 100ms;"
                           onmouseover="this.style.color='#0d1b2e'" onmouseout="this.style.color='#c8d0db'">
                            <svg style="width:12px;height:12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Company or email --}}
                @if($company || $email)
                <p style="font-size:0.75rem;color:#94a3b8;margin:0 0 11px;font-weight:400;line-height:1.3;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $company ?: $email }}</p>
                @else
                <div style="margin-bottom:11px;"></div>
                @endif

                {{-- Next Action chip --}}
                @if($nextAction)
                <div style="margin-bottom:11px;">
                    <span style="font-size:0.5625rem;font-weight:700;padding:3px 8px;border-radius:99px;background:{{ $nextAction['bg'] }};color:{{ $nextAction['color'] }};letter-spacing:0.04em;text-transform:uppercase;">
                        {{ $nextAction['label'] }}
                    </span>
                </div>
                @endif

                {{-- Footer: budget left, age right --}}
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    @if($budget)
                    <span style="font-size:0.75rem;font-weight:700;color:#027a48;">R {{ number_format($budget, 0) }}</span>
                    @else
                    <span></span>
                    @endif
                    <div style="display:flex;align-items:center;gap:6px;">
                        @if($assignee)
                        <span style="font-size:0.625rem;color:#c8d0db;font-weight:500;">{{ $assignee }}</span>
                        @endif
                        <span style="font-size:0.6875rem;color:{{ $isStale ? '#f04438' : '#c8d0db' }};font-weight:{{ $isStale ? '600' : '400' }};">
                            @if($created) {{ $created->diffForHumans(null, true, true) }} @endif
                        </span>
                    </div>
                </div>

                {{-- Hover: Next Stage + other moves --}}
                <div class="pl-next" style="display:flex;align-items:center;gap:5px;margin-top:10px;padding-top:10px;border-top:1px solid #f1f5f9;">
                    @if($nextStage)
                    <button wire:click="moveCard('{{ $leadId }}', '{{ $nextStage }}')"
                            style="flex:1;font-size:0.625rem;font-weight:700;padding:5px 8px;border-radius:5px;color:#fff;border:none;cursor:pointer;background:{{ $nextStageCl }};letter-spacing:0.03em;text-transform:uppercase;transition:opacity 100ms;"
                            onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                        → {{ $nextStageLbl }}
                    </button>
                    @endif
                    <div style="position:relative;" x-data="{ open: false }">
                        <button @click="open = !open"
                                style="font-size:0.75rem;padding:4px 9px;border-radius:5px;background:#f1f5f9;color:#64748b;border:none;cursor:pointer;font-weight:700;line-height:1;transition:background 100ms;"
                                onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">⋮</button>
                        <div x-show="open" @click.outside="open = false" x-transition
                             style="position:absolute;bottom:calc(100% + 6px);right:0;background:#fff;border:1px solid #e8edf2;border-radius:8px;box-shadow:0 8px 24px rgba(13,27,46,0.12);padding:4px;min-width:140px;z-index:50;">
                            @foreach($columns as $s => $c)
                                @if($s !== $status && $s !== $nextStage)
                                <button wire:click="moveCard('{{ $leadId }}', '{{ $s }}')" @click="open = false"
                                        style="display:block;width:100%;text-align:left;font-size:0.6875rem;font-weight:500;padding:6px 10px;border-radius:5px;background:none;border:none;cursor:pointer;color:#374151;transition:background 80ms;"
                                        onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='none'">
                                    <span style="color:{{ $c['color'] }};font-weight:700;">→</span> {{ $c['label'] }}
                                </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            @empty
            <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:32px 16px;border:1.5px dashed #e8edf2;border-radius:10px;color:#c8d0db;text-align:center;">
                <svg style="width:20px;height:20px;margin-bottom:6px;opacity:0.4;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span style="font-size:0.75rem;">Empty</span>
            </div>
            @endforelse
        </div>
    </div>
    @endforeach
</div>

<x-filament-actions::modals />
</x-filament-panels::page>
