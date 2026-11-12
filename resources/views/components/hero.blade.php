@php
    // Copy and the day's flow. Each card is something useLuminii does for the team.
    $h = [
        'eyebrow' => 'The operating system for service businesses',
        'line1'   => 'Stop losing jobs',
        'pre'     => 'to ',
        'accent'  => 'missed follow-ups',
        'sub'     => 'Every enquiry answered. Every quote chased. A business you can actually see, from first call to paid invoice.',
        'primary' => ['Book a demo', url('/') . '#booking'],
        'ghost'   => ['See pricing', route('pricing')],
        'trust'   => ['For South African service businesses', 'Guided setup and team handover'],
        'events'  => [
            ['time' => '8:47 AM',  'tone' => 'blue',  'icon' => 'ph-chat-circle-text', 'title' => 'Enquiry answered', 'detail' => 'Burst geyser, Sandton. Site visit booked'],
            ['time' => '10:15 AM', 'tone' => 'gold',  'icon' => 'ph-file-text',        'title' => 'Quote sent',       'detail' => 'R 8,500 · Geyser replacement'],
            ['time' => '11:02 AM', 'tone' => 'lilac', 'icon' => 'ph-calendar-check',   'title' => 'Job scheduled',    'detail' => 'Thabo assigned, client notified'],
            ['time' => '4:30 PM',  'tone' => 'green', 'icon' => 'ph-receipt',          'title' => 'Invoice paid',     'detail' => 'Instant EFT · VAT recorded'],
        ],
        'sysDid'  => '14 admin tasks today',
        'chips'   => ['ph-chat-circle-text', 'ph-file-text', 'ph-receipt'],
        'youIcon' => 'ph-wrench',
        'youDid'  => 'The job. And got paid.',
    ];
    $flowEvents = $h['events'];
