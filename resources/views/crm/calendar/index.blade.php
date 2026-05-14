<x-crm::layout title="Job Calendar">
@php
    $statusColors = [
        'New'        => ['bg' => '#eef2ff', 'text' => '#4f46e5', 'dot' => '#6366f1'],
        'Scheduled'  => ['bg' => '#eff6ff', 'text' => '#1570ef', 'dot' => '#2e90fa'],
        'InProgress' => ['bg' => '#fffbeb', 'text' => '#dc6803', 'dot' => '#f79009'],
        'Completed'  => ['bg' => '#ecfdf5', 'text' => '#039855', 'dot' => '#12b76a'],
        'Cancelled'  => ['bg' => '#fef2f2', 'text' => '#d92d20', 'dot' => '#f04438'],
    ];
@endphp

<div class="crm-page-header">
    <div>
        <h1 class="crm-page-title">Job Calendar</h1>
        <p class="crm-page-subtitle">Schedule and manage job timelines</p>
    </div>
</div>

{{-- Legend --}}
<div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.25rem;align-items:center;">
    @foreach($statusColors as $label => $c)
    <span style="display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:6px;font-size:0.6875rem;font-weight:600;letter-spacing:0.02em;background:{{ $c['bg'] }};color:{{ $c['text'] }};">
        <span style="width:6px;height:6px;border-radius:50%;background:{{ $c['dot'] }};flex-shrink:0;"></span>
        {{ $label }}
    </span>
    @endforeach
    <span style="margin-left:auto;font-size:0.75rem;color:var(--color-ink-3);">
        {{ \App\Models\ScheduledJob::count() }} job(s) scheduled
    </span>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;">

    {{-- Calendar --}}
    <div class="crm-card">
        <div class="crm-card-body" style="padding:1.25rem;">
            <div id="crm-calendar"></div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- This Week Stats --}}
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">This Week</span></div>
            <div class="crm-card-body">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--color-border);">
                    <span style="font-size:0.8125rem;color:var(--color-ink-2);">Today</span>
                    <span style="font-size:1rem;font-weight:700;color:var(--color-ink-1);letter-spacing:-0.03em;">{{ $todayJobs }}</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;">
                    <span style="font-size:0.8125rem;color:var(--color-ink-2);">This Week</span>
                    <span style="font-size:1rem;font-weight:700;color:var(--color-ink-1);letter-spacing:-0.03em;">{{ $thisWeekJobs }}</span>
                </div>
            </div>
        </div>

        {{-- Unscheduled Jobs --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title" style="display:flex;align-items:center;gap:8px;">
                    <span style="width:7px;height:7px;border-radius:50%;background:#f43f5e;flex-shrink:0;"></span>
                    Unscheduled Jobs
                </span>
                @if($unscheduled->count() > 0)
                <span class="crm-badge crm-badge-warning">{{ $unscheduled->count() }}</span>
                @endif
            </div>
            @if($unscheduled->count() > 0)
            <div style="max-height:280px;overflow-y:auto;">
                @foreach($unscheduled as $j)
                @php $sc = $statusColors[$j->job_status] ?? $statusColors['New']; @endphp
                <div style="padding:10px 12px;border-bottom:1px solid var(--color-border);">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;">
                        <div style="min-width:0;">
                            <p style="font-size:0.8125rem;font-weight:600;color:var(--color-ink-1);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $j->job_title }}</p>
                            <p style="font-size:0.75rem;color:var(--color-ink-3);margin-top:2px;">{{ $j->client->full_name ?? '—' }}</p>
                            <span style="display:inline-flex;align-items:center;gap:4px;margin-top:4px;font-size:0.75rem;font-weight:500;color:{{ $sc['text'] }};">
                                <span style="width:5px;height:5px;border-radius:50%;background:{{ $sc['dot'] }};flex-shrink:0;"></span>
                                {{ $j->job_status }}
                            </span>
                        </div>
                        <a href="{{ route('crm.jobs.show', $j) }}"
                           style="flex-shrink:0;color:var(--color-ink-3);transition:color 120ms ease;margin-top:2px;"
                           onmouseover="this.style.color='#0a1628'" onmouseout="this.style.color=''">
                            <svg style="width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                    <p style="font-size:0.6875rem;color:var(--color-ink-3);margin-top:4px;font-family:ui-monospace,monospace;">{{ $j->job_id }}</p>
                </div>
                @endforeach
            </div>
            @else
            <div class="crm-card-body"><p style="font-size:0.8125rem;color:var(--color-ink-3);text-align:center;">All jobs are scheduled</p></div>
            @endif
        </div>

        {{-- Schedule a Job --}}
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Schedule a Job</span></div>
            <form method="POST" action="{{ route('crm.calendar.schedule') }}">
            @csrf
            <div class="crm-card-body" style="display:flex;flex-direction:column;gap:0.875rem;">
                <div>
                    <label class="crm-label">Job</label>
                    <select name="job_id" class="crm-select" required>
                        <option value="">— Select Job —</option>
                        @foreach($unscheduled as $j)
                        <option value="{{ $j->job_id }}">{{ $j->job_id }} — {{ $j->job_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Assign Team Member</label>
                    <select name="team_member_id" class="crm-select">
                        <option value="">— Unassigned —</option>
                        @foreach($team as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Job Type</label>
                    <select name="job_type" class="crm-select">
                        <option value="Once-off">Once-off</option>
                        <option value="Recurring">Recurring</option>
                    </select>
                </div>
                <div>
                    <label class="crm-label">Start Date & Time <span style="color:var(--color-danger);">*</span></label>
                    <input type="datetime-local" name="scheduled_date" class="crm-input" required>
                </div>
                <div>
                    <label class="crm-label">End Date & Time</label>
                    <input type="datetime-local" name="scheduled_end" class="crm-input">
                </div>
                <div>
                    <label class="crm-label">Location</label>
                    <input type="text" name="location" class="crm-input" placeholder="Site address">
                </div>
                <div>
                    <label class="crm-label">Notes</label>
                    <textarea name="notes" class="crm-textarea" rows="2"></textarea>
                </div>
            </div>
            <div class="crm-card-footer">
                <button type="submit" class="crm-btn crm-btn-primary" style="width:100%;">Schedule Job</button>
            </div>
            </form>
        </div>

    </div>
</div>

{{-- Event Detail Modal --}}
<div id="eventModal" class="crm-modal-overlay" style="display:none;" onclick="closeModal()">
    <div style="position:relative;background:#fff;border-radius:16px;box-shadow:0 8px 32px rgba(13,27,46,0.12);border:1px solid var(--color-border);padding:24px;width:100%;max-width:420px;z-index:10;" onclick="event.stopPropagation()">
        <button onclick="closeModal()"
                style="position:absolute;top:16px;right:16px;background:none;border:none;cursor:pointer;padding:4px;color:var(--color-ink-3);transition:color 120ms ease;"
                onmouseover="this.style.color='var(--color-ink-1)'" onmouseout="this.style.color=''">
            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <h3 id="modal-title" style="font-size:1rem;font-weight:700;color:var(--color-ink-1);margin-bottom:16px;padding-right:32px;letter-spacing:-0.02em;"></h3>
        <div id="modal-body"></div>
        <div style="margin-top:20px;display:flex;gap:10px;">
            <a id="modal-link" href="#"
               style="flex:1;text-align:center;padding:8px 16px;background:#0a1628;color:#fff;font-size:0.875rem;font-weight:600;border-radius:6px;text-decoration:none;transition:background 150ms ease;"
               onmouseover="this.style.background='#0f2040'" onmouseout="this.style.background='#0a1628'">
                View Job &rarr;
            </a>
            <button onclick="closeModal()"
                    style="flex:1;padding:8px 16px;border:1px solid var(--color-border);color:var(--color-ink-2);font-size:0.875rem;font-weight:500;border-radius:6px;background:#fff;cursor:pointer;transition:background 150ms ease;"
                    onmouseover="this.style.background='#f4f6f9'" onmouseout="this.style.background='#fff'">
                Close
            </button>
        </div>
    </div>
</div>

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">
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
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
function closeModal() {
    document.getElementById('eventModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('crm-calendar');
    if (!el) return;

    const jobsBase = '{{ url("/luminii/jobs") }}';

    const calendar = new FullCalendar.Calendar(el, {
        initialView: 'dayGridMonth',
        headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' },
        height: 'auto',
        nowIndicator: true,
        editable: false,
        events: '{{ route('crm.calendar.events') }}',
        eventClick: function(info) {
            const p   = info.event.extendedProps;
            const fmt = d => d ? new Date(d).toLocaleString('en-ZA', { dateStyle: 'medium', timeStyle: 'short' }) : '—';
            const row = (label, val) => `<div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eef1f6;font-size:0.875rem;"><span style="color:#8898aa;">${label}</span><span style="font-weight:600;color:#0d1b2e;">${val}</span></div>`;

            document.getElementById('modal-title').textContent = info.event.title;
            document.getElementById('modal-body').innerHTML =
                row('Status', p.status ?? '—') +
                row('Client', p.client ?? '—') +
                row('Assigned To', p.member ?? 'Unassigned') +
                row('Start', fmt(info.event.start)) +
                row('End', fmt(info.event.end)) +
                `<div style="display:flex;justify-content:space-between;padding:8px 0;font-size:0.875rem;"><span style="color:#8898aa;">Location</span><span style="font-weight:600;color:#0d1b2e;">${p.location ?? '—'}</span></div>`;

            document.getElementById('modal-link').href = jobsBase + '/' + p.job_id;
            document.getElementById('eventModal').style.removeProperty('display');
        },
        eventDidMount: function(info) {
            info.el.style.borderRadius = '5px';
            info.el.style.fontSize     = '11px';
            info.el.style.fontWeight   = '600';
            info.el.style.cursor       = 'pointer';
            info.el.style.padding      = '2px 5px';
        },
    });

    calendar.render();
});
</script>
@endpush

</x-crm::layout>
