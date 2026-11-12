<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="author" content="useLuminii">

    <title>@yield('title', 'useLuminii - Business Operating System for Service Businesses')</title>

    <meta name="description" content="@yield('description', 'useLuminii is the business operating system for service businesses. Connect website leads, quotes, jobs, invoices, expenses, compliance, and reports in one controlled flow.')">
    <meta name="keywords" content="@yield('keywords', 'business management software, CRM for contractors, job scheduling, invoice automation, South Africa')">
    <meta name="robots" content="@yield('robots', 'index, follow')">

    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'useLuminii - Business Operating System for Service Businesses')">
    <meta property="og:description" content="@yield('og_description', 'Connect website leads, quotes, jobs, invoices, expenses, compliance, and reports in one controlled flow.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/logo/useluminii.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="useLuminii">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'useLuminii - Business Operating System for Service Businesses')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Connect website leads, quotes, jobs, invoices, expenses, compliance, and reports in one controlled flow.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('assets/images/logo/useluminii.png'))">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    <meta name="theme-color" content="#0A0A0A">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('useluminii/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('useluminii/assets/css/aos.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lp.css') }}?v={{ filemtime(public_path('css/lp.css')) }}">

    @stack('head-styles')
    @stack('head-scripts')
</head>
<body>

@include('components.navbar')

@yield('content')

@include('components.footer')

<script src="{{ asset('useluminii/assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('useluminii/assets/js/phosphor-icon.js') }}"></script>
<script src="{{ asset('useluminii/assets/js/boostrap.bundle.min.js') }}"></script>
<script src="{{ asset('useluminii/assets/js/aos.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 60 });

@if(session('success'))
toastr.success("{{ session('success') }}");
@elseif(session('error'))
toastr.error("{{ session('error') }}");
@elseif(session('warning'))
toastr.warning("{{ session('warning') }}");
@elseif(session('info'))
toastr.info("{{ session('info') }}");
@endif
</script>

<style>
#toast-container > .toast-success {
    background-color: #dcfce7 !important;
    border: 1px solid #86efac !important;
    box-shadow: 0 14px 34px rgba(20, 83, 45, 0.16) !important;
}
#toast-container > .toast-success,
#toast-container > .toast-success .toast-title,
#toast-container > .toast-success .toast-message,
#toast-container > .toast-success .toast-close-button {
    color: #14532d !important;
}
#toast-container > .toast-success .toast-close-button {
    text-shadow: none !important;
    opacity: 0.8 !important;
}
</style>

