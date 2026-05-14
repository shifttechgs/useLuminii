<x-crm::layout title="Lead: {{ $lead->name }}">

@php
    $stColors = ['New'=>'crm-badge-info','Contacted'=>'crm-badge-warning','Qualified'=>'crm-badge-info','Proposal Sent'=>'crm-badge-warning','Converted'=>'crm-badge-success','Closed'=>'crm-badge-neutral'];
    $priColors = ['Urgent'=>'crm-badge-danger','High'=>'crm-badge-warning','Normal'=>'crm-badge-neutral','Low'=>'crm-badge-neutral'];
    $srcLabels = \App\Models\Lead::sourceOptions();
@endphp

<div class="crm-page-header">
    <div>
        <a href="{{ route('crm.leads.index') }}" style="color:var(--crm-text-3);font-size:0.875rem;">Leads</a>
        <span style="color:var(--crm-text-3);font-size:0.875rem;"> / </span>
        <span style="font-size:0.875rem;color:var(--crm-text-2);">{{ $lead->name }}</span>
        <h1 class="crm-page-title" style="margin-top:0.25rem;">{{ $lead->name }}</h1>
        <div style="display:flex;gap:0.375rem;margin-top:0.375rem;flex-wrap:wrap;">
            <span class="crm-badge {{ $stColors[$lead->status] ?? 'crm-badge-neutral' }}">{{ $lead->status }}</span>
            @if($lead->priority)<span class="crm-badge {{ $priColors[$lead->priority] ?? 'crm-badge-neutral' }}">{{ $lead->priority }}</span>@endif
            <span class="crm-badge crm-badge-neutral">{{ $srcLabels[$lead->source] ?? $lead->source }}</span>
        </div>
    </div>
    <div x-data="{ deleteOpen: false }" style="display:flex;gap:0.5rem;flex-wrap:wrap;">
        @if($lead->status !== 'Converted')
        <form method="POST" action="{{ route('crm.leads.convert', $lead) }}">@csrf
            <button type="submit" class="crm-btn crm-btn-primary">Convert to Client</button>
        </form>
        @else
        @if($lead->converted_client_id)
        <a href="{{ route('crm.clients.show', \App\Models\BusinessClient::find($lead->converted_client_id)) }}" class="crm-btn crm-btn-secondary">View Client →</a>
        @endif
        @endif
        <button type="button" class="crm-btn crm-btn-ghost" @click="deleteOpen = true">Delete</button>

        {{-- Delete modal --}}
        <div x-show="deleteOpen" x-cloak class="crm-modal-overlay" @click.self="deleteOpen = false">
            <div class="crm-modal" @click.stop>
                <div class="crm-modal-header">
                    <h3 class="crm-modal-title">Delete Lead</h3>
                    <button type="button" @click="deleteOpen = false" class="crm-icon-btn">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="crm-modal-body">
                    <div class="crm-modal-icon crm-modal-icon--danger">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <p>Delete <strong>{{ $lead->name }}</strong>? This cannot be undone.</p>
                </div>
                <div class="crm-modal-footer">
                    <button type="button" @click="deleteOpen = false" class="crm-btn crm-btn-secondary">Cancel</button>
                    <form method="POST" action="{{ route('crm.leads.destroy', $lead) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="crm-btn crm-btn-danger">Delete Lead</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;align-items:start;">

    {{-- Left: message + notes --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        @if($lead->message)
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Message / Notes</span></div>
            <div class="crm-card-body"><p style="font-size:0.875rem;color:var(--crm-text-2);line-height:1.65;white-space:pre-wrap;">{{ $lead->message }}</p></div>
        </div>
        @endif

        @if($lead->admin_notes)
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Internal Notes</span></div>
            <div class="crm-card-body"><p style="font-size:0.875rem;color:var(--crm-text-2);line-height:1.65;white-space:pre-wrap;">{{ $lead->admin_notes }}</p></div>
        </div>
        @endif

        @if($lead->services_interested && count($lead->services_interested))
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Services Interested In</span></div>
            <div class="crm-card-body">
                <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                    @foreach($lead->services_interested as $svc)
                    <span style="padding:0.25rem 0.75rem;background:#f0f4ff;color:#3730a3;border-radius:999px;font-size:0.8125rem;font-weight:500;">{{ $svc }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Right: details sidebar --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Contact Details</span></div>
            <div class="crm-card-body" style="display:flex;flex-direction:column;gap:0.625rem;">
                <div class="crm-detail-row"><span class="crm-detail-label">Name</span><span class="crm-detail-value">{{ $lead->name }}</span></div>
                @if($lead->company)<div class="crm-detail-row"><span class="crm-detail-label">Company</span><span class="crm-detail-value">{{ $lead->company }}</span></div>@endif
                <div class="crm-detail-row"><span class="crm-detail-label">Email</span><span class="crm-detail-value">{{ $lead->email ?? '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Phone</span><span class="crm-detail-value">{{ $lead->phone ?? '—' }}</span></div>
            </div>
        </div>

        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Lead Details</span></div>
            <div class="crm-card-body" style="display:flex;flex-direction:column;gap:0.625rem;">
                <div class="crm-detail-row"><span class="crm-detail-label">Source</span><span class="crm-detail-value">{{ $srcLabels[$lead->source] ?? $lead->source }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Status</span><span class="crm-detail-value">{{ $lead->status }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Priority</span><span class="crm-detail-value">{{ $lead->priority ?? '—' }}</span></div>
                @if($lead->budget)<div class="crm-detail-row"><span class="crm-detail-label">Budget</span><span class="crm-detail-value">R {{ number_format($lead->budget, 0) }}</span></div>@endif
                <div class="crm-detail-row"><span class="crm-detail-label">Assigned To</span><span class="crm-detail-value">{{ $lead->assignedTo?->name ?? '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Received</span><span class="crm-detail-value">{{ $lead->created_at->format('d M Y H:i') }}</span></div>
                @if($lead->contacted_at)<div class="crm-detail-row"><span class="crm-detail-label">Contacted</span><span class="crm-detail-value">{{ $lead->contacted_at->format('d M Y H:i') }}</span></div>@endif
            </div>
        </div>

        @if($lead->status !== 'Converted')
        <a href="{{ route('crm.requests.create', ['from_lead' => $lead->lead_id]) }}" class="crm-btn crm-btn-secondary" style="width:100%;justify-content:center;text-align:center;">
            Create Request for this Lead
        </a>
        @endif
    </div>
</div>

</x-crm::layout>
