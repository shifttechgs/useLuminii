@extends("layouts.app")

@section('title', 'Book a Free Demo — useLuminii')
@section('description', 'Book your free 30-minute demo. See how useLuminii captures leads, sends quotes, manages jobs, and collects payments — all automated.')

@push('head-styles')
<style>
/* ── LP BASE SYSTEM ── */
@font-face { font-family:"Manrope"; src:url("{{ asset('useluminii/assets/fonts/precis/UXO4O7K2G3HI3D2VKD7UXVJVJD26P4BQ.woff2') }}") format("woff2"); font-weight:400; font-display:swap; }
@font-face { font-family:"Manrope"; src:url("{{ asset('useluminii/assets/fonts/precis/CIM4KQCLZSMMLWPVH25IDDSTY4ENPHEY.woff2') }}") format("woff2"); font-weight:500; font-display:swap; }
@font-face { font-family:"Manrope"; src:url("{{ asset('useluminii/assets/fonts/precis/JNU3GNMUBPWW6V6JTED3S27XL5HN7NM5.woff2') }}") format("woff2"); font-weight:600; font-display:swap; }
@font-face { font-family:"Manrope"; src:url("{{ asset('useluminii/assets/fonts/precis/6P4FPMFQH7CCC7RZ4UU4NKSGJ2RLF7V5.woff2') }}") format("woff2"); font-weight:700; font-display:swap; }
@font-face { font-family:"Manrope"; src:url("{{ asset('useluminii/assets/fonts/precis/K4ZMLVLHYIFVTTTWGVOTVGOFUUX7NVGI.woff2') }}") format("woff2"); font-weight:800; font-display:swap; }
@font-face { font-family:"PrecisInter"; src:url("{{ asset('useluminii/assets/fonts/precis/GrgcKwrN6d3Uz8EwcLHZxwEfC4.woff2') }}") format("woff2"); font-weight:400; font-display:swap; }
@font-face { font-family:"PrecisInter"; src:url("{{ asset('useluminii/assets/fonts/precis/syRNPWzAMIrcJ3wIlPIP43KjQs.woff2') }}") format("woff2"); font-weight:700; font-display:swap; }
:root {
    --ink:#0A0A0A; --ink-2:#111111; --ink-3:#1C1C1C; --muted:#535253; --muted-2:#8A8A8A;
    --border:#E5E5E5; --border-2:#D0D0D0; --bg:#FFFFFF; --bg-2:#F7F7F7; --bg-3:#F2F2F2;
    --teal:#00E5A0; --teal-dark:#00C78A; --teal-bg:rgba(0,229,160,0.08); --teal-border:rgba(0,229,160,0.25);
    --font-display:"Manrope","Clash Grotesk",system-ui,sans-serif;
    --font-body:"PrecisInter","Inter",system-ui,sans-serif;
    --r:12px; --r-lg:20px; --r-pill:999px;
    --shadow-sm:0 1px 3px rgba(0,0,0,0.08); --shadow:0 4px 16px rgba(0,0,0,0.08);
    --shadow-lg:0 20px 60px rgba(0,0,0,0.12),0 4px 16px rgba(0,0,0,0.06);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
.lp{font-family:var(--font-body);color:var(--ink);background:var(--bg);overflow-x:hidden;}
.lp *,.lp *::before,.lp *::after{font-family:inherit;}
.lp a{text-decoration:none;color:inherit;}
.lp ul{list-style:none;}
.lp-wrap{max-width:1160px;margin:0 auto;padding:0 28px;}
@media(max-width:640px){.lp-wrap{padding:0 20px;}}
.lp-btn{display:inline-flex;align-items:center;gap:9px;font-family:var(--font-display);font-size:15px;font-weight:700;border-radius:var(--r-pill);padding:14px 28px;cursor:pointer;transition:all .2s ease;text-decoration:none;border:2px solid transparent;white-space:nowrap;}
.lp-btn--primary{background:var(--teal);color:var(--ink);border-color:var(--teal);}
.lp-btn--primary:hover{background:var(--teal-dark);border-color:var(--teal-dark);color:var(--ink);transform:translateY(-1px);box-shadow:0 8px 24px rgba(0,229,160,0.35);}
.lp-btn--sm{padding:10px 20px;font-size:13px;}
.lp-nav{position:fixed;top:0;left:0;right:0;z-index:100;transition:all .3s;}
.lp-nav__inner{display:flex;align-items:center;justify-content:space-between;gap:20px;height:68px;padding:0 28px;max-width:1160px;margin:0 auto;}
.lp-nav--scrolled{background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-bottom:1px solid var(--border);}
.lp-nav__logo{display:flex;align-items:center;gap:10px;font-family:var(--font-display);font-size:18px;font-weight:800;color:var(--ink);letter-spacing:-0.03em;flex-shrink:0;}
.lp-nav__logo-mark{width:32px;height:32px;background:var(--teal);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px;color:var(--ink);font-weight:900;flex-shrink:0;}
.lp-nav__links{display:flex;align-items:center;gap:8px;}
@media(max-width:768px){.lp-nav__links{display:none;}}
.lp-nav__link{font-family:var(--font-display);font-size:14px;font-weight:600;color:var(--muted);padding:8px 14px;border-radius:var(--r-pill);transition:all .2s;}
.lp-nav__link:hover{color:var(--ink);background:rgba(0,0,0,0.04);}
.lp-nav--scrolled .lp-nav__link{color:var(--muted);}
.lp-nav--scrolled .lp-nav__link:hover{color:var(--ink);background:var(--bg-2);}
.lp-nav__right{display:flex;align-items:center;gap:10px;flex-shrink:0;}
.lp-nav__mobile-btn{display:none;background:none;border:none;cursor:pointer;font-size:22px;color:var(--ink);padding:4px;}
@media(max-width:768px){.lp-nav__mobile-btn{display:flex;align-items:center;}}
.lp-mobile-menu{display:none;position:fixed;top:68px;left:0;right:0;background:#fff;border-bottom:1px solid var(--border);padding:16px 28px 24px;z-index:99;flex-direction:column;gap:6px;box-shadow:var(--shadow-lg);}
.lp-mobile-menu.open{display:flex;}
.lp-mobile-link{font-family:var(--font-display);font-size:15px;font-weight:600;color:var(--ink);padding:12px 0;border-bottom:1px solid var(--border);display:block;}
.lp-footer{background:var(--bg-2);border-top:1px solid var(--border);padding:72px 0 0;}
.lp-footer__grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;margin-bottom:64px;}
@media(max-width:900px){.lp-footer__grid{grid-template-columns:1fr 1fr;}}
@media(max-width:540px){.lp-footer__grid{grid-template-columns:1fr;}}
.lp-footer__brand{max-width:280px;}
.lp-footer__logo{display:flex;align-items:center;gap:10px;font-family:var(--font-display);font-size:18px;font-weight:800;color:var(--ink);letter-spacing:-0.03em;margin-bottom:16px;}
.lp-footer__logo-mark{width:30px;height:30px;background:var(--teal);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--ink);font-weight:900;}
.lp-footer__tagline{font-size:14px;color:var(--muted);line-height:1.65;margin-bottom:24px;}
.lp-footer__socials{display:flex;gap:8px;}
.lp-footer__social{width:36px;height:36px;border-radius:10px;background:var(--bg-3);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:16px;color:var(--muted);transition:all .2s;}
.lp-footer__social:hover{background:var(--ink);border-color:var(--ink);color:#fff;}
.lp-footer__col-title{font-family:var(--font-display);font-size:13px;font-weight:800;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink);margin-bottom:20px;}
.lp-footer__links{display:flex;flex-direction:column;gap:12px;}
.lp-footer__link{font-size:14px;font-weight:500;color:var(--muted);transition:color .2s;}
.lp-footer__link:hover{color:var(--ink);}
.lp-footer__bottom{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:24px 0;border-top:1px solid var(--border);flex-wrap:wrap;}
.lp-footer__copy{font-size:13px;color:var(--muted-2);font-family:var(--font-display);}
.lp-footer__legal{display:flex;gap:20px;}
.lp-footer__legal a{font-size:13px;color:var(--muted-2);font-family:var(--font-display);transition:color .2s;}
.lp-footer__legal a:hover{color:var(--ink);}

