<x-crm::layout title="Jobs">

<div class="crm-page-header">
    <div><h1 class="crm-page-title">Jobs</h1><p class="crm-page-subtitle">Track and manage all service jobs</p></div>
    <a href="{{ route('crm.jobs.create') }}" class="crm-btn crm-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Job
    </a>
</div>

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="crm-stat"><span class="crm-stat-label">Total</span><span class="crm-stat-value">{{ $stats['total'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Active</span><span class="crm-stat-value" style="color:var(--color-info-text);">{{ $stats['active'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Scheduled</span><span class="crm-stat-value">{{ $stats['scheduled'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Completed</span><span class="crm-stat-value" style="color:var(--color-success-text);">{{ $stats['completed'] }}</span></div>
</div>

<div class="crm-table-wrap">
    <div class="crm-table-toolbar">
        <form method="GET" action="{{ route('crm.jobs.index') }}" style="display:contents;">
            <div class="crm-search">
                <svg class="crm-search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search jobs…">
            </div>
            <select name="status" class="crm-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(['New','Scheduled','InProgress','Completed','Cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
            </select>
            <button type="submit" class="crm-btn crm-btn-secondary crm-btn-sm">Search</button>
            @if(request('q') || request('status'))<a href="{{ route('crm.jobs.index') }}" class="crm-btn crm-btn-ghost crm-btn-sm">Clear</a>@endif
        </form>
        <span style="margin-left:auto;font-size:0.8125rem;color:var(--color-ink-3);">{{ $jobs->total() }} records</span>
    </div>
    <table class="crm-table">
        <thead><tr><th>Job ID</th><th>Title</th><th>Client</th><th>Assigned To</th><th>Status</th><th>Date</th><th></th></tr></thead>
        <tbody>
        @forelse($jobs as $job)
        <tr onclick="window.location='{{ route('crm.jobs.show', $job) }}'">
            <td class="crm-mono">{{ $job->job_id }}</td>
            <td style="font-weight:500;">{{ $job->job_title }}</td>
            <td>{{ $job->client->full_name ?? '—' }}</td>
            <td style="color:var(--color-ink-2);">{{ $job->assignedTo->name ?? '—' }}</td>
            <td>@include('crm.partials.job-badge', ['status' => $job->job_status])</td>
            <td style="color:var(--color-ink-3);">{{ $job->job_date_time ? $job->job_date_time->format('d M Y') : '—' }}</td>
            <td><a href="{{ route('crm.jobs.edit', $job) }}" class="crm-btn crm-btn-ghost crm-btn-sm" onclick="event.stopPropagation()">Edit</a></td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="crm-empty"><p class="crm-empty-title">No jobs found</p><a href="{{ route('crm.jobs.create') }}" class="crm-btn crm-btn-primary" style="margin-top:1rem;">New Job</a></div></td></tr>
        @endforelse
        </tbody>
    </table>
    @if($jobs->hasPages())<div style="padding:1rem 1.25rem;border-top:1px solid var(--color-border);">{{ $jobs->links() }}</div>@endif
</div>

</x-crm::layout>

