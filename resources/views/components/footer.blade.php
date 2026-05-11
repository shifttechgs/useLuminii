<!-- FOOTER -->
<footer class="lp-footer">
    <div class="lp-wrap">
        <div class="lp-footer__grid">

            <!-- Brand -->
            <div class="lp-footer__brand">
                <div class="lp-footer__logo">
                    <div class="lp-footer__logo-mark">L</div>
                    useLuminii
                </div>
                <p class="lp-footer__tagline">
                    The operating system for South African service businesses. Capture leads, send quotes, manage jobs, and collect payments — all automated.
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

            <!-- Product -->
            <div>
                <div class="lp-footer__col-title">Product</div>
                <div class="lp-footer__links">
                    <a href="{{ url('/') }}#features" class="lp-footer__link">Features</a>
                    <a href="{{ url('/') }}#pricing" class="lp-footer__link">Pricing</a>
                    <a href="{{ url('/') }}#process" class="lp-footer__link">How it works</a>
                    <a href="{{ url('/') }}#faq" class="lp-footer__link">FAQ</a>
                </div>
            </div>

            <!-- Features -->
            <div>
                <div class="lp-footer__col-title">Features</div>
                <div class="lp-footer__links">
                    <a href="{{ url('/') }}#features" class="lp-footer__link">AI Receptionist</a>
                    <a href="{{ url('/') }}#features" class="lp-footer__link">CRM & Leads</a>
                    <a href="{{ url('/') }}#features" class="lp-footer__link">Quoting</a>
                    <a href="{{ url('/') }}#features" class="lp-footer__link">Job Management</a>
                    <a href="{{ url('/') }}#features" class="lp-footer__link">Invoicing</a>
                </div>
            </div>

            <!-- Company -->
            <div>
                <div class="lp-footer__col-title">Company</div>
                <div class="lp-footer__links">
                    <a href="{{ url('/contact') }}" class="lp-footer__link">Book a Demo</a>
                    <a href="{{ url('/contact') }}" class="lp-footer__link">Contact</a>
                    <a href="https://shifttechgs.com" target="_blank" class="lp-footer__link">ShiftTech</a>
                    <a href="javascript:void(0)" class="lp-footer__link">Privacy Policy</a>
                    <a href="javascript:void(0)" class="lp-footer__link">Terms of Service</a>
                </div>
            </div>

        </div>

        <div class="lp-footer__bottom">
            <p class="lp-footer__copy">
                &copy; {{ date('Y') }} useLuminii — A product of <a href="https://shifttechgs.com" target="_blank" style="color:var(--teal);font-weight:700;">ShiftTech</a>. All rights reserved.
            </p>
            <div class="lp-footer__legal">
                <a href="javascript:void(0)">Privacy</a>
                <a href="javascript:void(0)">Terms</a>
                <a href="{{ url('/contact') }}">Contact</a>
            </div>
        </div>
    </div>
</footer>
