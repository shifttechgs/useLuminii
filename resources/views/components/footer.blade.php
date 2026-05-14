<!-- FOOTER -->
<footer class="lp-footer">
    <div class="lp-wrap">
        <div class="lp-footer__grid">
            <div class="lp-footer__brand">
                <div class="lp-footer__logo">
                    <img
                        src="{{ asset('assets/images/logo/useluminii_logos/useluminii_light.png') }}"
                        alt="useLuminii"
                        class="lp-footer__logo-img"
                    >
                </div>
                <p class="lp-footer__tagline">
                    The connected business system for South African service teams. Capture leads, send quotes, manage jobs, track expenses, and stay in control.
                </p>
                <div class="lp-footer__socials">
                    <a href="https://facebook.com/useluminii" class="lp-footer__social" target="_blank" rel="noopener" aria-label="Facebook">
                        <i class="ph ph-facebook-logo"></i>
                    </a>
                    <a href="https://linkedin.com/company/useluminii" class="lp-footer__social" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <i class="ph ph-linkedin-logo"></i>
                    </a>
                    <a href="https://instagram.com/useluminii" class="lp-footer__social" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="ph ph-instagram-logo"></i>
                    </a>
                    <a href="https://wa.me/27000000000" class="lp-footer__social" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <i class="ph ph-whatsapp-logo"></i>
                    </a>
                </div>
            </div>

            <div>
                <div class="lp-footer__col-title">Product</div>
                <div class="lp-footer__links">
                    <a href="{{ route('features') }}" class="lp-footer__link">Features</a>
                    <a href="{{ url('/') }}#pricing" class="lp-footer__link">Pricing</a>
                    <a href="{{ url('/') }}#process" class="lp-footer__link">How It Works</a>
                    <a href="{{ url('/') }}#faq" class="lp-footer__link">FAQ</a>
                </div>
            </div>

            <div>
                <div class="lp-footer__col-title">Features</div>
                <div class="lp-footer__links">
                    <a href="{{ route('features') }}" class="lp-footer__link">AI Receptionist</a>
                    <a href="{{ route('features') }}" class="lp-footer__link">CRM and Leads</a>
                    <a href="{{ route('features') }}" class="lp-footer__link">Quoting</a>
                    <a href="{{ route('features') }}" class="lp-footer__link">Job Management</a>
                    <a href="{{ route('features') }}" class="lp-footer__link">Invoicing</a>
                </div>
            </div>

            <div>
                <div class="lp-footer__col-title">Company</div>
                <div class="lp-footer__links">
                    <a href="{{ route('about') }}" class="lp-footer__link">About</a>
                    <a href="{{ route('case-studies') }}" class="lp-footer__link">Case Studies</a>
                    <a href="{{ route('security') }}" class="lp-footer__link">Security</a>
                    <a href="{{ url('/contact') }}" class="lp-footer__link">Book a Demo</a>
                    <a href="{{ url('/contact') }}" class="lp-footer__link">Contact</a>
                    <a href="{{ route('privacy-policy') }}" class="lp-footer__link">Privacy Policy</a>
                    <a href="{{ route('terms') }}" class="lp-footer__link">Terms of Service</a>
                </div>
            </div>
        </div>

        <div class="lp-footer__bottom">
            <p class="lp-footer__copy">
                &copy; {{ date('Y') }} useLuminii - A product of <a href="https://shifttechgs.com" target="_blank" style="color:var(--gold);font-weight:700;">ShiftTech</a>. All rights reserved.
            </p>
            <div class="lp-footer__legal">
                <a href="{{ route('privacy-policy') }}">Privacy</a>
                <a href="{{ route('terms') }}">Terms</a>
                <a href="{{ url('/contact') }}">Contact</a>
                <a href="{{ route('crm.login') }}">Admin</a>
            </div>
        </div>
    </div>
</footer>