<script>
(function () {
    var hdr = document.getElementById('lp-nav');
    if (!hdr) return;

    var scrim = document.getElementById('lp-hdr-scrim');
    var burger = document.getElementById('lp-menu-btn');
    var triggers = hdr.querySelectorAll('.lp-hdr__trigger');
    var panels = hdr.querySelectorAll('[data-menu-panel]');
    var canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    var current = null;
    var closeTimer = null;
    var openTimer = null;

    // Scrolled state: pill hides, bar turns light
    var lastY = window.scrollY;
    function syncScroll() {
        hdr.classList.toggle('is-scrolled', window.scrollY > 24);
        // Desktop mega menus close once the page actually moves
        if (current && current !== 'mobile' && Math.abs(window.scrollY - lastY) > 40) close();
        if (!current) lastY = window.scrollY;
    }
    window.addEventListener('scroll', syncScroll, { passive: true });
    syncScroll();

    function open(name) {
        clearTimeout(closeTimer);
        current = name;
        panels.forEach(function (p) { p.hidden = p.getAttribute('data-menu-panel') !== name; });
        triggers.forEach(function (t) { t.setAttribute('aria-expanded', String(t.getAttribute('data-menu') === name)); });
        if (burger) burger.setAttribute('aria-expanded', String(name === 'mobile'));
        hdr.classList.add('is-open');
        if (scrim) scrim.classList.add('is-visible');
    }

    function close() {
        clearTimeout(openTimer);
        if (!current) return;
        current = null;
        hdr.classList.remove('is-open');
        if (scrim) scrim.classList.remove('is-visible');
        triggers.forEach(function (t) { t.setAttribute('aria-expanded', 'false'); });
        if (burger) burger.setAttribute('aria-expanded', 'false');
        // Hide content after the collapse animation finishes
        closeTimer = setTimeout(function () {
            if (!current) panels.forEach(function (p) { p.hidden = true; });
        }, 380);
    }

    triggers.forEach(function (t) {
        var name = t.getAttribute('data-menu');
        t.addEventListener('click', function () {
            if (current === name) close(); else open(name);
        });
        if (canHover) {
            t.addEventListener('mouseenter', function () {
                clearTimeout(openTimer);
                openTimer = setTimeout(function () { open(name); }, current ? 0 : 70);
            });
            t.addEventListener('mouseleave', function () { clearTimeout(openTimer); });
        }
    });

    var bar = document.getElementById('lp-hdr-bar');
    if (canHover && bar) {
        bar.addEventListener('mouseenter', function () { clearTimeout(closeTimer); });
        bar.addEventListener('mouseleave', function () {
            if (current && current !== 'mobile') {
                closeTimer = setTimeout(close, 180);
            }
        });
    }

    if (burger) {
        burger.addEventListener('click', function () {
            if (current === 'mobile') close(); else open('mobile');
        });
    }

    if (scrim) scrim.addEventListener('click', close);

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape' || !current) return;
        var trigger = hdr.querySelector('.lp-hdr__trigger[data-menu="' + current + '"]') || burger;
        close();
        if (trigger) trigger.focus();
    });

    // Close after following any link inside the panel (covers same-page anchors)
    hdr.querySelectorAll('.lp-hdr__panel a').forEach(function (a) {
        a.addEventListener('click', close);
    });

    window.addEventListener('resize', function () {
        if (current === 'mobile' && window.innerWidth > 1080) close();
        if (current && current !== 'mobile' && window.innerWidth <= 1080) close();
    });

    // Business | Personal switch: slide the thumb, then navigate
    var aud = hdr.querySelector('.lp-aud');
    if (aud) {
        aud.querySelectorAll('.lp-aud__opt').forEach(function (opt) {
            opt.addEventListener('click', function (e) {
                if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;
                e.preventDefault();
                if (opt.classList.contains('is-active')) return;
                aud.setAttribute('data-active', opt.getAttribute('data-aud'));
                aud.querySelectorAll('.lp-aud__opt').forEach(function (o) { o.classList.toggle('is-active', o === opt); });
                var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                setTimeout(function () { window.location.href = opt.href; }, reduce ? 0 : 260);
            });
        });
    }
})();
</script>

