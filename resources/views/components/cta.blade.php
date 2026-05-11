<!-- FINAL CTA -->
<section class="lp-section lp-cta" id="booking">
    <div class="lp-cta__glow"></div>
    <div class="lp-wrap">
        <div class="lp-cta__grid">

            <!-- Left: sticky heading + trust list -->
            <div class="lp-cta__left" data-aos="fade-up">
                <div class="lp-cta__plus">+</div>
                <h2 class="lp-cta__h2">Ready to run your<br>business on autopilot?</h2>
                <p class="lp-cta__sub">Everything you need to capture leads, send quotes, manage jobs, and collect payments — all automated. One flat price. Live in 48 hours.</p>

                <ul class="lp-cta__trust">
                    <li class="lp-cta__trust-item"><i class="ph ph-check-circle"></i> Unlimited team members — one flat price</li>
                    <li class="lp-cta__trust-item"><i class="ph ph-check-circle"></i> Live in 48 hours, fully set up</li>
                    <li class="lp-cta__trust-item"><i class="ph ph-check-circle"></i> No contracts, cancel anytime</li>
                    <li class="lp-cta__trust-item"><i class="ph ph-check-circle"></i> Free data migration included</li>
                    <li class="lp-cta__trust-item"><i class="ph ph-check-circle"></i> Dedicated onboarding support</li>
                </ul>

                <div class="lp-cta__contact-alts">
                    <a href="tel:+27814303023" class="lp-cta__contact-link">
                        <span class="lp-cta__contact-icon"><i class="ph ph-phone"></i></span>
                        <div>
                            <div class="lp-cta__contact-label">Prefer to call?</div>
                            <div class="lp-cta__contact-val">+27 (814) 30 30 23</div>
                        </div>
                    </a>
                    <a href="https://wa.me/27814303023" class="lp-cta__contact-link" target="_blank" rel="noopener">
                        <span class="lp-cta__contact-icon lp-cta__contact-icon--wa"><i class="ph ph-whatsapp-logo"></i></span>
                        <div>
                            <div class="lp-cta__contact-label">WhatsApp us</div>
                            <div class="lp-cta__contact-val">Usually replies in minutes</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Right: booking form card -->
            <div class="lp-cta__card" data-aos="fade-up" data-aos-delay="100">
                <div class="lp-cta__card-accent"></div>

                <div class="lp-cta__card-body">
                    <div class="lp-section__label" style="margin-bottom:12px;">Free 30-minute demo</div>
                    <h3 class="lp-cta__card-h3">Book your demo call.</h3>
                    <p class="lp-cta__card-sub">Tell us about your business — we'll come prepared to show exactly what we'd automate for you.</p>

                    @if(session('demo_success'))
                    <div class="lp-cta__success">
                        <i class="ph ph-check-circle"></i>
                        <div>
                            <strong>You're booked in!</strong>
                            <span>We'll be in touch within a few hours to confirm your time slot.</span>
                        </div>
                    </div>
                    @else

                    @if(session('demo_error'))
                    <div class="lp-cta__alert">Something went wrong. Please try WhatsApp or call us directly.</div>
                    @endif

                    <form action="{{ route('demo.submit') }}" method="POST" class="lp-cta__form">
                        @csrf

                        <!-- Row 1: Name + Email -->
                        <div class="lp-cta__form-row">
                            <div class="lp-cta__form-field">
                                <label class="lp-cta__form-label">Your Name</label>
                                <input type="text" name="fullname" placeholder="John Smith"
                                    class="lp-cta__form-input{{ $errors->has('fullname') ? ' lp-cta__form-input--err' : '' }}"
                                    value="{{ old('fullname') }}" required>
                                @error('fullname')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                            </div>
                            <div class="lp-cta__form-field">
                                <label class="lp-cta__form-label">Work Email</label>
                                <input type="email" name="email" placeholder="john@yourbusiness.com"
                                    class="lp-cta__form-input{{ $errors->has('email') ? ' lp-cta__form-input--err' : '' }}"
                                    value="{{ old('email') }}" required>
                                @error('email')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Row 2: Business Type + Team Size -->
                        <div class="lp-cta__form-row">
                            <div class="lp-cta__form-field">
                                <label class="lp-cta__form-label">Business Type</label>
                                <select name="business_type"
                                    class="lp-cta__form-input lp-cta__form-select{{ $errors->has('business_type') ? ' lp-cta__form-input--err' : '' }}"
                                    required>
                                    <option value="" disabled {{ old('business_type') ? '' : 'selected' }}>Your trade</option>
                                    @foreach(['Plumbing','Electrical','Cleaning','Landscaping','HVAC & Air','Pest Control','Pool Services','Security','Painting','Handyman','Construction','Other'] as $type)
                                    <option value="{{ $type }}" {{ old('business_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('business_type')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                            </div>
                            <div class="lp-cta__form-field">
                                <label class="lp-cta__form-label">Team Size</label>
                                <select name="team_size"
                                    class="lp-cta__form-input lp-cta__form-select{{ $errors->has('team_size') ? ' lp-cta__form-input--err' : '' }}"
                                    required>
                                    <option value="" disabled {{ old('team_size') ? '' : 'selected' }}>How many people?</option>
                                    @foreach(['Just me','2–5 people','6–15 people','15+ people'] as $size)
                                    <option value="{{ $size }}" {{ old('team_size') == $size ? 'selected' : '' }}>{{ $size }}</option>
                                    @endforeach
                                </select>
                                @error('team_size')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Row 3: Biggest Pain Point -->
                        <div class="lp-cta__form-field">
                            <label class="lp-cta__form-label">Biggest Pain Point</label>
                            <select name="pain_point"
                                class="lp-cta__form-input lp-cta__form-select{{ $errors->has('pain_point') ? ' lp-cta__form-input--err' : '' }}"
                                required>
                                <option value="" disabled {{ old('pain_point') ? '' : 'selected' }}>What's slowing you down?</option>
                                @foreach([
                                    'Losing leads before I can respond',
                                    'Quoting manually takes too long',
                                    'Scheduling and dispatch is a mess',
                                    'Chasing late payments',
                                    'Tools don\'t talk to each other',
                                    'All of the above',
                                ] as $pain)
                                <option value="{{ $pain }}" {{ old('pain_point') == $pain ? 'selected' : '' }}>{{ $pain }}</option>
                                @endforeach
                            </select>
                            @error('pain_point')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                        </div>

                        <!-- Row 4: Current Tools (optional) -->
                        <div class="lp-cta__form-field">
                            <label class="lp-cta__form-label">Current Tools <span class="lp-cta__form-optional">(optional)</span></label>
                            <input type="text" name="current_tools"
                                placeholder="WhatsApp, spreadsheets, Xero…"
                                class="lp-cta__form-input"
                                value="{{ old('current_tools') }}">
                        </div>

                        <button type="submit" class="lp-btn lp-btn--primary lp-cta__card-btn">
                            Book My Free Demo
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>

                        <p class="lp-cta__card-note">No credit card &nbsp;·&nbsp; No commitment &nbsp;·&nbsp; No pitch decks</p>
                    </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>
