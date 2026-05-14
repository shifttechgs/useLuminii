@extends('layouts.app')

@section('title', 'Contact - useLuminii')
@section('description', 'Book a useLuminii demo, speak to the team directly, and get a clear next step for your service business.')
@section('og_title', 'Contact | useLuminii')
@section('og_description', 'Book a demo, ask a question, or speak directly with useLuminii about your business operations.')

@push('head-styles')
@include('partials.marketing-page-styles')
<style>
.lp-contact-hero__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    margin-top: 18px;
}
.lp-contact-hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 16px;
    border-radius: 999px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.14);
    color: rgba(255,255,255,0.9);
    font-size: 13px;
    font-weight: 700;
    backdrop-filter: blur(10px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.16);
}
.lp-contact-hero__badge i {
    color: #F5C542;
    font-size: 15px;
}
.lp-contact-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.05fr) minmax(320px, 0.95fr);
    gap: 24px;
}
.lp-contact-panel {
    position: relative;
    overflow: hidden;
}
.lp-contact-panel::after {
    content: '';
    position: absolute;
    inset: auto -50px -70px auto;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245,197,66,0.16) 0%, rgba(245,197,66,0) 72%);
    pointer-events: none;
}
.lp-contact-panel__content {
    position: relative;
    z-index: 1;
}
.lp-contact-panel__lead {
    font-size: 17px;
    line-height: 1.8;
    color: #536173;
    margin-bottom: 22px;
}
.lp-contact-highlights {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
}
.lp-contact-highlight {
    padding: 18px;
    border-radius: 18px;
    background: #F8F9FC;
    border: 1px solid #E5EAF2;
}
.lp-contact-highlight strong {
    display: block;
    font-family: var(--font-display);
    font-size: 15px;
    color: var(--ink);
    margin-bottom: 8px;
}
.lp-contact-highlight span {
    display: block;
    font-size: 13px;
    line-height: 1.7;
    color: var(--muted);
}
.lp-contact-direct {
    display: grid;
    gap: 14px;
}
.lp-contact-direct__item {
    display: grid;
    grid-template-columns: 52px 1fr;
    gap: 16px;
    align-items: start;
    padding: 18px;
    border-radius: 20px;
    background: linear-gradient(180deg, rgba(8,29,58,0.03) 0%, rgba(255,255,255,0.98) 100%);
    border: 1px solid #E5EAF2;
}
.lp-contact-direct__icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: #081D3A;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}
.lp-contact-direct__item strong {
    display: block;
    font-family: var(--font-display);
    font-size: 16px;
    color: var(--ink);
    margin-bottom: 6px;
}
.lp-contact-direct__item p,
.lp-contact-direct__item a {
    font-size: 14px;
    line-height: 1.7;
    color: var(--muted);
    margin: 0;
    text-decoration: none;
}
.lp-contact-direct__item a:hover {
    color: var(--ink);
}
.lp-contact-proof {
    display: grid;
    gap: 16px;
}
.lp-contact-proof__row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 16px;
    background: #fff;
    border: 1px solid #E5EAF2;
}
.lp-contact-proof__row i {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: rgba(245,197,66,0.15);
    color: #8A6400;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.lp-contact-proof__row strong {
    display: block;
    font-family: var(--font-display);
    font-size: 14px;
    color: var(--ink);
    margin-bottom: 2px;
}
.lp-contact-proof__row span {
    display: block;
    font-size: 13px;
    line-height: 1.6;
    color: var(--muted);
}
.lp-contact-booking {
    background:
        radial-gradient(circle at top left, rgba(245,197,66,0.12) 0%, rgba(245,197,66,0) 32%),
        linear-gradient(180deg, #F8F9FC 0%, #FFFFFF 100%);
}
.lp-contact-booking__grid {
    display: grid;
    grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.05fr);
    gap: 32px;
    align-items: start;
}
.lp-contact-booking__intro {
    padding-top: 18px;
}
.lp-contact-booking__title {
    font-family: var(--font-display);
    font-size: clamp(34px, 4vw, 52px);
    font-weight: 800;
    line-height: 1.08;
    letter-spacing: -0.035em;
    color: var(--ink);
    margin-bottom: 18px;
}
.lp-contact-booking__title em {
    font-style: normal;
    color: var(--muted);
}
.lp-contact-booking__sub {
    font-size: 16px;
    line-height: 1.8;
    color: var(--muted);
    margin-bottom: 0;
    max-width: 480px;
}
.lp-contact-booking__aside {
    margin-top: 28px;
    display: grid;
    gap: 12px;
}
.lp-contact-booking__aside a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 16px;
    background: #fff;
    border: 1px solid #E5EAF2;
    color: var(--ink);
    text-decoration: none;
    box-shadow: 0 16px 38px rgba(8,29,58,0.05);
}
.lp-contact-booking__aside a:hover {
    transform: translateY(-1px);
}
.lp-contact-booking__aside i {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: rgba(8,29,58,0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.lp-contact-booking__aside strong {
    display: block;
    font-family: var(--font-display);
    font-size: 13px;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 2px;
}
.lp-contact-booking__aside span {
    display: block;
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
}
@media (max-width: 960px) {
    .lp-contact-grid,
    .lp-contact-booking__grid,
    .lp-contact-highlights {
        grid-template-columns: 1fr;
    }
}
@media (max-width: 900px) {
    .lp-contact-hero__meta {
        justify-content: flex-start;
    }
}
</style>
@endpush

@push('head-scripts')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ContactPage",
  "name": "Contact - useLuminii",
  "url": "{{ url('/contact') }}",
  "description": "Book a demo, ask a question, or speak directly with useLuminii about your business operations."
}
</script>
@endpush

@section('content')
<div class="lp">
    <section class="lp-ph">
        <div class="lp-wrap">
            <div class="lp-ph__inner">
                <div class="lp-section__label" data-aos="fade-up">Contact</div>
                <h1 class="lp-ph__h1" data-aos="fade-up" data-aos-delay="60">Book your next step.<br><em>Speak to the team directly.</em></h1>
                <p class="lp-ph__sub" data-aos="fade-up" data-aos-delay="120">If you want to see how useLuminii would fit your service business, use the same booking flow as the landing page. If you need clarity before that, call or email us directly.</p>
                <div class="lp-contact-hero__meta" data-aos="fade-up" data-aos-delay="180">
                    <span class="lp-contact-hero__badge"><i class="ph ph-calendar-check"></i> Same premium booking flow</span>
                    <span class="lp-contact-hero__badge"><i class="ph ph-clock"></i> Fast follow-up</span>
                    <span class="lp-contact-hero__badge"><i class="ph ph-shield-check"></i> No obligation</span>
                </div>
                <div class="lp-ph__breadcrumb" data-aos="fade-up" data-aos-delay="220">
                    <a href="{{ url('/') }}">Home</a>
                    <span>/</span>
                    <span>Contact</span>
                </div>
            </div>
        </div>
    </section>


    <section class="lp-section lp-contact-booking" id="booking">
        <div class="lp-wrap">
            <div class="lp-contact-booking__grid">
                <div class="lp-contact-booking__intro" data-aos="fade-up">
                    <div class="lp-page__eyebrow">Free 30-minute demo</div>
                    <h2 class="lp-contact-booking__title">Let’s Map Your Current <em>Business Flow.</em></h2>
                    <p class="lp-contact-booking__sub">Tell us what kind of service business you run, how large your team is, and where the friction is.</p>

                    <div class="lp-contact-booking__aside">
                        <a href="tel:+27814303023">
                            <i class="ph ph-phone"></i>
                            <div>
                                <strong>Prefer to call?</strong>
                                <span>+27 81 430 3023</span>
                            </div>
                        </a>
                        <a href="https://wa.me/27814303023" target="_blank" rel="noopener">
                            <i class="ph ph-whatsapp-logo"></i>
                            <div>
                                <strong>Prefer WhatsApp?</strong>
                                <span>Usually replies in minutes</span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="lp-cta__card" data-aos="fade-up" data-aos-delay="100">
                    <div class="lp-cta__card-accent"></div>

                    <div class="lp-cta__card-body">
                        <div class="lp-section__label" style="margin-bottom:12px;">Free 30-minute demo</div>
                        <h3 class="lp-cta__card-h3">Book your demo call.</h3>
                        <p class="lp-cta__card-sub">Tell us about your business. We will come prepared to show what useLuminii would automate and clarify for your team.</p>

                        @if(session('demo_success'))
                        <div class="lp-cta__success">
                            <i class="ph ph-check-circle"></i>
                            <div>
                                <strong>You're booked in!</strong>
                                <span>{{ session('demo_message', "We'll be in touch within a few hours to confirm your time slot.") }}</span>
                            </div>
                        </div>
                        @else

                        @if(session('demo_error'))
                        <div class="lp-cta__alert">Something went wrong. Please try WhatsApp or call us directly.</div>
                        @endif

                        <form action="{{ route('demo.submit') }}" method="POST" class="lp-cta__form">
                            @csrf
                            <input type="hidden" name="redirect_to" value="{{ url('/contact') }}">

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
                                        @foreach(['Just me','2-5 people','6-15 people','15+ people'] as $size)
                                        <option value="{{ $size }}" {{ old('team_size') == $size ? 'selected' : '' }}>{{ $size }}</option>
                                        @endforeach
                                    </select>
                                    @error('team_size')<span class="lp-cta__form-err">{{ $message }}</span>@enderror
                                </div>
                            </div>

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

                            <div class="lp-cta__form-field">
                                <label class="lp-cta__form-label">Current Tools <span class="lp-cta__form-optional">(optional)</span></label>
                                <input type="text" name="current_tools"
                                    placeholder="WhatsApp, spreadsheets, Xero..."
                                    class="lp-cta__form-input"
                                    value="{{ old('current_tools') }}">
                            </div>

                            <button type="submit" class="lp-btn lp-btn--primary lp-cta__card-btn">
                                <span class="lp-cta__submit-spinner" style="display:none; align-items:center; gap:8px;">
                                    <span class="lp-cta__spinner" aria-hidden="true"></span>
                                    <span>Sending...</span>
                                </span>
                                <span class="lp-cta__submit-label">
                                    Book My Free Demo
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </span>
                            </button>

                            <p class="lp-cta__card-note">No credit card | No commitment | No pitch decks</p>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
