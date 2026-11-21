<x-crm::layout :title="$feature">
@php $business = config('plans.plans.business'); @endphp

<style>
    .up-card { max-width: 560px; margin: 3rem auto 0; }
    .up-kicker { margin: 0 0 .5rem; color: var(--crm-text-3); font-size: .75rem; font-weight: 500; letter-spacing: .06em; text-transform: uppercase; }
    .up-title { margin: 0 0 .5rem; color: var(--crm-text-1); font-size: 1.5rem; font-weight: 600; letter-spacing: -.02em; }
    .up-text { margin: 0 0 1.25rem; color: var(--crm-text-2); font-size: 1rem; line-height: 1.55; }
    .up-list { margin: 0 0 1.5rem; padding: 0; list-style: none; display: grid; gap: .5rem; }
    .up-list li { position: relative; padding-left: 1.25rem; color: var(--crm-text-1); font-size: .9375rem; }
    .up-list li::before { content: ""; position: absolute; left: 0; top: .55em; width: .5rem; height: .5rem; border-radius: 50%; background: var(--crm-yellow); }
</style>

<div class="crm-card up-card">
    <div class="crm-card-body">
        <p class="up-kicker">Business plan</p>
        <h1 class="up-title">{{ $feature }} is part of Business</h1>
        <p class="up-text">
            Your plan covers leads, clients, quotes and invoices. Business adds jobs, team scheduling, recurring invoices,
            expenses and reports, for R{{ number_format($business['monthly']) }} a month with {{ $business['users'] }} users included.
        </p>
        <ul class="up-list">
            @foreach($business['highlights'] as $h)<li>{{ $h }}</li>@endforeach
        </ul>
        <a href="{{ route('crm.billing') }}" class="crm-btn crm-btn-primary">See plans</a>
    </div>
</div>
</x-crm::layout>
