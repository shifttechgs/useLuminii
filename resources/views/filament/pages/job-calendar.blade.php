<x-filament-panels::page>
    @php
        $events       = $this->getCalendarEvents();
        $unscheduled  = $this->getUnscheduledJobs();
        $statusColors = [
            'New'        => ['bg' => 'bg-slate-100',   'text' => 'text-slate-700',   'dot' => 'bg-slate-500'],
            'Scheduled'  => ['bg' => 'bg-blue-50',     'text' => 'text-blue-700',    'dot' => 'bg-blue-500'],
            'InProgress' => ['bg' => 'bg-amber-50',    'text' => 'text-amber-700',   'dot' => 'bg-amber-500'],
            'Completed'  => ['bg' => 'bg-emerald-50',  'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
            'Cancelled'  => ['bg' => 'bg-rose-50',     'text' => 'text-rose-600',    'dot' => 'bg-rose-400'],
        ];
    @endphp

    {{-- Legend --}}
    <div class="flex flex-wrap gap-2 mb-2">
        @foreach($statusColors as $label => $c)
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold {{ $c['bg'] }} {{ $c['text'] }}" style="font-size:0.6875rem;letter-spacing:0.02em;">
            <span class="rounded-full {{ $c['dot'] }}" style="width:6px;height:6px;flex-shrink:0;"></span>
            {{ $label }}
        </span>
        @endforeach
        <span class="ml-auto text-xs self-center" style="color:#8898aa;">
            {{ \App\Models\ScheduledJob::count() }} job(s) scheduled
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">

        {{-- FullCalendar --}}
        <div class="lg:col-span-3" style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:20px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
            <div id="crm-calendar"></div>
        </div>

        {{-- Sidebar --}}
        <div class="flex flex-col gap-4">

            {{-- Unscheduled Jobs --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:20px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
                <h3 style="font-size:0.875rem;font-weight:650;color:#0d1b2e;margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                    <span style="width:7px;height:7px;border-radius:50%;background:#f43f5e;animation:pulse 2s cubic-bezier(0.4,0,0.6,1) infinite;flex-shrink:0;"></span>
                    Unscheduled Jobs ({{ count($unscheduled) }})
                </h3>

                @forelse($unscheduled as $job)
                @php $c = $statusColors[$job->job_status] ?? $statusColors['New']; @endphp
                <div style="margin-bottom:10px;padding:10px 12px;border-radius:8px;border:1px solid #eef1f6;background:#fafbfd;">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;">
                        <div style="min-width:0;">
                            <p style="font-size:0.8125rem;font-weight:600;color:#0d1b2e;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $job->job_title ?? 'Untitled' }}</p>
                            <p style="font-size:0.75rem;color:#8898aa;margin-top:2px;">
                                {{ optional($job->client)->firstname }} {{ optional($job->client)->lastname }}
                            </p>
                            <span class="inline-flex items-center gap-1 mt-1 {{ $c['text'] }}" style="font-size:0.75rem;font-weight:500;">
                                <span class="rounded-full {{ $c['dot'] }}" style="width:5px;height:5px;flex-shrink:0;"></span>
                                {{ $job->job_status }}
                            </span>
                        </div>
                        <a href="{{ route('filament.admin.resources.jobs.view', $job) }}"
                           style="flex-shrink:0;color:#8898aa;transition:color 120ms ease;margin-top:2px;"
                           onmouseover="this.style.color='#0a1628'" onmouseout="this.style.color='#8898aa'">
                            <svg style="width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                    <p style="font-size:0.6875rem;color:#8898aa;margin-top:4px;font-family:ui-monospace,monospace;">{{ $job->job_id }}</p>
                </div>
                @empty
                <p style="font-size:0.8125rem;color:#8898aa;padding:12px 0;text-align:center;">All jobs are scheduled</p>
                @endforelse
            </div>

            {{-- This Week --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:20px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
                <h3 style="font-size:0.875rem;font-weight:650;color:#0d1b2e;margin-bottom:12px;">This Week</h3>
                @php
                    $weekJobs  = \App\Models\ScheduledJob::whereBetween('scheduled_date', [now()->startOfWeek(), now()->endOfWeek()])->count();
                    $todayJobs = \App\Models\ScheduledJob::whereDate('scheduled_date', today())->count();
                @endphp
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eef1f6;">
                    <span style="font-size:0.8125rem;color:#5a6a7e;">Today</span>
                    <span style="font-size:1rem;font-weight:700;color:#0d1b2e;letter-spacing:-0.03em;">{{ $todayJobs }}</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;">
                    <span style="font-size:0.8125rem;color:#5a6a7e;">This Week</span>
                    <span style="font-size:1rem;font-weight:700;color:#0d1b2e;letter-spacing:-0.03em;">{{ $weekJobs }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Event Detail Modal --}}
    <div id="eventModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal()"></div>
        <div style="position:relative;background:#fff;border-radius:16px;box-shadow:0 8px 32px rgba(13,27,46,0.12);border:1px solid #e4e9f0;padding:24px;width:100%;max-width:420px;z-index:10;">
            <button onclick="closeModal()"
                    style="position:absolute;top:16px;right:16px;color:#8898aa;transition:color 120ms ease;padding:4px;"
                    onmouseover="this.style.color='#0d1b2e'" onmouseout="this.style.color='#8898aa'">
                <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <h3 id="modal-title" style="font-size:1rem;font-weight:700;color:#0d1b2e;margin-bottom:16px;padding-right:32px;letter-spacing:-0.02em;"></h3>
            <div class="space-y-0 text-sm" id="modal-body"></div>
            <div style="margin-top:20px;display:flex;gap:10px;">
                <a id="modal-link" href="#"
                   style="flex:1;text-align:center;padding:8px 16px;background:#0a1628;color:#fff;font-size:0.875rem;font-weight:600;border-radius:6px;text-decoration:none;transition:background 150ms ease;"
                   onmouseover="this.style.background='#0f2040'" onmouseout="this.style.background='#0a1628'">
                    View Job &rarr;
                </a>
                <button onclick="closeModal()"
                        style="flex:1;padding:8px 16px;border:1px solid #e4e9f0;color:#5a6a7e;font-size:0.875rem;font-weight:500;border-radius:6px;background:#fff;cursor:pointer;transition:background 150ms ease;"
                        onmouseover="this.style.background='#f4f6f9'" onmouseout="this.style.background='#fff'">
                    Close
                </button>
            </div>
        </div>
    </div>

    {{-- FullCalendar --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <style>
        .fc .fc-button-primary { background:#0a1628 !important; border-color:#0a1628 !important; font-size:0.8125rem !important; font-weight:500 !important; border-radius:6px !important; }
        .fc .fc-button-primary:hover { background:#0f2040 !important; border-color:#0f2040 !important; }
        .fc .fc-button-primary:not(:disabled).fc-button-active { background:#FFD60A !important; border-color:#FFD60A !important; color:#0a1628 !important; }
        .fc .fc-toolbar-title { font-size:1rem !important; font-weight:700 !important; color:#0d1b2e !important; letter-spacing:-0.02em !important; }
        .fc th { font-size:0.75rem !important; font-weight:600 !important; color:#5a6a7e !important; text-transform:uppercase !important; letter-spacing:0.05em !important; }
        .fc .fc-daygrid-day-number { font-size:0.8125rem !important; color:#5a6a7e !important; }
        .fc .fc-day-today { background:rgba(255,214,10,0.07) !important; }
        .fc .fc-day-today .fc-daygrid-day-number { color:#0a1628 !important; font-weight:700 !important; }
    </style>

    <script>
        function closeModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }

        function initCalendar() {
            const el = document.getElementById('crm-calendar');
            if (!el || window._crmCalendar) return;

            window._crmCalendar = new FullCalendar.Calendar(el, {
                initialView:    'dayGridMonth',
                headerToolbar: { left:'prev,next today', center:'title', right:'dayGridMonth,timeGridWeek,timeGridDay,listWeek' },
                height:         'auto',
                nowIndicator:   true,
                editable:       false,
                events:         @json(json_decode($events)),
                eventClick: function(info) {
                    const p   = info.event.extendedProps;
                    const fmt = d => d ? new Date(d).toLocaleString('en-ZA', { dateStyle:'medium', timeStyle:'short' }) : '—';
                    const row = (label, val) => `<div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eef1f6;font-size:0.875rem;"><span style="color:#8898aa;">${label}</span><span style="font-weight:600;color:#0d1b2e;">${val}</span></div>`;

                    document.getElementById('modal-title').textContent = info.event.title;
                    document.getElementById('modal-body').innerHTML =
                        row('Status', p.status ?? '—') +
                        row('Client', p.client ?? '—') +
                        row('Assigned To', p.member ?? 'Unassigned') +
                        row('Start', fmt(info.event.start)) +
                        row('End', fmt(info.event.end)) +
                        `<div style="display:flex;justify-content:space-between;padding:8px 0;font-size:0.875rem;"><span style="color:#8898aa;">Location</span><span style="font-weight:600;color:#0d1b2e;">${p.location ?? '—'}</span></div>`;
                    document.getElementById('modal-link').href = '/useluminii/jobs/' + p.jobId;
                    document.getElementById('eventModal').classList.remove('hidden');
                },
                eventDidMount: function(info) {
                    info.el.style.borderRadius = '5px';
                    info.el.style.fontSize     = '11px';
                    info.el.style.fontWeight   = '600';
                    info.el.style.cursor       = 'pointer';
                    info.el.style.padding      = '2px 5px';
                },
            });

            window._crmCalendar.render();
        }

        document.addEventListener('DOMContentLoaded', initCalendar);
        document.addEventListener('livewire:navigated', () => {
            if (window._crmCalendar) { window._crmCalendar.destroy(); delete window._crmCalendar; }
            initCalendar();
        });
    </script>

    <x-filament-actions::modals />
</x-filament-panels::page>
