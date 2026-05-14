<x-crm::layout title="Leads">
<div class="crm-page-header">
    <div>
        <h1 class="crm-page-title">Leads</h1>
        <p class="crm-page-subtitle">All prospects — website forms, calls, referrals, manual entries</p>
    </div>
    <a href="{{ route('crm.leads.create') }}" class="crm-btn crm-btn-primary">
        <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Lead
    </a>
</div>

{{-- Stats row --}}
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:0;margin-bottom:1.5rem;background:#fff;border:1px solid var(--crm-border,#e4e9f0);border-radius:12px;overflow:hidden;box-shadow:0 1px 3px rgba(13,27,46,0.04);">
    @php
        $statItems = [
            ['label'=>'Total',         'val'=>$stats['total'],     'color'=>''],
            ['label'=>'New',           'val'=>$stats['new'],       'color'=>'color:#175cd3;'],
            ['label'=>'Contacted',     'val'=>$stats['contacted'], 'color'=>'color:#b54708;'],
            ['label'=>'Qualified',     'val'=>$stats['qualified'], 'color'=>'color:#6941c6;'],
            ['label'=>'Converted',     'val'=>$stats['converted'], 'color'=>'color:#12b76a;'],
        ];
    @endphp
    @foreach($statItems as $i => $s)
    <div style="padding:1.125rem 1.25rem;border-right:{{ $i < 4 ? '1px solid var(--crm-border,#e4e9f0)' : 'none' }};">
        <div style="font-size:0.6875rem;font-weight:600;color:var(--crm-text-3,#8898aa);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.25rem;">{{ $s['label'] }}</div>
        <div style="font-size:1.625rem;font-weight:700;letter-spacing:-0.04em;{{ $s['color'] }}">{{ $s['val'] }}</div>
    </div>
    @endforeach
</div>