/* ── BOOK DEMO PAGE ── */
.lp-demo {
    padding: 100px 0 120px;
    background: var(--bg);
    min-height: calc(100vh - 72px);
}
.lp-demo__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: start;
}

/* Left: info column */
.lp-demo__info { position: sticky; top: 120px; }
.lp-demo__label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--bg-2);
    border: 1px solid var(--border);
    border-radius: var(--r-pill);
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 700;
    font-family: var(--font-display);
    color: var(--muted);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 24px;
}
.lp-demo__label span {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--teal);
    display: inline-block;
}
.lp-demo__h1 {
    font-family: var(--font-display);
    font-size: clamp(32px, 4vw, 52px);
    font-weight: 800;
    letter-spacing: -0.04em;
    color: var(--ink);
    line-height: 1.05;
    margin-bottom: 20px;
}
.lp-demo__sub {
    font-size: 17px;
    color: var(--muted);
    line-height: 1.65;
    margin-bottom: 44px;
    max-width: 420px;
}

/* Trust points */
.lp-demo__points {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 44px;
}
.lp-demo__point {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.lp-demo__point-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--bg-2);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--teal);
    font-size: 18px;
}
.lp-demo__point-text strong {
    display: block;
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 2px;
}
.lp-demo__point-text span {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.5;
}