@endphp
<!-- HERO / BUSINESS -->
<section class="lp-fh" id="top">
    <canvas class="lp-fh__canvas" aria-hidden="true"></canvas>

    <div class="lp-wrap lp-fh__wrap">
        <div class="lp-fh__copy">
            <div class="lp-fh__eyebrow" data-aos="fade-up" data-aos-duration="600">
                <img src="{{ asset('favicon.svg') }}" alt="" class="lp-fh__eyebrow-mark" width="20" height="20">
                {{ $h['eyebrow'] }}
            </div>

            <h1 class="lp-fh__h1" data-aos="fade-up" data-aos-duration="700" data-aos-delay="60">
                <span class="lp-fh__h1-line">{{ $h['line1'] }}</span><br>
                <span class="lp-fh__h1-line">{{ $h['pre'] }}<span class="lp-fh__accent">{{ $h['accent'] }}</span></span>
            </h1>

            <p class="lp-fh__sub" data-aos="fade-up" data-aos-duration="700" data-aos-delay="120">
                {{ $h['sub'] }}
            </p>

            <div class="lp-fh__ctas" data-aos="fade-up" data-aos-duration="700" data-aos-delay="180">
                <a href="{{ $h['primary'][1] }}" class="lp-fh__btn lp-fh__btn--solid"@isset($h['primary'][2]) data-builder="{{ $h['primary'][2] }}"@endisset>{{ $h['primary'][0] }}</a>
                @if($h['ghost'])<a href="{{ $h['ghost'][1] }}" class="lp-fh__btn lp-fh__btn--ghost"@isset($h['ghost'][2]) data-builder="{{ $h['ghost'][2] }}"@endisset>{{ $h['ghost'][0] }}</a>@endif
            </div>

            <div class="lp-fh__trust" data-aos="fade-up" data-aos-duration="700" data-aos-delay="240">
                <span>{{ $h['trust'][0] }}</span>
                <span class="lp-fh__trust-sep" aria-hidden="true"></span>
                <span>{{ $h['trust'][1] }}</span>
            </div>
        </div>

        {{-- Activity stream: decorative, plays a loop of one job flowing through the system --}}
        <div class="lp-fh__stage" aria-hidden="true">
            <div class="lp-fh__stream">
                @foreach($flowEvents as $i => $e)
                    <div class="lp-fh__card lp-fh__card--{{ $e['tone'] }}" data-step="{{ $i }}" style="--i: {{ $i }}">
                        <span class="lp-fh__card-icon"><i class="ph {{ $e['icon'] }}"></i></span>
                        <span class="lp-fh__card-body">
                            <span class="lp-fh__card-time">{{ $e['time'] }}</span>
                            <span class="lp-fh__card-title">{{ $e['title'] }}</span>
                            <span class="lp-fh__card-detail">{{ $e['detail'] }}</span>
                        </span>
                        <span class="lp-fh__check"><i class="ph ph-check"></i></span>
                    </div>
                @endforeach
            </div>

            <div class="lp-fh__summary">
                <div class="lp-fh__sum lp-fh__sum--system">
                    <div class="lp-fh__sum-head">
                        <span class="lp-fh__sum-mark"><img src="{{ asset('favicon.svg') }}" alt=""></span>
                        <span class="lp-fh__sum-title">useLuminii did</span>
                    </div>
                    <div class="lp-fh__sum-foot">
                        <span class="lp-fh__sum-check"><i class="ph ph-check"></i></span>
                        <span>{{ $h['sysDid'] }}</span>
                        <span class="lp-fh__sum-chips">
                            @foreach($h['chips'] as $chip)<i class="ph {{ $chip }}"></i>@endforeach
                        </span>
                    </div>
                </div>
                <div class="lp-fh__sum lp-fh__sum--you">
                    <div class="lp-fh__sum-head">
                        <span class="lp-fh__sum-mark lp-fh__sum-mark--you"><i class="ph {{ $h['youIcon'] }}"></i></span>
                        <span class="lp-fh__sum-title">You did</span>
                    </div>
                    <div class="lp-fh__sum-foot">
                        <span class="lp-fh__sum-check"><i class="ph ph-check"></i></span>
                        <span>{{ $h['youDid'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('body-scripts')
<script>
/*
 * Hero wheel. One fixed pivot on the right; every line is a spoke from the pivot
 * running off the left edge; each card sits on its spoke at radius R and stays upright.
 * Loop: summary fan opens (±14°) → wheel turns clockwise, summary leaves over the top
 * while four spokes sweep in from below (+30°, +10°, −10°, −30°) → fan closes → repeat.
 */
(function () {
    var hero = document.querySelector('.lp-fh');
    if (!hero) return;

    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var canvas = hero.querySelector('.lp-fh__canvas');
    var ctx = canvas.getContext('2d');
    var stage = hero.querySelector('.lp-fh__stage');
    var cards = [].slice.call(hero.querySelectorAll('.lp-fh__card'));
    var sums = [].slice.call(hero.querySelectorAll('.lp-fh__sum'));

    var LOOP = 10.07;                     // seconds
    var FINAL = [30, 10, -10, -30];       // resting spoke angles, top card first
    var SUM = [14, -14];
    var LINE = '#BEC8C6';
    var BG = getComputedStyle(hero).getPropertyValue('--fh-bg').trim() || '#F2F6F5';
    var RAD = Math.PI / 180;

    var W = 0, H = 0, narrow = false, s = 1, cs = 1, R = 557, k = 1;
    var P = { x: 0, y: 0 }, off = { x: 0, y: 0 }, fade = { x0: 0, x1: 1 }, spokeStyle = LINE;
    var copyEls = [].slice.call(hero.querySelectorAll('.lp-fh__eyebrow, .lp-fh__h1-line, .lp-fh__accent, .lp-fh__sub, .lp-fh__ctas, .lp-fh__trust'));

    function clamp(v) { return v < 0 ? 0 : v > 1 ? 1 : v; }
    function seg(t, a, b) { return clamp((t - a) / (b - a)); }
    function outCubic(u) { return 1 - Math.pow(1 - u, 3); }
    function inOut(u) { return u < 0.5 ? 4 * u * u * u : 1 - Math.pow(-2 * u + 2, 3) / 2; }

    function layout() {
        var dpr = Math.min(window.devicePixelRatio || 1, 2);
        W = hero.clientWidth; H = hero.clientHeight;
        canvas.width = W * dpr; canvas.height = H * dpr;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        narrow = W < 960;

        // Stage box inside the hero
        var x = 0, y = 0, n = stage;
        while (n && n !== hero) { x += n.offsetLeft; y += n.offsetTop; n = n.offsetParent; }
        off = { x: x, y: y };

        if (narrow) {
            R = 390; s = 0.62; k = 0.85;                       // k tightens the fan on phones
            cs = Math.min(0.86, (W - 70) / 384);
            P = { x: W / 2 + R - 16, y: y + stage.offsetHeight / 2 };
        } else {
            s = Math.max(0.66, Math.min(1, W / 1920)); k = 1; cs = s;   // whole scene scales with the viewport
            R = 557 * s;
            // Outer cards line up with the right edge of the content area
            P = { x: x + stage.offsetWidth + 290 * s, y: y + stage.offsetHeight / 2 };
        }

        // Spokes fade out before they reach the heading and copy
        if (narrow) {
            fade = { x0: -20, x1: 110 };
        } else {
            var hr = hero.getBoundingClientRect(), copyR = 0;
            copyEls.forEach(function (el) { copyR = Math.max(copyR, el.getBoundingClientRect().right - hr.left); });
            var cardL = P.x - R - 192 * cs;
            fade.x0 = copyR + 20;
            fade.x1 = Math.max(fade.x0 + 60, Math.min(fade.x0 + 280, cardL - 10));
        }
        spokeStyle = ctx.createLinearGradient(fade.x0, 0, fade.x1, 0);
        spokeStyle.addColorStop(0, 'rgba(190,200,198,0)');
        spokeStyle.addColorStop(1, 'rgba(190,200,198,1)');
    }

    // Where every spoke and card is at time t (seconds into the loop)
    function state(t) {
        var four = [], two = [], i, a, alpha;

        // Four event spokes
        var closing = 1 - inOut(seg(t, 9.27, LOOP));
        for (i = 0; i < 4; i++) {
            if (t < 0.55) {                                    // closed fan, cross-fading out
                four.push({ a: 0, alpha: 1 - seg(t, 0.05, 0.5), line: true, done: true });
            } else if (t < 4.4) {
                four.push({ a: 0, alpha: 0, line: false, done: false });
            } else {
                var sweep = -140 * Math.pow(1 - seg(t, 4.4, 7.7), 1.9);
                a = FINAL[i] * k * closing + sweep;
                alpha = clamp((a + 83) / 55);
                four.push({ a: a, alpha: alpha, line: true, done: t > 7.25 + i * 0.22 });
            }
        }

        // Two summary spokes
        var open = outCubic(seg(t, 0.65, 1.8));
        var turn = 135 * Math.pow(seg(t, 3.3, 5.8), 1.6);
        for (i = 0; i < 2; i++) {
            if (t < 0.55 || t >= 5.8) { two.push({ a: 0, alpha: 0, line: false }); continue; }
            a = SUM[i] * k * open + turn;
            alpha = seg(t, 0.55, 0.95);
            // Phones: fade before the card would sweep across the copy. Desktop: it exits over the top.
            alpha *= narrow ? 1 - clamp((a - 22) / 28) : 1 - clamp((a - 118) / 17);
            two.push({ a: a, alpha: alpha, line: true, la: narrow ? alpha : 1 });
        }
        return { four: four, two: two };
    }

    function place(el, st, scale) {
        if (st.alpha <= 0.001) { el.style.opacity = 0; return; }
        var x = P.x - R * Math.cos(st.a * RAD) - off.x - el.offsetWidth / 2;
        var y = P.y - R * Math.sin(st.a * RAD) - off.y - el.offsetHeight / 2;
        el.style.opacity = st.alpha;
        el.style.transform = 'translate(' + x.toFixed(1) + 'px,' + y.toFixed(1) + 'px) scale(' + scale + ')';
    }

    function spoke(a, alpha) {
        var L = 2600;
        ctx.globalAlpha = alpha;
        ctx.strokeStyle = spokeStyle;
        ctx.beginPath();
        ctx.moveTo(P.x, P.y);
        ctx.lineTo(P.x - L * Math.cos(a * RAD), P.y - L * Math.sin(a * RAD));
        ctx.stroke();
    }

    function render(t) {
        var st = state(t);

        ctx.clearRect(0, 0, W, H);
        ctx.strokeStyle = LINE; ctx.lineWidth = 1; ctx.globalAlpha = 1;
        // Inner circle: passes behind the cards
        ctx.beginPath(); ctx.arc(P.x + 75.5 * s, P.y, 550 * s, 0, Math.PI * 2); ctx.stroke();

        st.four.forEach(function (f) { if (f.line) spoke(f.a, 1); });
        st.two.forEach(function (f) { if (f.line) spoke(f.a, f.la); });
        ctx.globalAlpha = 1;
        ctx.strokeStyle = LINE;

        // Outer circle: filled with the background so every spoke ends exactly on its arc
        ctx.beginPath(); ctx.arc(P.x + 451.6 * s, P.y + 3.4 * s, 550 * s, 0, Math.PI * 2);
        ctx.fillStyle = BG; ctx.fill(); ctx.stroke();

        cards.forEach(function (el, i) {
            place(el, st.four[i], cs);
            el.classList.toggle('is-done', st.four[i].done);
            el.style.zIndex = t < 0.55 ? 4 - i : '';
        });
        sums.forEach(function (el, i) { place(el, st.two[i], cs); });
    }

    var STILL = 8.5;                      // settled four-card frame
    function relayout() { layout(); if (reduce || !running) render(reduce ? STILL : clock); }

    var running = false, clock = 4.3, last = 0, visible = true;
    layout();
    render(reduce ? STILL : clock);

    var resizeTimer;
    window.addEventListener('resize', function () { clearTimeout(resizeTimer); resizeTimer = setTimeout(relayout, 100); });
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(relayout);
    window.addEventListener('load', relayout);

    if (reduce) return;

    function frame(now) {
        if (visible) {
            var dt = last ? Math.min(0.05, (now - last) / 1000) : 0;
            clock = (clock + dt) % LOOP;
            render(clock);
        }
        last = now;
        requestAnimationFrame(frame);
    }
    running = true;
    requestAnimationFrame(frame);

    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (entries) { visible = entries[0].isIntersecting; }, { threshold: 0.05 }).observe(hero);
    }
})();
</script>
@endpush
