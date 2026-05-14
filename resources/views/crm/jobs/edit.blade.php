<x-crm::layout title="Edit Job">
<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.jobs.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Jobs</a>
            <span style="color:var(--color-ink-3);">/</span>
            <a href="{{ route('crm.jobs.show', $job) }}" style="color:var(--color-ink-3);font-size:0.875rem;">{{ $job->job_id }}</a>
            <span style="color:var(--color-ink-3);">/</span><span style="font-size:0.875rem;">Edit</span>
        </div>
        <h1 class="crm-page-title">Edit Job</h1>
    </div>
    <a href="{{ route('crm.jobs.show', $job) }}" class="crm-btn crm-btn-secondary">View Job</a>
</div>

<form method="POST" action="{{ route('crm.jobs.update', $job) }}">
@csrf @method('PUT')
<div style="display:grid;grid-template-columns:1fr 300px;gap:1.25rem;">
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Job Details</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Client</label>
                    <p style="font-size:0.875rem;font-weight:500;padding:0.5rem 0;">{{ $job->client->full_name }}</p>
                </div>
                @if($job->quote)
                <div style="grid-column:1/-1;display:flex;align-items:center;gap:0.75rem;padding:0.625rem 0.875rem;background:var(--color-surface-2);border-radius:var(--radius-sm);border:1px solid var(--color-border);">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;color:var(--color-info-text);flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span style="font-size:0.8125rem;color:var(--color-ink-2);">Converted from quote</span>
                    <a href="{{ route('crm.quotes.show', $job->quote) }}" style="font-size:0.8125rem;font-weight:600;font-family:monospace;color:var(--color-info-text);">{{ $job->quote->quote_id }}</a>
                    <span style="font-size:0.8125rem;color:var(--color-ink-3);">— {{ $job->quote->job_title }}</span>
                </div>
                @endif
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Job Title <span style="color:var(--color-danger);">*</span></label>
                    <input type="text" name="job_title" value="{{ old('job_title', $job->job_title) }}" class="crm-input" required>
                </div>
                <div>
                    <label class="crm-label">Assign To</label>
                    <select name="team_member_assigned_id" class="crm-select">
                        <option value="">— Unassigned —</option>
                        @foreach($team as $member)
                        <option value="{{ $member->id }}" {{ old('team_member_assigned_id', $job->team_member_assigned_id)==$member->id?'selected':'' }}>{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Status</label>
                    <select name="job_status" class="crm-select">
                        @foreach(['New','Scheduled','InProgress','Completed','Cancelled'] as $s)
                        <option value="{{ $s }}" {{ old('job_status',$job->job_status)==$s?'selected':'' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Scheduled Date / Time</label>
                    <input type="datetime-local" name="job_date_time" value="{{ old('job_date_time', $job->job_date_time?->format('Y-m-d\TH:i')) }}" class="crm-input">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Instructions</label>
                    <textarea name="instructions" class="crm-textarea" rows="3">{{ old('instructions', $job->instructions) }}</textarea>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Internal Notes</label>
                    <textarea name="job_notes" class="crm-textarea" rows="2">{{ old('job_notes', $job->job_notes) }}</textarea>
                </div>
            </div>
        </div>
        @php
            $lineItems = old('items',
                $job->items->count() > 0
                    ? $job->items->toArray()
                    : ($job->quote && $job->quote->items->count() > 0 ? $job->quote->items->toArray() : [])
            );
            $pulledFromQuote = $job->items->count() === 0 && $job->quote && $job->quote->items->count() > 0;
        @endphp
        @if($pulledFromQuote)
        <div style="display:flex;align-items:center;gap:0.5rem;padding:0.5rem 0.875rem;background:#eff8ff;border:1px solid #b2ddff;border-radius:var(--radius-sm);font-size:0.8125rem;color:#1d4ed8;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Line items pre-filled from linked quote <strong>{{ $job->quote->quote_id }}</strong>. Save to confirm.
        </div>
        @endif
        @php $jobCurrencySymbol = \App\Models\BusinessSetup::currencySymbol($job->quote->currency ?? 'ZAR'); @endphp
        @include('crm.partials.line-items', ['items' => $lineItems, 'currencySymbol' => $jobCurrencySymbol])
    </div>
    <div style="display:flex;flex-direction:column;gap:0.5rem;padding-top:3.5rem;">
        <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">Save Changes</button>
        <a href="{{ route('crm.jobs.show', $job) }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
    </div>
</div>
</form>
</x-crm::layout>