<div class="crm-table-wrap">
    <div class="crm-table-toolbar">
        <form method="GET" style="display:contents;">
            <div class="crm-search">
                <svg class="crm-search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name, email, phone, company…">
            </div>
            <select name="status" class="crm-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(array_keys(\App\Models\Lead::statusOptions()) as $s)
                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
            </select>
            <select name="source" class="crm-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Sources</option>
                @foreach(\App\Models\Lead::sourceOptions() as $key => $label)
                <option value="{{ $key }}" {{ request('source')===$key?'selected':'' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="crm-btn crm-btn-secondary crm-btn-sm">Search</button>
        </form>
    </div>

    <table class="crm-table">
        <thead>
            <tr>
                <th>Lead</th>
                <th>Contact</th>
                <th>Services</th>
                <th>Source</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Date</th>
                <th>Next Action</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($leads as $lead)
        @php
            $days = $lead->created_at->diffInDays();
            $nextAction = match(true) {
                in_array($lead->status, ['Converted','Closed'])                                  => '— Done',
                $lead->status === 'New' && $lead->priority === 'Urgent'                          => '🔴 Call immediately',
                $lead->status === 'New' && $lead->priority === 'High'                            => '📞 Call today',
                $lead->status === 'New' && $days > 2                                             => '📧 Overdue outreach',
                $lead->status === 'New'                                                           => '📧 Reach out',
                $lead->status === 'Contacted' && $days > 3                                       => '⏰ Follow up now',
                $lead->status === 'Contacted'                                                     => '✔ Qualify lead',
                $lead->status === 'Qualified'                                                     => '📄 Send proposal',
                $lead->status === 'Proposal Sent' && $lead->updated_at->diffInDays() > 5        => '⏰ Chase decision',
                $lead->status === 'Proposal Sent'                                                => '⏳ Awaiting decision',
                default                                                                           => '—',
            };
            $naCls = match(true) {
                str_contains($nextAction,'🔴') || str_contains($nextAction,'⏰') => 'crm-badge-danger',
                str_contains($nextAction,'📞') || str_contains($nextAction,'⏳') => 'crm-badge-warning',
                str_contains($nextAction,'📄') || str_contains($nextAction,'✔')  => 'crm-badge-info',
                str_contains($nextAction,'📧')                                   => 'crm-badge-neutral',
                default                                                          => 'crm-badge-neutral',
            };
            $srcColors = ['website'=>'crm-badge-info','call'=>'crm-badge-success','referral'=>'crm-badge-warning','email'=>'crm-badge-neutral','social'=>'crm-badge-warning','manual'=>'crm-badge-neutral'];
            $priColors = ['Urgent'=>'crm-badge-danger','High'=>'crm-badge-warning','Normal'=>'crm-badge-neutral','Low'=>'crm-badge-neutral'];
            $stColors  = ['New'=>'crm-badge-info','Contacted'=>'crm-badge-warning','Qualified'=>'crm-badge-info','Proposal Sent'=>'crm-badge-warning','Converted'=>'crm-badge-success','Closed'=>'crm-badge-neutral'];
        @endphp
        <tr onclick="window.location='{{ route('crm.leads.show', $lead) }}'" style="cursor:pointer;">
            <td>
                <div style="font-weight:600;font-size:0.875rem;color:var(--crm-text-1);">{{ $lead->name }}</div>
                @if($lead->company)<div style="font-size:0.75rem;color:var(--crm-text-3);">{{ $lead->company }}</div>@endif
                <div style="font-family:monospace;font-size:0.6875rem;color:var(--crm-text-3);">{{ $lead->lead_id }}</div>
            </td>
            <td>
                <div style="font-size:0.8125rem;color:var(--crm-text-2);">{{ $lead->email ?? '—' }}</div>
                <div style="font-size:0.75rem;color:var(--crm-text-3);">{{ $lead->phone ?? '' }}</div>
            </td>
            <td>
                @if($lead->services_interested)
                <div style="display:flex;flex-wrap:wrap;gap:0.25rem;">
                    @foreach(array_slice($lead->services_interested, 0, 3) as $svc)
                    <span style="font-size:0.6875rem;background:#f0f2f5;color:var(--crm-text-2);padding:0.125rem 0.5rem;border-radius:999px;white-space:nowrap;">{{ $svc }}</span>
                    @endforeach
                    @if(count($lead->services_interested) > 3)
                    <span style="font-size:0.6875rem;color:var(--crm-text-3);">+{{ count($lead->services_interested)-3 }}</span>
                    @endif
                </div>
                @else
                <span style="color:var(--crm-text-3);font-size:0.8125rem;">—</span>
                @endif
            </td>
            <td><span class="crm-badge {{ $srcColors[$lead->source] ?? 'crm-badge-neutral' }}">{{ \App\Models\Lead::sourceOptions()[$lead->source] ?? $lead->source }}</span></td>
            <td>
                @if($lead->priority)
                <span class="crm-badge {{ $priColors[$lead->priority] ?? 'crm-badge-neutral' }}">{{ $lead->priority }}</span>
                @else<span style="color:var(--crm-text-3);">—</span>@endif
            </td>
            <td><span class="crm-badge {{ $stColors[$lead->status] ?? 'crm-badge-neutral' }}">{{ $lead->status }}</span></td>
            <td style="font-size:0.75rem;color:var(--crm-text-3);white-space:nowrap;">{{ $lead->created_at->format('d M Y') }}</td>
            <td><span class="crm-badge {{ $naCls }}" style="white-space:nowrap;">{{ $nextAction }}</span></td>
            <td onclick="event.stopPropagation()">
                @if($lead->status !== 'Converted')
                <div x-data="{ open: false }" style="display:inline;">
                    <button type="button" class="crm-btn crm-btn-ghost crm-btn-sm" style="white-space:nowrap;" @click.stop="open=true">→ Client</button>
                    <div x-show="open" x-cloak class="crm-modal-overlay" @click.self="open=false">
                        <div class="crm-modal" @click.stop>
                            <div class="crm-modal-header">
                                <h3 class="crm-modal-title">Convert to Client</h3>
                                <button type="button" @click="open=false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                            </div>
                            <div class="crm-modal-body">
                                <div class="crm-modal-icon crm-modal-icon--success">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <p>Convert <strong>{{ $lead->name }}</strong> to a client? This will create a client record and mark the lead as Converted.</p>
                            </div>
                            <div class="crm-modal-footer">
                                <button type="button" @click="open=false" class="crm-btn crm-btn-secondary">Cancel</button>
                                <form method="POST" action="{{ route('crm.leads.convert', $lead) }}">
                                    @csrf
                                    <button type="submit" class="crm-btn crm-btn-primary">Convert to Client</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="9">
            <div class="crm-empty">
                <p class="crm-empty-title">No leads yet</p>
                <p class="crm-empty-text">Capture your first lead or wait for a website form submission</p>
                <a href="{{ route('crm.leads.create') }}" class="crm-btn crm-btn-primary crm-btn-sm" style="margin-top:0.75rem;">Add Lead</a>
            </div>
        </td></tr>
        @endforelse
        </tbody>
    </table>
    @if($leads->hasPages())<div style="padding:1rem 1.25rem;border-top:1px solid var(--crm-border);">{{ $leads->links() }}</div>@endif
</div>
</x-crm::layout>
