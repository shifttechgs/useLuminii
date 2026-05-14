<x-crm::layout title="{{ $job->job_id }}">

<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.jobs.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Jobs</a>
            <span style="color:var(--color-ink-3);">/</span>
            <span style="font-size:0.875rem;">{{ $job->job_id }}</span>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <h1 class="crm-page-title">{{ $job->job_title }}</h1>
            @include('crm.partials.job-badge', ['status' => $job->job_status])
        </div>
    </div>
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
        @if($job->job_status === 'Completed' && !$job->invoice)
        <form method="POST" action="{{ route('crm.jobs.create-invoice', $job) }}">@csrf
            <button type="submit" class="crm-btn crm-btn-secondary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Create Invoice
            </button>
        </form>
        @endif
        @if($job->invoice)
        <a href="{{ route('crm.invoices.show', $job->invoice) }}" class="crm-btn crm-btn-secondary">View Invoice</a>
        @endif
        <a href="{{ route('crm.jobs.edit', $job) }}" class="crm-btn crm-btn-primary">Edit Job</a>
    </div>
</div>

{{-- Status Quick-update --}}
<div class="crm-card" style="margin-bottom:1.25rem;">
    <div class="crm-card-body" style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
        <span style="font-size:0.875rem;font-weight:500;color:var(--color-ink-2);">Update Status:</span>
        @foreach(['New','Scheduled','InProgress','Completed','Cancelled'] as $s)
        <form method="POST" action="{{ route('crm.jobs.status', $job) }}" style="margin:0;">
            @csrf
            <input type="hidden" name="status" value="{{ $s }}">
            <button type="submit" class="crm-btn crm-btn-sm {{ $job->job_status === $s ? 'crm-btn-primary' : 'crm-btn-secondary' }}">{{ $s }}</button>
        </form>
        @endforeach
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;">

    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        {{-- Line Items --}}
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Job Scope / Line Items</span></div>
            <table class="crm-table">
                <thead><tr><th>Description</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead>
                <tbody>
                @forelse($job->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>R {{ number_format($item->unit_price, 2) }}</td>
                    <td style="font-weight:600;">R {{ number_format($item->line_total, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="crm-empty" style="padding:1.25rem;"><p class="crm-empty-text">No line items</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
            @if($job->items->count() > 0)
            <div class="crm-card-footer">
                <div style="margin-left:auto;min-width:200px;">
                    <div class="crm-detail-row" style="font-weight:700;font-size:1rem;">
                        <span class="crm-detail-label" style="font-weight:700;color:var(--color-ink-1);">Total</span>
                        <span class="crm-detail-value">R {{ number_format($job->items->sum('line_total'), 2) }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if($job->instructions)
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Instructions</span></div>
            <div class="crm-card-body"><p style="font-size:0.875rem;color:var(--color-ink-2);line-height:1.6;white-space:pre-wrap;">{{ $job->instructions }}</p></div>
        </div>
        @endif

        @if($job->job_notes)
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Job Notes</span><span class="crm-badge crm-badge-warning">Internal</span></div>
            <div class="crm-card-body"><p style="font-size:0.875rem;color:var(--color-ink-2);line-height:1.6;white-space:pre-wrap;">{{ $job->job_notes }}</p></div>
        </div>
        @endif

        {{-- Linked Invoice --}}
        @if($job->invoice)
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Linked Invoice</span><a href="{{ route('crm.invoices.show', $job->invoice) }}" class="crm-btn crm-btn-secondary crm-btn-sm">View</a></div>
            <div class="crm-card-body">
                <div class="crm-detail-row"><span class="crm-detail-label">Invoice ID</span><span class="crm-detail-value crm-mono">{{ $job->invoice->invoice_id }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Amount</span><span class="crm-detail-value">R {{ number_format($job->invoice->total_amount, 2) }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Status</span><span class="crm-detail-value">@include('crm.partials.invoice-badge', ['status' => $job->invoice->status])</span></div>
            </div>
        </div>
        @endif
    </div>

    {{-- Right --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Details</span></div>
            <div class="crm-card-body">
                <div class="crm-detail-row"><span class="crm-detail-label">Job ID</span><span class="crm-detail-value crm-mono">{{ $job->job_id }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Client</span><span class="crm-detail-value"><a href="{{ route('crm.clients.show', $job->client) }}" style="color:var(--color-info-text);">{{ $job->client->full_name ?? '—' }}</a></span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Assigned To</span><span class="crm-detail-value">{{ $job->assignedTo->name ?? '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Scheduled</span><span class="crm-detail-value">{{ $job->job_date_time ? $job->job_date_time->format('d M Y H:i') : '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Scheduled Status</span><span class="crm-detail-value">{{ $job->scheduled_status ?? '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Assigned Status</span><span class="crm-detail-value">{{ $job->assigned_status ?? '—' }}</span></div>
                @if($job->quote)
                <div class="crm-detail-row"><span class="crm-detail-label">From Quote</span><span class="crm-detail-value"><a href="{{ route('crm.quotes.show', $job->quote) }}" style="color:var(--color-info-text);">{{ $job->quote->quote_id }}</a></span></div>
                @endif
            </div>
        </div>

        @if($job->scheduledJob)
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Calendar Entry</span></div>
            <div class="crm-card-body">
                <div class="crm-detail-row"><span class="crm-detail-label">Date</span><span class="crm-detail-value">{{ \Carbon\Carbon::parse($job->scheduledJob->scheduled_date)->format('d M Y H:i') }}</span></div>
                @if($job->scheduledJob->scheduled_end)
                <div class="crm-detail-row"><span class="crm-detail-label">End</span><span class="crm-detail-value">{{ \Carbon\Carbon::parse($job->scheduledJob->scheduled_end)->format('d M Y H:i') }}</span></div>
                @endif
                <div class="crm-detail-row"><span class="crm-detail-label">Location</span><span class="crm-detail-value">{{ $job->scheduledJob->location ?? '—' }}</span></div>
                <div class="crm-detail-row"><span class="crm-detail-label">Type</span><span class="crm-detail-value">{{ $job->scheduledJob->job_type ?? '—' }}</span></div>
            </div>
        </div>
        @else
        <a href="{{ route('crm.calendar') }}" class="crm-btn crm-btn-secondary" style="width:100%;justify-content:center;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Schedule on Calendar
        </a>
        @endif

        <div class="crm-card" x-data="{ deleteOpen: false }">
            <div class="crm-card-body">
                <button type="button" @click="deleteOpen = true" class="crm-btn crm-btn-danger" style="width:100%;">Delete Job</button>
            </div>
            <div x-show="deleteOpen" x-cloak class="crm-modal-overlay" @click.self="deleteOpen = false">
                <div class="crm-modal" @click.stop>
                    <div class="crm-modal-header">
                        <h3 class="crm-modal-title">Delete Job</h3>
                        <button type="button" @click="deleteOpen = false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <div class="crm-modal-body">
                        <div class="crm-modal-icon crm-modal-icon--danger">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </div>
                        <p>Are you sure you want to delete <strong>{{ $job->job_id }}</strong>? This action cannot be undone.</p>
                    </div>
                    <div class="crm-modal-footer">
                        <button type="button" @click="deleteOpen = false" class="crm-btn crm-btn-secondary">Cancel</button>
                        <form method="POST" action="{{ route('crm.jobs.destroy', $job) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="crm-btn crm-btn-danger">Delete Job</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</x-crm::layout>

