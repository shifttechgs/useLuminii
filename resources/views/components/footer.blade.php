{{-- FOOTER (shared by every page): brand + direct contact on top,
     three short link columns, then a quiet legal bar. --}}
<footer class="lp-footer">
    <div class="lp-wrap">
        <div class="lp-footer__top">
            <div class="lp-footer__brand">
                <a href="{{ url('/') }}" class="lp-footer__logo" aria-label="useLuminii home">
                    <img src="{{ asset('assets/images/logo/useluminii_logos/useluminii_light.png') }}" alt="useLuminii" class="lp-footer__logo-img">
                </a>
                <p class="lp-footer__tagline">The connected business system for service teams. Capture leads, send quotes, manage jobs, track expenses and stay in control.</p>
            </div>

            <div class="lp-footer__reach">
                <p class="lp-footer__reach-label">Talk to us</p>
                <a href="tel:+27814303023" class="lp-footer__phone">+27 81 430 3023</a>
                <a href="https://wa.me/27814303023" class="lp-footer__wa" target="_blank" rel="noopener"><i class="ph ph-whatsapp-logo" aria-hidden="true"></i> Message us on WhatsApp</a>
            </div>
        </div>

        <nav class="lp-footer__grid" aria-label="Footer">
            <div>
                <p class="lp-footer__col-title">Product</p>
                <ul class="lp-footer__links">
                    <li><a href="{{ route('features') }}" class="lp-footer__link">Features</a></li>
                    <li><a href="{{ route('pricing') }}" class="lp-footer__link">Pricing</a></li>
                    <li><a href="{{ route('solutions.business-operating-system') }}" class="lp-footer__link">Business</a></li>
                    <li><a href="{{ route('personal') }}" class="lp-footer__link">Personal</a></li>
                </ul>
            </div>
            <div>
                <p class="lp-footer__col-title">Get started</p>
                <ul class="lp-footer__links">
                    <li><a href="{{ url('/') }}#booking" class="lp-footer__link">Book a demo</a></li>
                    <li><a href="{{ url('/') }}#process" class="lp-footer__link">How setup works</a></li>
                    <li><a href="{{ url('/') }}#faq" class="lp-footer__link">FAQ</a></li>
                    <li><a href="{{ url('/contact') }}" class="lp-footer__link">Contact</a></li>
                </ul>
            </div>
            <div>
                <p class="lp-footer__col-title">Company</p>
                <ul class="lp-footer__links">
                    <li><a href="{{ route('about') }}" class="lp-footer__link">About</a></li>
                    <li><a href="{{ route('case-studies') }}" class="lp-footer__link">Case studies</a></li>
                    <li><a href="{{ route('security') }}" class="lp-footer__link">Security</a></li>
                </ul>
            </div>
            <div class="lp-footer__socials" aria-label="Social links">
                <p class="lp-footer__col-title">Follow</p>
                <div class="lp-footer__social-row">
                    <a href="https://facebook.com/useluminii" class="lp-footer__social" target="_blank" rel="noopener" aria-label="Facebook"><i class="ph ph-facebook-logo" aria-hidden="true"></i></a>
                    <a href="https://linkedin.com/company/useluminii" class="lp-footer__social" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="ph ph-linkedin-logo" aria-hidden="true"></i></a>
                    <a href="https://instagram.com/useluminii" class="lp-footer__social" target="_blank" rel="noopener" aria-label="Instagram"><i class="ph ph-instagram-logo" aria-hidden="true"></i></a>
                </div>
            </div>
        </nav>

        <div class="lp-footer__bottom">
            <p class="lp-footer__copy">&copy; {{ date('Y') }} useLuminii. A product of <a href="https://shifttechgs.com" target="_blank" rel="noopener" class="lp-footer__maker">ShiftTech</a>. All rights reserved.</p>
            <div class="lp-footer__legal">
                <a href="{{ route('privacy-policy') }}">Privacy</a>
                <a href="{{ route('terms') }}">Terms</a>
            </div>
        </div>
    </div>
</footer>
