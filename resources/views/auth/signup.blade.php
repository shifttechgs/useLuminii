<!DOCTYPE html>
<html lang="en-ZA">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Start your free trial | useLuminii</title>
    <meta name="description" content="Start a {{ $trialDays }}-day free trial of useLuminii. No card needed. Leads, quotes, jobs and invoices in one place.">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="{{ route('signup') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-reboot.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lp.css') }}?v={{ filemtime(public_path('css/lp.css')) }}">
</head>
<body class="lp lp-su-body">

@php
    $money = fn ($n) => 'R' . number_format($n);
    $perMonth = fn ($p, $i) => $i === 'annual' ? (int) round($p['annual'] / 12) : $p['monthly'];
    $users = fn ($p) => $p['users'] === 1 ? '1 user' : $p['users'] . ' users included';
    $logos = array_values(array_filter([
        ['file' => 'vpw.png',             'name' => 'Vision Plus Wealth',   'w' => 718, 'h' => 234, 'size' => 27],
        ['file' => 'payhse.png',          'name' => 'Payhouse Finance',     'w' => 722, 'h' => 296, 'size' => 36],
        ['file' => 'BSlwebbold.png',      'name' => 'BSL Services',         'w' => 508, 'h' => 219, 'size' => 34],
        ['file' => 'baardy.png',          'name' => 'Baardy Micro Capital', 'w' => 510, 'h' => 151, 'size' => 28],
        ['file' => 'spring_kleaners.png', 'name' => 'Spring Kleaners',      'w' => 389, 'h' => 84, 'size' => 21, 'light' => true],
    ], fn ($l) => file_exists(public_path('assets/images/logo/clients/' . $l['file']))));
@endphp

