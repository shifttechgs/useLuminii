<x-crm::layout title="Pipeline">

<div class="crm-page-header">
    <div><h1 class="crm-page-title">Pipeline</h1><p class="crm-page-subtitle">Drag client requests through your sales pipeline</p></div>
    <a href="{{ route('crm.requests.create') }}" class="crm-btn crm-btn-primary">New Request</a>
</div>

@php
$colColors = [
    'New'      => ['bg'=>'#eff8ff','border'=>'#bae0fd','text'=>'#1849a9','dot'=>'#2e90fa'],
    'InReview' => ['bg'=>'#fffaeb','border'=>'#fedf89','text'=>'#b54708','dot'=>'#f79009'],
    'Quoted'   => ['bg'=>'#f5f3ff','border'=>'#ddd6fe','text'=>'#5b21b6','dot'=>'#7c3aed'],
    'Approved' => ['bg'=>'#ecfdf3','border'=>'#a7f3d0','text'=>'#027a48','dot'=>'#12b76a'],
    'Closed'   => ['bg'=>'#f1f3f7','border'=>'#e4e9f0','text'=>'#5a6a7e','dot'=>'#8898aa'],
];
$colLabels = ['New'=>'New','InReview'=>'In Review','Quoted'=>'Quoted','Approved'=>'Approved','Closed'=>'Closed'];
@endphp

<div style="display:grid;grid-template-columns:repeat(5,minmax(220px,1fr));gap:1rem;overflow-x:auto;padding-bottom:1rem;">

    @foreach($columns as $col)
    @php $color = $colColors[$col]; @endphp
    <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-lg);overflow:hidden;min-height:300px;">
        {{-- Column header --}}
        <div style="padding:0.875rem 1rem;border-bottom:1px solid var(--color-border);display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <span style="width:8px;height:8px;border-radius:50%;background:{{ $color['dot'] }};flex-shrink:0;"></span>
                <span style="font-size:0.8125rem;font-weight:600;color:var(--color-ink-1);">{{ $colLabels[$col] }}</span>
            </div>
            <span style="font-size:0.75rem;background:{{ $color['bg'] }};color:{{ $color['text'] }};border:1px solid {{ $color['border'] }};padding:0.125rem 0.5rem;border-radius:99px;font-weight:600;">{{ $pipeline[$col]->count() }}</span>
        </div>

        {{-- Cards --}}
        <div style="padding:0.625rem;display:flex;flex-direction:column;gap:0.5rem;">
            @forelse($pipeline[$col] as $req)
            <div class="crm-card" style="cursor:pointer;transition:box-shadow 150ms ease;" onclick="window.location='{{ route('crm.requests.show', $req) }}'">
                <div style="padding:0.75rem 0.875rem;">
                    <p style="font-size:0.8125rem;font-weight:600;color:var(--color-ink-1);line-height:1.4;margin-bottom:0.25rem;">{{ $req->title }}</p>
                    <p style="font-size:0.75rem;color:var(--color-ink-3);">{{ $req->client->full_name ?? '—' }}</p>
                    @if($req->priority)
                    @php $prioMap = ['Low'=>'crm-badge-neutral','Medium'=>'crm-badge-info','High'=>'crm-badge-warning','Urgent'=>'crm-badge-danger']; @endphp
                    <span class="crm-badge {{ $prioMap[$req->priority] ?? 'crm-badge-neutral' }}" style="margin-top:0.5rem;font-size:0.6875rem;">{{ $req->priority }}</span>
                    @endif
                    <div style="margin-top:0.5rem;display:flex;gap:0.375rem;flex-wrap:wrap;">
                        @foreach(array_filter($columns, fn($c) => $c !== $col) as $target)
                        <form method="POST" action="{{ route('crm.pipeline.move', $req) }}" style="margin:0;" onsubmit="event.stopPropagation()">
                            @csrf
                            <input type="hidden" name="status" value="{{ $target }}">
                            <button type="submit" class="crm-btn crm-btn-ghost" style="font-size:0.6875rem;padding:0.125rem 0.375rem;height:auto;" onclick="event.stopPropagation()">→ {{ $colLabels[$target] }}</button>
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:1.5rem 0.5rem;">
                <p style="font-size:0.8125rem;color:var(--color-ink-3);">Empty</p>
            </div>
            @endforelse
        </div>
    </div>
    @endforeach

</div>

</x-crm::layout>