<script>
(function () {
    if (!window.fetch) return;

    if (window.toastr) {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            positionClass: 'toast-top-right',
            timeOut: 5000,
            extendedTimeOut: 2000
        };
    }

    function showToast(type, message) {
        if (window.toastr && typeof toastr[type] === 'function') {
            toastr[type](message);
            return;
        }

        alert(message);
    }

    function clearErrors(form) {
        form.querySelectorAll('[data-booking-error]').forEach(function (input) {
            input.removeAttribute('aria-invalid');
            var previousDescription = input.getAttribute('data-booking-description');
            if (previousDescription) input.setAttribute('aria-describedby', previousDescription);
            else input.removeAttribute('aria-describedby');
            input.removeAttribute('data-booking-error');
            input.removeAttribute('data-booking-description');
        });
        form.querySelectorAll('.lp-demo__field--error').forEach(function (field) {
            field.classList.remove('lp-demo__field--error');
        });

        form.querySelectorAll('.lp-cta__form-field--error').forEach(function (field) {
            field.classList.remove('lp-cta__form-field--error');
        });

        form.querySelectorAll('.lp-form-error').forEach(function (error) {
            error.remove();
        });

        var message = form.querySelector('.lp-form-success');
        if (message) {
            message.remove();
        }
    }

    function markError(input, message) {
        if (!input) return;

        var field = input.closest('.lp-demo__field, .lp-cta__form-field');
        if (field) {
            if (field.classList.contains('lp-demo__field')) {
                field.classList.add('lp-demo__field--error');
            } else {
                field.classList.add('lp-cta__form-field--error');
            }
        }

        var error = document.createElement('span');
        error.className = 'lp-form-error';
        error.id = (input.id || input.name) + '-error';
        error.textContent = message;
        input.setAttribute('data-booking-description', input.getAttribute('aria-describedby') || '');
        input.setAttribute('data-booking-error', error.id);
        input.setAttribute('aria-invalid', 'true');
        input.setAttribute('aria-describedby', ((input.getAttribute('aria-describedby') || '') + ' ' + error.id).trim());
        input.insertAdjacentElement('afterend', error);
    }

    function setButtonState(button, busy) {
        if (!button) return;

        button.disabled = busy;

        var label = button.querySelector('.lp-demo__submit-label, .lp-cta__submit-label');
        var spinner = button.querySelector('.lp-demo__submit-spinner, .lp-cta__submit-spinner');

        if (spinner) spinner.style.display = busy ? 'inline-flex' : 'none';
        if (label) label.style.display = busy ? 'none' : '';
    }

    function ensureMessageHost(form) {
        var parent = form.closest('.lp-cta__card-body') || form.parentElement;
        if (!parent) return null;

        var host = parent.querySelector('.lp-form-message-host');
        if (!host) {
            host = document.createElement('div');
            host.className = 'lp-form-message-host';
            form.parentNode.insertBefore(host, form);
        }

        return host;
    }

    function showInlineMessage(form, type, message) {
        var host = ensureMessageHost(form);
        if (!host) return;

        host.innerHTML = '';

        var box = document.createElement('div');
        box.className = type === 'success' ? 'lp-form-success' : 'lp-form-error-banner';
        box.setAttribute('role', type === 'success' ? 'status' : 'alert');
        box.textContent = message;
        host.appendChild(box);
    }

    function bindBookingForm(form) {
        if (!form) return;
        var inlineOnly = !!form.closest('.lp-cta--business');

        var submitBtn = form.querySelector('button[type="submit"]');
        var initialLabel = submitBtn ? submitBtn.querySelector('.lp-demo__submit-label, .lp-cta__submit-label') : null;
        var idleText = initialLabel ? initialLabel.textContent : (submitBtn ? submitBtn.textContent.trim() : 'Book a Demo');

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            if (!form.reportValidity()) return;
            clearErrors(form);
            setButtonState(submitBtn, true);

            var body = new FormData(form);

            fetch(form.getAttribute('action'), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                },
                body: body
            })
            .then(function (response) {
                return response.json().then(function (payload) {
                    return { ok: response.ok, status: response.status, payload: payload };
                });
            })
            .then(function (result) {
                if (result.ok) {
                    form.reset();
                    showInlineMessage(form, 'success', result.payload.message || 'Booking successful.');
                    if (!inlineOnly) showToast('success', result.payload.message || 'Booking successful.');
                    return;
                }

                if (result.status === 422 && result.payload && result.payload.errors) {
                    Object.keys(result.payload.errors).forEach(function (name) {
                        var input = form.querySelector('[name="' + name + '"]');
                        if (input) markError(input, result.payload.errors[name][0]);
                    });
                    var firstInvalid = form.querySelector('[aria-invalid="true"]');
                    if (firstInvalid) firstInvalid.focus();
                    if (inlineOnly) showInlineMessage(form, 'error', result.payload.message || 'Please check the highlighted fields.');
                    else showToast('error', result.payload.message || 'Please check the highlighted fields.');
                    return;
                }

                showInlineMessage(form, 'error', result.payload.message || 'Something went wrong. Please try again.');
                if (!inlineOnly) showToast('error', result.payload.message || 'Something went wrong. Please try again.');
            })
            .catch(function () {
                showInlineMessage(form, 'error', 'Something went wrong. Please try WhatsApp or call us directly.');
                if (!inlineOnly) showToast('error', 'Something went wrong. Please try again.');
            })
            .finally(function () {
                setButtonState(submitBtn, false);
                if (initialLabel) initialLabel.textContent = idleText;
            });
        });
    }

    document.querySelectorAll('.lp-demo__form, .lp-cta__form').forEach(function (form) {
        bindBookingForm(form);
    });
})();
</script>

@stack('body-scripts')

</body>
</html>
