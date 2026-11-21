@php
    // Business hero copy, and one real day of a job moving through useLuminii.
    $h = [
        'eyebrow' => null,   // e.g. 'The operating system for service businesses'; null hides it
        'line1'   => 'Stop losing jobs',
        'pre'     => 'between ',
        'accent'  => 'enquiry and invoice',
        'sub'     => 'Keep every lead, quote, job and invoice connected. Know what needs attention, follow up on opportunities and stay in control from first contact to final payment.',
        'primary' => ['Book a demo', url('/') . '#booking'],
        'ghost'   => ['See pricing', route('pricing')],
        // Risk reducers under the buttons: only promises we can keep
        'trust'   => ['Live within days', 'Guided setup and team handover', 'No credit card needed'],
        'day'     => [
            ['time' => '8:47 AM',  'title' => 'Enquiry answered', 'detail' => 'Burst pipe, kitchen. Site visit booked'],
            ['time' => '10:15 AM', 'title' => 'Quote sent',       'detail' => '8,500.00 · Water heater replacement'],
            ['time' => '11:02 AM', 'title' => 'Job scheduled',    'detail' => 'Thabo assigned, client notified'],
            ['time' => '4:30 PM',  'title' => 'Invoice paid',     'detail' => 'Paid online · Tax recorded'],
        ],
    ];
@endphp
<!-- HERO / BUSINESS: headline, then one day of a job on a ruled line -->
<section class="lp-fh" id="top" aria-labelledby="hero-heading">
    <div class="lp-wrap lp-fh__wrap">
        <div class="lp-fh__copy">
            @if($h['eyebrow'])
            <div class="lp-fh__eyebrow">{{ $h['eyebrow'] }}</div>
            @endif

            <h1 class="lp-fh__h1" id="hero-heading">
                <span class="lp-fh__h1-line">{{ $h['line1'] }}</span>
                <span class="lp-fh__h1-line">{{ $h['pre'] }}<span class="lp-fh__accent">{{ $h['accent'] }}</span></span>
            </h1>

            <div class="lp-fh__lower">
                <p class="lp-fh__sub">{{ $h['sub'] }}</p>
                <div class="lp-fh__actions">
                    <div class="lp-fh__ctas">
                        <a href="{{ $h['primary'][1] }}" class="lp-fh__btn lp-fh__btn--solid">{{ $h['primary'][0] }}</a>
                        @if($h['ghost'])<a href="{{ $h['ghost'][1] }}" class="lp-fh__btn lp-fh__btn--ghost">{{ $h['ghost'][0] }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>@endif
                    </div>
                    <p class="lp-fh__trust">{{ implode(' · ', $h['trust']) }}</p>
                </div>
            </div>
        </div>

        {{-- One day, on a ruled line: a gold line draws across once and each moment ticks in. --}}
        <figure class="lp-fh__dayfig">
            <figcaption class="lp-fh__daycap">One job, one day</figcaption>
            <ol class="lp-fh__day" data-fh-day>
                @foreach($h['day'] as $i => $m)
                <li style="--i: {{ $i }}">
                    <time>{{ $m['time'] }}</time>
                    <strong>{{ $m['title'] }}</strong>
                    <span>{{ $m['detail'] }}</span>
                </li>
                @endforeach
            </ol>
        </figure>
    </div>
</section>

@push('body-scripts')
<script>
// Hero day line: draw the gold line once the hero is in view (static without JS or with reduced motion).
(function () {
    var day = document.querySelector('[data-fh-day]');
    if (!day || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    day.classList.add('is-armed');
    function draw() { requestAnimationFrame(function () { day.classList.add('is-drawn'); }); }
    if (!('IntersectionObserver' in window)) return draw();
    var io = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting) { io.disconnect(); setTimeout(draw, 350); }
    }, { threshold: 0.2 });
    io.observe(day);
})();
</script>
@endpush
