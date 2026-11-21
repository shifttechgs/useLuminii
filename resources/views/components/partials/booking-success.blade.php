{{-- Demo request confirmation. Rendered server-side after a no-JS submit, and cloned by
     the booking script (layouts/app) from <template id="booking-done-tpl"> after an AJAX
     submit, so both paths show the same panel. Expects optional $first and $email. --}}
<div class="lp-done" role="status" aria-live="polite" tabindex="-1" data-booking-done>
    <span class="lp-done__icon" aria-hidden="true">
        <svg viewBox="0 0 48 48" width="48" height="48" fill="none">
            <circle cx="24" cy="24" r="23" class="lp-done__ring" />
            <path d="M15 24.5l6.2 6.2L33.5 18" class="lp-done__tick" />
        </svg>
    </span>

    <p class="lp-done__eyebrow">Demo request received</p>
    <h3 class="lp-done__title">Thanks<span data-done-name>{{ !empty($first) ? ', ' . $first : '' }}</span>. Your demo request is in.</h3>
    <p class="lp-done__lead">
        We'll be in touch<span data-done-email-wrap @if(empty($email)) hidden @endif> at <strong data-done-email>{{ $email ?? '' }}</strong></span> to arrange a time that suits you.
    </p>

    <div class="lp-done__next">
        <p class="lp-done__next-label">What happens next</p>
        <ol class="lp-done__steps">
            <li><span>01</span>We look over your details</li>
            <li><span>02</span>We contact you to set a time</li>
            <li><span>03</span>We walk you through the platform</li>
        </ol>
    </div>

    <div class="lp-done__actions">
        <a href="https://wa.me/27814303023" class="lp-done__wa" target="_blank" rel="noopener"><i class="ph ph-whatsapp-logo" aria-hidden="true"></i>Prefer to chat now? WhatsApp us</a>
        <button type="button" class="lp-done__again" data-booking-again>Send another request</button>
    </div>
</div>