<div class="lp-su">
    <main class="lp-su__main">
        <header class="lp-su__top">
            <a href="{{ url('/') }}" class="lp-su__logo" aria-label="useLuminii home">
                <img src="{{ asset('assets/images/logo/useluminii_logos/useluminii_dark.png') }}" alt="useLuminii" width="385" height="109">
            </a>
            <p class="lp-su__have">Have an account? <a href="{{ route('crm.login') }}">Sign in</a></p>
        </header>

        <div class="lp-su__body">
            <h1 class="lp-su__title">Start your {{ $trialDays }}-day trial</h1>
            <p class="lp-su__lead">No card needed. Every trial includes all Business features.</p>

            @if($errors->any())
                <div class="lp-su__alert" role="alert">
                    <strong>Please check the highlighted fields.</strong>
                    @if($errors->has('email') && str_contains($errors->first('email'), 'Sign in'))
                        <span>{{ $errors->first('email') }} <a href="{{ route('crm.login') }}">Sign in</a></span>
                    @endif
                </div>
            @endif

            <form method="POST" action="{{ route('signup.store') }}" class="lp-su__form" data-su-form novalidate>
                @csrf

                {{-- Bots fill this; people never see it --}}
                <div class="lp-su__hp" aria-hidden="true">
                    <label for="company_website">Company website</label>
                    <input type="text" id="company_website" name="company_website" tabindex="-1" autocomplete="off">
                </div>

                <fieldset class="lp-su__plans">
                    <div class="lp-su__plans-head">
                        <legend class="lp-su__legend">Plan after your trial</legend>
                        <div class="lp-su__interval">
                            <label><input type="radio" name="interval" value="monthly" @checked($interval === 'monthly')><span>Monthly</span></label>
                            <label><input type="radio" name="interval" value="annual" @checked($interval === 'annual')><span>Annual <small>2 months free</small></span></label>
                        </div>
                    </div>
                    <div class="lp-su__plan-grid">
                        @foreach($plans as $key => $p)
                            <label class="lp-su__plan">
                                <input type="radio" name="plan" value="{{ $key }}" @checked($plan === $key)>
                                <span class="lp-su__plan-name">{{ $p['name'] }}</span>
                                <span class="lp-su__plan-price">
                                    <strong data-monthly="{{ $money($p['monthly']) }}" data-annual="{{ $money($perMonth($p, 'annual')) }}">{{ $money($perMonth($p, $interval)) }}</strong>
                                    <small>/ month · {{ $users($p) }}</small>
                                </span>
                                <span class="lp-su__plan-tick" aria-hidden="true"></span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                <div class="lp-su__grid">
                    <div class="lp-su__field">
                        <label for="su-name">Your name</label>
                        <input id="su-name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required maxlength="120"
                               aria-describedby="su-name-err" @error('name') aria-invalid="true" @enderror>
                        <p class="lp-su__err" id="su-name-err" data-err-for="su-name">@error('name'){{ $message }}@enderror</p>
                    </div>
                    <div class="lp-su__field">
                        <label for="su-business">Business name</label>
                        <input id="su-business" type="text" name="business_name" value="{{ old('business_name') }}" autocomplete="organization" required maxlength="160"
                               aria-describedby="su-business-err" @error('business_name') aria-invalid="true" @enderror>
                        <p class="lp-su__err" id="su-business-err" data-err-for="su-business">@error('business_name'){{ $message }}@enderror</p>
                    </div>
                    <div class="lp-su__field">
                        <label for="su-email">Work email</label>
                        <input id="su-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" inputmode="email" required maxlength="190"
                               aria-describedby="su-email-err" @error('email') aria-invalid="true" @enderror>
                        <p class="lp-su__err" id="su-email-err" data-err-for="su-email">@error('email'){{ $message }}@enderror</p>
                    </div>
                    <div class="lp-su__field">
                        <label for="su-phone">Phone <span>(optional)</span></label>
                        <input id="su-phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" inputmode="tel" maxlength="30">
                    </div>
                    <div class="lp-su__field lp-su__field--full">
                        <label for="su-password">Password</label>
                        <div class="lp-su__pw">
                            <input id="su-password" type="password" name="password" autocomplete="new-password" required minlength="8"
                                   aria-describedby="su-password-hint su-password-err" @error('password') aria-invalid="true" @enderror>
                            <button type="button" class="lp-su__pw-toggle" data-pw-toggle aria-controls="su-password" aria-pressed="false">Show</button>
                        </div>
                        <div class="lp-su__pw-meta">
                            <div class="lp-su__strength" data-strength="0" aria-hidden="true"><i></i><i></i><i></i></div>
                            <p class="lp-su__hint" id="su-password-hint" data-pw-hint>At least 8 characters, with a letter and a number.</p>
                        </div>
                        <p class="lp-su__err" id="su-password-err" data-err-for="su-password">@error('password'){{ $message }}@enderror</p>
                    </div>
                </div>

                <button type="submit" class="lp-su__submit" data-su-submit>
                    <span data-su-label>Start free trial</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </button>

                <p class="lp-su__legal">
                    By starting a trial you agree to our <a href="{{ route('terms') }}">Terms</a> and
                    <a href="{{ route('privacy-policy') }}">Privacy Policy</a>.
                </p>
            </form>
        </div>
    </main>

    <aside class="lp-su__aside" aria-labelledby="su-next">
        <div class="lp-su__aside-inner">
            <div class="lp-su__lede">
                @include('auth.partials.record')
            </div>

            <div class="lp-su__next">
                <h2 class="lp-su__aside-label" id="su-next">What happens next</h2>
                <ol class="lp-su__steps">
                    <li>
                        <span class="lp-su__step-when">Today</span>
                        <strong>Your workspace opens</strong>
                        <span>Add clients, log enquiries and send quotes straight away. Invite your team.</span>
                    </li>
                    <li>
                        <span class="lp-su__step-when">Day {{ $trialDays - 3 }}</span>
                        <strong>A reminder, not a charge</strong>
                        <span>We email you three days before the trial ends.</span>
                    </li>
                    <li>
                        <span class="lp-su__step-when">Day {{ $trialDays }}</span>
                        <strong>Choose a plan to keep going</strong>
                        <span>If you don't, your data stays safe and read-only.</span>
                    </li>
                </ol>
            </div>

            <div class="lp-su__proof">
                @if($logos)
                    <p class="lp-su__aside-label">Our clients</p>
                    <ul class="lp-su__logos" aria-label="Client businesses">
                        @foreach($logos as $l)
                            <li class="{{ !empty($l['light']) ? 'is-light-mark' : '' }}" style="--h: {{ $l['size'] }}px">
                                <img src="{{ asset('assets/images/logo/clients/' . $l['file']) }}" alt="{{ $l['name'] }}" width="{{ $l['w'] }}" height="{{ $l['h'] }}" loading="lazy" decoding="async">
                            </li>
                        @endforeach
                    </ul>
                @endif
                <p class="lp-su__demo">Prefer a walkthrough first? <a href="{{ url('/') }}#booking">Book a demo</a></p>
            </div>
        </div>
    </aside>
