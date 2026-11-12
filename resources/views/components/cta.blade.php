@php
    $isPersonal = ($audience ?? 'business') === 'personal';
    $ctaTrades = $isPersonal
        ? ['Plumbing','Electrical','Handyman','Cleaning','Painting','Photography','Personal Training','Hair & Beauty','Tutoring','Design & Creative','Consulting','Other']
        : ['Plumbing','Electrical','Cleaning','Landscaping','HVAC & Air','Pest Control','Pool Services','Security','Painting','Handyman','Construction','Other'];
    $ctaPains = $isPersonal ? [
        'Quoting eats my evenings',
        "My quotes don't look professional",
        'Chasing clients for payment',
        "I lose track of who's paid",
        'All of the above',
    ] : [
        'Losing leads before I can respond',
        'Quoting manually takes too long',
        'Scheduling and dispatch is a mess',
        'Chasing late payments',
        "Tools don't talk to each other",
        'All of the above',
    ];
    $defaultTeamSize = old('team_size', $isPersonal ? 'Just me' : null);
@endphp
<!-- FINAL CTA -->
<section class="lp-section lp-cta{{ $isPersonal ? '' : ' lp-cta--business' }}" id="booking" aria-labelledby="booking-heading">
    <div class="lp-cta__glow"></div>
    <div class="lp-wrap">
        <div class="lp-cta__grid">

            <!-- Left: sticky heading + trust list -->
            <div class="lp-cta__left" data-aos="fade-up">
                @if($isPersonal)<div class="lp-cta__plus">+</div>@else<div class="lp-section__label">Let's talk</div>@endif
                @if($isPersonal)
                <h2 class="lp-cta__h2" id="booking-heading">Ready to get your<br>evenings back?</h2>
                <p class="lp-cta__sub">Quote in minutes, invoice when the job is done, and see what has been paid. We set it up for you. Live in 48 hours.</p>

                <ul class="lp-cta__trust">
                    <li class="lp-cta__trust-item"><i class="ph ph-check-circle"></i> One flat monthly price, no surprises</li>
                    <li class="lp-cta__trust-item"><i class="ph ph-check-circle"></i> Live in 48 hours, set up for you</li>
                    <li class="lp-cta__trust-item"><i class="ph ph-check-circle"></i> No contracts, cancel anytime</li>
                    <li class="lp-cta__trust-item"><i class="ph ph-check-circle"></i> Clients accept quotes and pay invoices online</li>
                    <li class="lp-cta__trust-item"><i class="ph ph-check-circle"></i> Upgrade when you hire, nothing to migrate</li>
                </ul>
                @else
                <h2 class="lp-cta__h2" id="booking-heading">See your business flow.<br><em>In one conversation.</em></h2>
                <p class="lp-cta__sub">Show us how your business works today. We'll walk through the platform with you and discuss the plan, setup and next steps that fit.</p>

                <ul class="lp-cta__trust">
                    <li class="lp-cta__trust-item">A walkthrough from enquiry to invoice</li>
                    <li class="lp-cta__trust-item">A conversation about your team and current tools</li>
                    <li class="lp-cta__trust-item">Clear pricing and setup requirements</li>
                </ul>
                @endif

                <div class="lp-cta__contact-alts">
                    <a href="tel:+27814303023" class="lp-cta__contact-link">
                        <span class="lp-cta__contact-icon"><i class="ph ph-phone"></i></span>
                        <div>
                            <div class="lp-cta__contact-label">Prefer to call?</div>
                            <div class="lp-cta__contact-val">+27 81 430 3023</div>
                        </div>
                    </a>
                    <a href="https://wa.me/27814303023" class="lp-cta__contact-link" target="_blank" rel="noopener">
                        <span class="lp-cta__contact-icon lp-cta__contact-icon--wa"><i class="ph ph-whatsapp-logo"></i></span>
                        <div>
                            <div class="lp-cta__contact-label">WhatsApp us</div>
                            <div class="lp-cta__contact-val">Start a conversation</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Right: booking form card -->
            <div class="lp-cta__card" data-aos="fade-up" data-aos-delay="100">
                <div class="lp-cta__card-accent"></div>

                <div class="lp-cta__card-body">
                    @if($isPersonal)
                    <div class="lp-section__label" style="margin-bottom:12px;">Free setup call</div>
                    <h3 class="lp-cta__card-h3">Let's get you set up.</h3>
                    <p class="lp-cta__card-sub">Tell us what you do and what you charge. We'll set up your quotes and invoices, in plain language.</p>
                    @else
                    <div class="lp-section__label" style="margin-bottom:12px;">Demo request</div>
                    <h3 class="lp-cta__card-h3">Let's find a time.</h3>
                    <p class="lp-cta__card-sub">Tell us a little about your business. We'll contact you to arrange your demo.</p>
                    @endif

                    @if(session('demo_success'))
                    <div class="lp-cta__success">
                        <i class="ph ph-check-circle"></i>
                        <div>
                            <strong>Your request is in.</strong>
                            <span>We'll contact you to arrange a time.</span>
                        </div>
                    </div>
                    @else

                    @if(session('demo_error'))
                    <div class="lp-cta__alert">Something went wrong. Please try WhatsApp or call us directly.</div>
                    @endif

                    <form action="{{ route('demo.submit') }}" method="POST" class="lp-cta__form">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{ url()->current() }}">

                        <!-- Row 1: Name + Email -->
                        <div class="lp-cta__form-row">
                            <div class="lp-cta__form-field">
                                <label class="lp-cta__form-label" for="booking-name">Your name</label>
                                <input type="text" name="fullname" id="booking-name" autocomplete="name" maxlength="255" placeholder="John Smith"
                                    class="lp-cta__form-input{{ $errors->has('fullname') ? ' lp-cta__form-input--err' : '' }}"
                                    value="{{ old('fullname') }}" required>
                                @error('fullname')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                            </div>
                            <div class="lp-cta__form-field">
                                <label class="lp-cta__form-label" for="booking-email">{{ $isPersonal ? 'Email' : 'Work email' }}</label>
                                <input type="email" name="email" id="booking-email" autocomplete="email" maxlength="255" placeholder="{{ $isPersonal ? 'you@email.com' : 'john@yourbusiness.com' }}"
                                    class="lp-cta__form-input{{ $errors->has('email') ? ' lp-cta__form-input--err' : '' }}"
                                    value="{{ old('email') }}" required>
                                @error('email')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Row 2: Business Type + Team Size -->
                        <div class="lp-cta__form-row">
                            <div class="lp-cta__form-field">
                                <label class="lp-cta__form-label" for="booking-trade">{{ $isPersonal ? 'What do you do?' : 'Business type' }}</label>
                                <select name="business_type" id="booking-trade"
                                    class="lp-cta__form-input lp-cta__form-select{{ $errors->has('business_type') ? ' lp-cta__form-input--err' : '' }}"
                                    required>
                                    <option value="" disabled {{ old('business_type') ? '' : 'selected' }}>Your trade</option>
                                    @foreach($ctaTrades as $type)
                                    <option value="{{ $type }}" {{ old('business_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('business_type')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                            </div>
                            <div class="lp-cta__form-field">
                                <label class="lp-cta__form-label" for="booking-team">Team size</label>
                                <select name="team_size" id="booking-team"
                                    class="lp-cta__form-input lp-cta__form-select{{ $errors->has('team_size') ? ' lp-cta__form-input--err' : '' }}"
                                    required>
                                    <option value="" disabled {{ $defaultTeamSize ? '' : 'selected' }}>How many people?</option>
                                    @foreach(['Just me','2–5 people','6–15 people','15+ people'] as $size)
                                    <option value="{{ $size }}" {{ $defaultTeamSize == $size ? 'selected' : '' }}>{{ $size }}</option>
                                    @endforeach
                                </select>
                                @error('team_size')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Row 3: Biggest Pain Point -->
                        <div class="lp-cta__form-field">
                            <label class="lp-cta__form-label" for="booking-pain">What would you like to improve?</label>
                            <select name="pain_point" id="booking-pain"
                                class="lp-cta__form-input lp-cta__form-select{{ $errors->has('pain_point') ? ' lp-cta__form-input--err' : '' }}"
                                required>
                                <option value="" disabled {{ old('pain_point') ? '' : 'selected' }}>What's slowing you down?</option>
                                @foreach($ctaPains as $pain)
                                <option value="{{ $pain }}" {{ old('pain_point') == $pain ? 'selected' : '' }}>{{ $pain }}</option>
                                @endforeach
                            </select>
                            @error('pain_point')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                        </div>

                        <!-- Row 4: Current Tools (optional) -->
                        <div class="lp-cta__form-field">
                            <label class="lp-cta__form-label" for="booking-tools">Current tools <span class="lp-cta__form-optional">(optional)</span></label>
                            <input type="text" name="current_tools" id="booking-tools" maxlength="500"
                                placeholder="WhatsApp, spreadsheets, Xero…"
                                class="lp-cta__form-input"
                                value="{{ old('current_tools') }}">
                        </div>

                        <button type="submit" class="lp-btn lp-btn--primary lp-cta__card-btn">
                            <span class="lp-cta__submit-spinner" style="display:none; align-items:center; gap:8px;">
                                <span class="lp-cta__spinner" aria-hidden="true"></span>
                                <span>Sending...</span>
                            </span>
                            <span class="lp-cta__submit-label">
                                {{ $isPersonal ? 'Book My Setup Call' : 'Request a demo' }}
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                        </button>

                        <p class="lp-cta__card-note">No payment details needed. We'll contact you to arrange a time.</p>
                    </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>
