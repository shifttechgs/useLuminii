<!DOCTYPE html>
<html lang="en-ZA">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign in | useLuminii</title>
    <meta name="robots" content="noindex, follow">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-reboot.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lp.css') }}?v={{ filemtime(public_path('css/lp.css')) }}">
</head>
<body class="lp lp-su-body">

@php
    $logos = array_values(array_filter([
        ['file' => 'vpw.png',             'name' => 'Vision Plus Wealth',   'w' => 718, 'h' => 234, 'size' => 27],
        ['file' => 'payhse.png',          'name' => 'Payhouse Finance',     'w' => 722, 'h' => 296, 'size' => 36],
        ['file' => 'BSlwebbold.png',      'name' => 'BSL Services',         'w' => 508, 'h' => 219, 'size' => 34],
        ['file' => 'baardy.png',          'name' => 'Baardy Micro Capital', 'w' => 510, 'h' => 151, 'size' => 28],
        ['file' => 'spring_kleaners.png', 'name' => 'Spring Kleaners',      'w' => 389, 'h' => 84,  'size' => 21, 'light' => true],
    ], fn ($l) => file_exists(public_path('assets/images/logo/clients/' . $l['file']))));
@endphp

<div class="lp-su lp-su--signin">
    <main class="lp-su__main">
        <header class="lp-su__top">
            <a href="{{ url('/') }}" class="lp-su__logo" aria-label="useLuminii home">
                <img src="{{ asset('assets/images/logo/useluminii_logos/useluminii_dark.png') }}" alt="useLuminii" width="385" height="109">
            </a>
            <p class="lp-su__have"><span class="lp-su__have-pre">New to useLuminii? </span><a href="{{ route('signup') }}">Start a free trial</a></p>
        </header>

        <div class="lp-su__body lp-su__body--narrow">
            <h1 class="lp-su__title">Welcome back</h1>
            <p class="lp-su__lead">Sign in to your workspace.</p>

            @if($errors->any())
                <div class="lp-su__alert" role="alert">
                    <strong>{{ $errors->first('email') ?: $errors->first() }}</strong>
                </div>
            @endif

            <form method="POST" action="{{ route('crm.login.post') }}" class="lp-su__form" data-si-form novalidate>
                @csrf

                <div class="lp-su__field">
                    <label for="si-email">Email</label>
                    <input id="si-email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" inputmode="email" required autofocus
                           aria-describedby="si-email-err" @error('email') aria-invalid="true" @enderror>
                    <p class="lp-su__err" id="si-email-err" data-err-for="si-email"></p>
                </div>

                <div class="lp-su__field">
                    <label for="si-password">Password</label>
                    <div class="lp-su__pw">
                        <input id="si-password" type="password" name="password" autocomplete="current-password" required
                               aria-describedby="si-password-err" @error('password') aria-invalid="true" @enderror>
                        <button type="button" class="lp-su__pw-toggle" data-pw-toggle aria-controls="si-password" aria-pressed="false">Show</button>
                    </div>
                    <p class="lp-su__err" id="si-password-err" data-err-for="si-password">@error('password'){{ $message }}@enderror</p>
                </div>

                <label class="lp-su__remember">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember', true))>
                    <span>Keep me signed in on this device</span>
                </label>

                <button type="submit" class="lp-su__submit" data-su-submit>
                    <span data-su-label>Sign in</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </button>

                <p class="lp-su__legal">Trouble signing in? <a href="{{ route('contact.page') }}">Contact us</a></p>
            </form>
        </div>
    </main>

    <aside class="lp-su__aside" aria-label="About useLuminii">
        <div class="lp-su__aside-inner">
            <div class="lp-su__lede">
                <p class="lp-su__statement">Pick up where you left off. <span>Your enquiries, quotes, jobs and invoices are waiting.</span></p>
                @include('auth.partials.record')
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
                <p class="lp-su__demo"><a href="{{ url('/') }}">Back to useluminii.com</a></p>
            </div>
        </div>
    </aside>
</div>

<script>
(function () {
    var form = document.querySelector('[data-si-form]');
    if (!form) return;

    var pw = document.getElementById('si-password');
    var toggle = form.querySelector('[data-pw-toggle]');
    toggle.addEventListener('click', function () {
        var show = pw.type === 'password';
        pw.type = show ? 'text' : 'password';
        toggle.textContent = show ? 'Hide' : 'Show';
        toggle.setAttribute('aria-pressed', String(show));
    });

    var messages = { 'si-email': 'Please enter your email address.', 'si-password': 'Please enter your password.' };
    function check(input) {
        var ok = input.checkValidity() && input.value.trim() !== '';
        if (ok) input.removeAttribute('aria-invalid'); else input.setAttribute('aria-invalid', 'true');
        form.querySelector('[data-err-for="' + input.id + '"]').textContent = ok ? '' : messages[input.id];
        return ok;
    }
    Object.keys(messages).forEach(function (id) {
        var input = document.getElementById(id);
        input.addEventListener('input', function () { if (input.getAttribute('aria-invalid') === 'true') check(input); });
    });

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
        form.querySelector('[data-su-label]').textContent = 'Signing in';
    });
})();
</script>
</body>
</html>