/* Contact details */
.lp-demo__contact {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding-top: 36px;
    border-top: 1px solid var(--border);
}
.lp-demo__contact-row {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    color: var(--muted);
}
.lp-demo__contact-row i {
    font-size: 17px;
    color: var(--teal);
    flex-shrink: 0;
}
.lp-demo__contact-row a {
    color: var(--muted);
    text-decoration: none;
    transition: color 0.2s;
}
.lp-demo__contact-row a:hover { color: var(--teal); }

/* Right: form card */
.lp-demo__card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 44px 40px;
}
.lp-demo__card-title {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 6px;
    letter-spacing: -0.02em;
}
.lp-demo__card-sub {
    font-size: 14px;
    color: var(--muted);
    margin-bottom: 36px;
}

/* Form */
.lp-demo__form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.lp-demo__row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.lp-demo__field {
    display: flex;
    flex-direction: column;
    gap: 7px;
}
.lp-demo__field label {
    font-family: var(--font-display);
    font-size: 12px;
    font-weight: 700;
    color: var(--ink);
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
.lp-demo__field input,
.lp-demo__field select,
.lp-demo__field textarea {
    background: var(--bg-2);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 13px 16px;
    font-size: 15px;
    color: var(--ink);
    font-family: var(--font-body);
    transition: border-color 0.2s, background 0.2s;
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    width: 100%;
}
.lp-demo__field input::placeholder,
.lp-demo__field textarea::placeholder { color: var(--muted); opacity: 0.6; }
.lp-demo__field input:focus,
.lp-demo__field select:focus,
.lp-demo__field textarea:focus {
    border-color: var(--teal);
    background: #fff;
}
.lp-demo__field textarea { resize: vertical; min-height: 110px; line-height: 1.6; }
.lp-demo__field select { cursor: pointer; }

.lp-demo__submit {
    width: 100%;
    background: var(--teal);
    color: var(--ink) !important;
    border: none;
    border-radius: 12px;
    padding: 18px 28px;
    font-family: var(--font-display);
    font-size: 16px;
    font-weight: 800;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: opacity 0.2s, transform 0.15s;
    letter-spacing: -0.01em;
    margin-top: 4px;
}
.lp-demo__submit:hover { opacity: 0.88; transform: translateY(-1px); }
.lp-demo__submit:active { transform: translateY(0); }
.lp-demo__submit svg { flex-shrink: 0; }

.lp-demo__agree {
    font-size: 12px;
    color: var(--muted);
    text-align: center;
    line-height: 1.5;
}

/* Responsive */
@media (max-width: 900px) {
    .lp-demo__grid { grid-template-columns: 1fr; gap: 48px; }
    .lp-demo__info { position: static; }
    .lp-demo__card { padding: 32px 24px; }
    .lp-demo__row { grid-template-columns: 1fr; }
    .lp-demo { padding: 80px 0 100px; }
}
</style>
@endpush

@section('content')
<div class="lp">
<section class="lp-demo">
    <div class="lp-wrap">
        <div class="lp-demo__grid">

            <!-- Left: info -->
            <div class="lp-demo__info" data-aos="fade-up">
                <div class="lp-demo__label">
                    <span></span>
                    Free Demo
                </div>
                <h1 class="lp-demo__h1">See useLuminii<br>working live.</h1>
                <p class="lp-demo__sub">Book a free 30-minute walkthrough. We'll show you how to capture leads, send quotes, and get paid — all on autopilot.</p>

                <div class="lp-demo__points">
                    <div class="lp-demo__point">
                        <div class="lp-demo__point-icon"><i class="ph ph-lightning"></i></div>
                        <div class="lp-demo__point-text">
                            <strong>Live in 48 hours</strong>
                            <span>We handle full setup, migration, and team training.</span>
                        </div>
                    </div>
                    <div class="lp-demo__point">
                        <div class="lp-demo__point-icon"><i class="ph ph-users-three"></i></div>
                        <div class="lp-demo__point-text">
                            <strong>Unlimited team members</strong>
                            <span>Add your whole team — your bill never changes.</span>
                        </div>
                    </div>
                    <div class="lp-demo__point">
                        <div class="lp-demo__point-icon"><i class="ph ph-shield-check"></i></div>
                        <div class="lp-demo__point-text">
                            <strong>No contracts or lock-in</strong>
                            <span>Month-to-month. Cancel anytime with 30 days' notice.</span>
                        </div>
                    </div>
                    <div class="lp-demo__point">
                        <div class="lp-demo__point-icon"><i class="ph ph-chat-circle-dots"></i></div>
                        <div class="lp-demo__point-text">
                            <strong>Dedicated onboarding support</strong>
                            <span>A real person walks you through every step.</span>
                        </div>
                    </div>
                </div>

                <div class="lp-demo__contact">
                    <div class="lp-demo__contact-row">
                        <i class="ph ph-phone"></i>
                        <a href="tel:+27814303023">+27 (814) 30 30 23</a>
                    </div>
                    <div class="lp-demo__contact-row">
                        <i class="ph ph-envelope"></i>
                        <a href="mailto:hello@useluminii.com">hello@useluminii.com</a>
                    </div>
                    <div class="lp-demo__contact-row">
                        <i class="ph ph-map-pin"></i>
                        <span>Hampton Place, Parklands, Cape Town, South Africa</span>
                    </div>
                </div>
            </div>

            <!-- Right: form -->
            <div data-aos="fade-up" data-aos-delay="80">
                <div class="lp-demo__card">
                    <div class="lp-demo__card-title">Book your free demo</div>
                    <p class="lp-demo__card-sub">We'll reach out within 2 hours to confirm a time that works for you.</p>

                    <form method="POST" action="{{ url('/contact') }}" class="lp-demo__form">
                        @csrf

                        <div class="lp-demo__row">
                            <div class="lp-demo__field">
                                <label for="fullname">Full Name</label>
                                <input type="text" id="fullname" name="fullname" placeholder="James van der Berg" required>
                            </div>
                            <div class="lp-demo__field">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" placeholder="+27 82 000 0000">
                            </div>
                        </div>

                        <div class="lp-demo__field">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="you@yourbusiness.co.za" required>
                        </div>

                        <div class="lp-demo__field">
                            <label for="package">Plan You're Interested In</label>
                            <select id="package" name="package" required>
                                <option value="" disabled selected>Select a plan...</option>
                                <option value="Starter">Starter — R999/mo · Website + AI Receptionist</option>
                                <option value="Growth">Growth — R1,999/mo · Full system (most popular)</option>
                                <option value="Scale">Scale — R3,499/mo · Multi-location + advanced automations</option>
                                <option value="Not sure">Not sure yet — show me what fits</option>
                            </select>
                        </div>

                        <div class="lp-demo__field">
                            <label for="message">Tell us about your business <span style="font-weight:400;text-transform:none;color:var(--muted)">(optional)</span></label>
                            <textarea id="message" name="message" placeholder="What industry are you in? How many team members? Current tools you use?"></textarea>
                        </div>

                        <button type="submit" class="lp-demo__submit">
                            Book My Free Demo
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>

                        <p class="lp-demo__agree">By submitting you agree to our <a href="javascript:void(0)" style="color:var(--teal)">Privacy Policy</a>. We'll never share your details.</p>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
</div>
@endsection

@push('body-scripts')
<script>
(function () {
    var nav = document.querySelector('.lp-nav');
    if (!nav) return;
    nav.classList.add('lp-nav--scrolled');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 40) nav.classList.add('lp-nav--scrolled');
        else nav.classList.remove('lp-nav--scrolled');
    }, { passive: true });
    var btn = document.getElementById('lp-menu-btn');
    var menu = document.getElementById('lp-mobile-menu');
    if (btn && menu) {
        btn.addEventListener('click', function () { menu.classList.toggle('open'); });
        document.addEventListener('click', function (e) {
            if (!nav.contains(e.target) && !menu.contains(e.target)) menu.classList.remove('open');
        });
    }
})();
</script>
@endpush
