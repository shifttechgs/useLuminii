@php
    // Each stage creates one piece of the record; every later stage carries it forward.
    // Same sample thread as the Platform section (Amina Dlamini, QUO-1042, Thabo, INV-1042).
    $pieces = [
        1 => ['label' => 'Client',   'value' => 'Amina Dlamini',     'meta' => 'Water heater · Riverside'],
        2 => ['label' => 'Scope',    'value' => 'QUO-1042 · 8,500',  'meta' => 'Accepted'],
        3 => ['label' => 'Schedule', 'value' => 'Thabo · Thu 11:00', 'meta' => 'Job booked'],
        4 => ['label' => 'Invoice',  'value' => 'INV-1042 · 8,500',  'meta' => 'Sent on completion'],
        5 => ['label' => 'Payment',  'value' => 'Paid in full',      'meta' => 'Balance 0.00'],
    ];
    $stages = [
        1 => ['name' => 'Enquiry', 'verb' => 'Capture the request'],
        2 => ['name' => 'Quote',   'verb' => 'Agree the price'],
        3 => ['name' => 'Job',     'verb' => 'Do the work'],
        4 => ['name' => 'Invoice', 'verb' => 'Bill the work'],
        5 => ['name' => 'Payment', 'verb' => 'Get paid'],
    ];
@endphp

{{-- WORKFLOW: the record builds up. Each stage adds one piece and inherits every
     earlier piece, so the stack grows left to right. Hover/focus a piece to trace
     where it was created and everywhere it travels. JS: [data-wf] gets .is-armed
     then .is-in (cascade), and .is-tracing (+ .is-lit pieces) while tracing. --}}
<section class="lp-workflow" id="workflow" aria-labelledby="workflow-heading">
    <div class="lp-wrap">
        <header class="lp-workflow__intro">
            <div>
                <div class="lp-workflow__label">Every workflow</div>
                <h2 id="workflow-heading">Every part of the job. <em>Connected.</em></h2>
            </div>
            <div class="lp-workflow__intro-side">
                <p>The details move with the work. Your team can follow the job from the first request to the final payment, with the client history always close by.</p>
                <a href="{{ url('/') }}#booking">See the whole flow <i class="ph ph-arrow-up-right" aria-hidden="true"></i></a>
            </div>
        </header>

        <ol class="lp-carry" data-wf aria-label="How the job record builds up stage by stage">
            @foreach($stages as $s => $stage)
            <li class="lp-carry__stage" style="--s: {{ $s }}">
                <div class="lp-carry__head">
                    <span class="lp-carry__num">{{ str_pad((string) $s, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $stage['name'] }}</h3>
                    <p>{{ $stage['verb'] }}</p>
                </div>
                <ul class="lp-carry__stack">
                    @for($p = 1; $p <= $s; $p++)
                    @php $piece = $pieces[$p]; $isNew = $p === $s; @endphp
                    <li class="lp-carry__piece{{ $isNew ? ' is-new' : ' is-carried' }}" data-piece="{{ $p }}" tabindex="0" style="--p: {{ $p }}">
                        <span class="lp-carry__piece-label">{{ $piece['label'] }}@if($isNew)<em>New</em>@endif</span>
                        <strong>{{ $piece['value'] }}</strong>
                        <small>{{ $piece['meta'] }}</small>
                    </li>
                    @endfor
                </ul>
                @if($s > 1)
                <p class="lp-carry__carries">Carries {{ implode(', ', array_map(fn ($p) => strtolower($pieces[$p]['label']), range(1, $s - 1))) }}</p>
                @endif
            </li>
            @endforeach
        </ol>

        <p class="lp-workflow__note"><span>Nothing is re-typed.</span> Each stage inherits everything before it, so the whole team works from one continuous record.</p>
    </div>
</section>
