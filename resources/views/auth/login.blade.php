<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — Luminii CRM</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/crm-design-system.css') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-font-smoothing: antialiased;
        }

        .login-wrap {
            width: 100%;
            max-width: 420px;
            padding: 24px;
        }

        .login-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            text-decoration: none;
            line-height: 1;
            user-select: none;
        }
        .login-logo img {
            display: block;
            width: 168px;
            height: auto;
            object-fit: contain;
        }

        .login-card {
            background: #ffffff;
            border: 1px solid #e4e9f0;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(13, 27, 46, 0.08), 0 1px 4px rgba(13, 27, 46, 0.04);
            padding: 40px;
        }

        .login-card__hd {
            margin-bottom: 28px;
        }
        .login-card__title {
            font-size: 1.375rem;
            font-weight: 700;
            color: #0d1b2e;
            letter-spacing: -0.025em;
        }
        .login-card__sub {
            font-size: 0.875rem;
            color: #5a6a7e;
            margin-top: 4px;
        }

        .login-field {
            margin-bottom: 18px;
        }
        .login-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #0d1b2e;
            margin-bottom: 6px;
        }
        .login-input {
            width: 100%;
            padding: 10px 14px;
            font-size: 0.9375rem;
            font-family: inherit;
            color: #0d1b2e;
            background: #fff;
            border: 1.5px solid #e4e9f0;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .login-input:focus {
            border-color: #635bff;
            box-shadow: 0 0 0 3px rgba(99, 91, 255, 0.12);
        }
        .login-input.is-error {
            border-color: #f04438;
            box-shadow: 0 0 0 3px rgba(240, 68, 56, 0.10);
        }
        .login-password-wrap {
            position: relative;
        }
        .login-password-wrap .login-input {
            padding-right: 44px;
        }
        .login-password-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #8898aa;
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }
        .login-password-toggle:hover {
            background: #f4f6f9;
            color: #0d1b2e;
        }
        .login-password-toggle svg {
            width: 18px;
            height: 18px;
        }
        .login-password-toggle .eye-off {
            display: none;
        }
        .login-password-toggle.is-visible .eye {
            display: none;
        }
        .login-password-toggle.is-visible .eye-off {
            display: block;
        }
        .login-error {
            font-size: 0.8125rem;
            color: #b42318;
            margin-top: 5px;
        }

        .login-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .login-remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8125rem;
            color: #5a6a7e;
            cursor: pointer;
        }
        .login-remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #635bff;
            cursor: pointer;
        }

        .login-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 11px 20px;
            font-size: 0.9375rem;
            font-weight: 600;
            font-family: inherit;
            color: #fff;
            background: #0a1628;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
            letter-spacing: -0.01em;
        }
        .login-btn:hover {
            background: #0f2040;
            box-shadow: 0 4px 12px rgba(10, 22, 40, 0.25);
            transform: translateY(-1px);
        }
        .login-btn:active {
            transform: translateY(0);
        }

        .login-back {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.8125rem;
            color: #8898aa;
            text-decoration: none;
            transition: color 0.15s;
        }
        .login-back:hover { color: #0d1b2e; }
    </style>
</head>
<body>

<div class="login-wrap">

    <a href="{{ url('/') }}" class="login-logo">
        <img
            src="{{ asset('assets/images/logo/useluminii_logos/useluminii_dark.png') }}"
            alt="useLuminii"
        >
    </a>

    <div class="login-card">
        <div class="login-card__hd">
            <h1 class="login-card__title">Sign in to your CRM</h1>
            <p class="login-card__sub">Enter your credentials to continue</p>
        </div>

        <form method="POST" action="{{ route('crm.login.post') }}" novalidate>
            @csrf

            <div class="login-field">
                <label class="login-label" for="email">Email address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="login-input {{ $errors->has('email') ? 'is-error' : '' }}"
                    autocomplete="email"
                    autofocus
                    required
                >
                @error('email')
                    <p class="login-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="login-field">
                <label class="login-label" for="password">Password</label>
                <div class="login-password-wrap">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="login-input {{ $errors->has('password') ? 'is-error' : '' }}"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="login-password-toggle" id="password-toggle" aria-label="Show password" aria-pressed="false">
                        <svg class="eye" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <svg class="eye-off" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18M10.58 10.58A2 2 0 0012 14a2 2 0 001.42-.58M9.88 5.5A9.42 9.42 0 0112 5.25c6 0 9.75 6.75 9.75 6.75a18.8 18.8 0 01-3.04 3.76M6.53 6.53A18.55 18.55 0 002.25 12S6 18.75 12 18.75a9.64 9.64 0 004.04-.9"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="login-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="login-row">
                <label class="login-remember">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
            </div>

            <button type="submit" class="login-btn">Sign in</button>
        </form>
    </div>

    <a href="{{ url('/') }}" class="login-back">← Back to website</a>

</div>

<script>
(function () {
    var password = document.getElementById('password');
    var toggle = document.getElementById('password-toggle');
    if (!password || !toggle) return;

    toggle.addEventListener('click', function () {
        var visible = password.type === 'text';
        password.type = visible ? 'password' : 'text';
        toggle.classList.toggle('is-visible', !visible);
        toggle.setAttribute('aria-pressed', String(!visible));
        toggle.setAttribute('aria-label', visible ? 'Show password' : 'Hide password');
    });
})();
</script>

</body>
</html>
