<x-crm::layout title="Plan and billing">
@php
    $s = $subscription;
    $fmt = fn ($n) => 'R' . number_format($n);
    $wa = 'https://wa.me/27814303023?text=' . rawurlencode('Hi, I would like to activate my useLuminii plan for ' . (\App\Models\BusinessSetup::current()->business_name ?: 'my business') . '.');
@endphp

<style>
    .bl-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.25rem; }
    .bl-status { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem 2rem; }
    .bl-status__main { display: grid; gap: .25rem; }
    .bl-status__label { color: var(--crm-text-3); font-size: .75rem; font-weight: 500; letter-spacing: .06em; text-transform: uppercase; }
    .bl-status__title { margin: 0; color: var(--crm-text-1); font-size: 1.25rem; font-weight: 600; letter-spacing: -.01em; }
    .bl-status__meta { margin: 0; color: var(--crm-text-2); font-size: .9375rem; }
    .bl-meter { width: min(320px, 100%); }
    .bl-meter__bar { height: 6px; border-radius: 99px; background: var(--crm-border-subtle); overflow: hidden; }
    .bl-meter__fill { height: 100%; border-radius: 99px; background: var(--crm-btn-primary); }
    .bl-meter__fill.is-low { background: #d97706; }
    .bl-meter__text { margin: .5rem 0 0; color: var(--crm-text-2); font-size: .8125rem; }
    .bl-notice { margin-bottom: 1.25rem; padding: .875rem 1rem; border: 1px solid #fecdca; border-left: 3px solid #b42318; border-radius: var(--crm-radius); background: #fef3f2; color: #7a271a; font-size: .9375rem; }
    .bl-plan { display: flex; flex-direction: column; gap: 1rem; height: 100%; }
    .bl-plan.is-current { box-shadow: 0 0 0 2px var(--crm-btn-primary); }
    .bl-plan__head { display: flex; align-items: baseline; justify-content: space-between; gap: 1rem; }
    .bl-plan__name { margin: 0; color: var(--crm-text-1); font-size: 1.125rem; font-weight: 600; }
    .bl-plan__price { color: var(--crm-text-1); font-size: 1.5rem; font-weight: 600; letter-spacing: -.02em; white-space: nowrap; }
    .bl-plan__price small { color: var(--crm-text-3); font-size: .8125rem; font-weight: 400; letter-spacing: 0; }
    .bl-plan__tag { margin: 0; color: var(--crm-text-2); font-size: .9375rem; }
    .bl-plan__annual { margin: 0; color: var(--crm-text-3); font-size: .8125rem; }
    .bl-plan__list { margin: 0; padding: 0; list-style: none; display: grid; gap: .5rem; flex: 1; }
    .bl-plan__list li { position: relative; padding-left: 1.25rem; color: var(--crm-text-1); font-size: .9375rem; }
    .bl-plan__list li::before { content: ""; position: absolute; left: 0; top: .55em; width: .5rem; height: .5rem; border-radius: 50%; background: var(--crm-yellow); }
    .bl-soon { margin: 1.25rem 0 0; color: var(--crm-text-2); font-size: .875rem; }
    @media (max-width: 860px) { .bl-grid { grid-template-columns: 1fr; } }
</style>

<div class="crm-page-header">
    <div>
        <h1 class="crm-page-title">Plan and billing</h1>
        <p class="crm-page-subtitle">Your plan, trial and users</p>
    </div>
</div>

@if($s && $s->isReadOnly())
    <div class="bl-notice" role="alert">
        <strong>Your account is read-only.</strong> Everything you added is safe. Choose a plan to keep working.
    </div>
@endif

<div class="crm-card" style="margin-bottom:1.25rem;">
    <div class="crm-card-body">
        @if(! $s)
            <div class="bl-status__main">
                <span class="bl-status__label">Plan</span>
                <p class="bl-status__title">Managed by the useLuminii team</p>
            </div>
        @else
            <div class="bl-status">
                <div class="bl-status__main">
                    <span class="bl-status__label">Current plan</span>
                    <p class="bl-status__title">
                        {{ $s->planConfig()['name'] ?? ucfirst($s->plan) }}
                        @if($s->status === 'trialing') trial @endif
                    </p>
                    <p class="bl-status__meta">
                        @if($s->complimentary)
                            Set up by the useLuminii team. No card needed.
                        @elseif($s->onTrial())
                            Trial ends {{ $s->trial_ends_at->format('j M Y') }}. Every Business feature is included until then.
                        @elseif($s->status === 'active' && $s->current_period_end)
                            Renews {{ $s->current_period_end->format('j M Y') }}, billed {{ $s->interval === 'annual' ? 'annually' : 'monthly' }}.
                        @elseif($s->isReadOnly())
                            Trial ended {{ optional($s->trial_ends_at)->format('j M Y') }}.
                        @endif
                    </p>
                    <p class="bl-status__meta">{{ $s->seatsUsed() }} of {{ $s->complimentary ? 'unlimited' : $s->seatLimit() }} {{ \Illuminate\Support\Str::plural('user', $s->seatLimit()) }}</p>
                </div>

                @if($s->onTrial())
                    @php $left = $s->trialDaysLeft(); $pct = max(4, min(100, round(($trialDays - $left) / $trialDays * 100))); @endphp
                    <div class="bl-meter" aria-label="Trial progress">
                        <div class="bl-meter__bar"><div class="bl-meter__fill {{ $left <= 3 ? 'is-low' : '' }}" style="width: {{ $pct }}%"></div></div>
                        <p class="bl-meter__text">{{ $left }} {{ \Illuminate\Support\Str::plural('day', $left) }} left of {{ $trialDays }}</p>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

@unless($s && $s->complimentary)
<div class="bl-grid">
    @foreach($plans as $key => $p)
        @php $current = $s && $s->plan === $key && $s->status !== 'trialing'; @endphp
        <div class="crm-card bl-plan-card">
            <div class="crm-card-body bl-plan {{ $current ? 'is-current' : '' }}">
                <div class="bl-plan__head">
                    <h2 class="bl-plan__name">{{ $p['name'] }}</h2>
                    <span class="bl-plan__price">{{ $fmt($p['monthly']) }} <small>/ month</small></span>
                </div>
                <p class="bl-plan__tag">{{ $p['tagline'] }}</p>
                <p class="bl-plan__annual">
                    Or {{ $fmt($p['annual']) }} a year (2 months free).
                    @if($p['extra_user']) Extra users {{ $fmt($p['extra_user']['monthly']) }} / month each. @endif
                </p>
                <ul class="bl-plan__list">
                    @foreach($p['highlights'] as $h)<li>{{ $h }}</li>@endforeach
                </ul>
                @if($current)
                    <span class="crm-btn crm-btn-secondary" aria-disabled="true">Current plan</span>
                @else
                    <a href="{{ $wa }}" target="_blank" rel="noopener" class="crm-btn crm-btn-primary">Choose {{ $p['name'] }}</a>
                @endif
            </div>
        </div>
    @endforeach
</div>
<p class="bl-soon">Card payments in the app are on the way. Until then, choosing a plan opens WhatsApp and the team activates it for you the same day.</p>
@endunless
</x-crm::layout>