</div>

<script>
(function () {
    var form = document.querySelector('[data-su-form]');
    if (!form) return;

    // Prices follow the monthly / annual switch
    function syncPrices() {
        var period = form.querySelector('input[name="interval"]:checked').value;
        form.querySelectorAll('.lp-su__plan-price strong').forEach(function (el) {
            el.textContent = el.getAttribute('data-' + period);
        });
    }
    form.querySelectorAll('input[name="interval"]').forEach(function (r) { r.addEventListener('change', syncPrices); });

    // Show / hide password
    var pw = document.getElementById('su-password');
    var toggle = form.querySelector('[data-pw-toggle]');
    toggle.addEventListener('click', function () {
        var show = pw.type === 'password';
        pw.type = show ? 'text' : 'password';
        toggle.textContent = show ? 'Hide' : 'Show';
        toggle.setAttribute('aria-pressed', String(show));
    });

    // Password strength: length, letters + numbers, and a little extra
    var meter = form.querySelector('[data-strength]');
    var hint = form.querySelector('[data-pw-hint]');
    var words = ['At least 8 characters, with a letter and a number.', 'Almost there: add a letter and a number.', 'Good password.', 'Strong password.'];
    pw.addEventListener('input', function () {
        var v = pw.value, score = 0;
        if (v.length >= 8) score++;
        if (/[a-z]/i.test(v) && /\d/.test(v) && v.length >= 8) score++;
        if (v.length >= 12 && /[^a-z0-9]/i.test(v)) score++;
        if (!v) score = 0;
        meter.setAttribute('data-strength', String(score));
        hint.textContent = v ? words[score] : words[0];
    });

    // Friendly messages, shown when a field is left (not while typing)
    var messages = {
        'su-name': 'Please enter your name.',
        'su-business': 'Please enter your business name.',
        'su-email': 'Please enter a valid email address.',
        'su-password': 'Use at least 8 characters, with a letter and a number.'
    };
    function valid(input) {
        if (input.id === 'su-password') return /[a-z]/i.test(input.value) && /\d/.test(input.value) && input.value.length >= 8;
        return input.checkValidity() && input.value.trim() !== '';
    }
    function check(input) {
        var err = form.querySelector('[data-err-for="' + input.id + '"]');
        if (!err) return true;
        var ok = valid(input);
        if (ok) input.removeAttribute('aria-invalid'); else input.setAttribute('aria-invalid', 'true');
        err.textContent = ok ? '' : messages[input.id];
        return ok;
    }
    Object.keys(messages).forEach(function (id) {
        var input = document.getElementById(id);
        input.addEventListener('blur', function () { if (input.value) check(input); });
        input.addEventListener('input', function () { if (input.getAttribute('aria-invalid') === 'true') check(input); });
    });

    // Check everything on submit, focus the first problem, stop double submits
    form.addEventListener('submit', function (e) {
        var first = null;
        Object.keys(messages).forEach(function (id) {
            var input = document.getElementById(id);
            if (!check(input) && !first) first = input;
        });
        if (first) { e.preventDefault(); first.focus(); return; }
        var btn = form.querySelector('[data-su-submit]');
        btn.disabled = true;
        btn.classList.add('is-busy');
        form.querySelector('[data-su-label]').textContent = 'Setting up your workspace';
    });

    var firstBad = form.querySelector('[aria-invalid="true"]');
    if (firstBad) firstBad.focus();
})();
</script>
</body>
</html>
