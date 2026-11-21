@php
    // Two plans. Business includes 3 users so it always starts above Starter
    // (previously Growth at R299/user undercut Starter for teams of 1-3).
    // Annual = 10 months paid (2 months free), shown as the monthly equivalent.
    $businessPlans = [
        [
            'key' => 'starter', 'name' => 'Starter', 'for' => 'Get found, quote, get paid',
            'description' => 'For solo operators who need a website, enquiries, quotes and invoices in one place.',
            'monthly' => '999', 'annual' => '833', 'unit' => '/ month, flat',
            'extra_monthly' => null, 'extra_annual' => null,
            'monthly_setup' => 'Audit and standard build included.', 'annual_setup' => 'Audit and standard build included.',
            'features' => ['Website that captures enquiries', 'AI receptionist, available 24/7', 'Quotes and invoices, paid online', 'Lead capture and CRM', 'WhatsApp connected', 'Standard build and onboarding'],
        ],
        [
            'key' => 'business', 'name' => 'Business', 'for' => 'The full operating flow',
            'description' => 'For teams connecting their clients, jobs, scheduling and finances in one workspace.',
            'monthly' => '1,799', 'annual' => '1,499', 'unit' => '/ month, 3 users included',
            'extra_monthly' => '+ R299 per extra user / month', 'extra_annual' => '+ R249 per extra user / month',
            'monthly_setup' => 'Setup fee depends on the build scope.', 'annual_setup' => 'Setup fee waived with annual billing.',
            'features' => ['Everything in Starter', 'Full CRM and deal pipeline', 'Jobs and team scheduling', 'Recurring invoices and expenses', 'Business reports', '3 users included', 'Priority onboarding and support'],
        ],
    ];
@endphp

<section class="lp-rates" id="pricing" aria-labelledby="rates-heading" data-business-pricing>
    <div class="lp-wrap">
        <header class="lp-rates__intro">
            <div>
                <div class="lp-section__label">Pricing</div>
                <h2 id="rates-heading">A plan for the way<br><em>your business runs.</em></h2>
            </div>
            <div class="lp-rates__billing-block">
                <div class="lp-rates__billing" role="group" aria-label="Billing period">
                    <button type="button" aria-pressed="true" data-rate-billing="monthly">Monthly</button>
                    <button type="button" aria-pressed="false" data-rate-billing="annual">Annual <span>2 months free</span></button>
                </div>
                <p class="lp-rates__billing-note" data-rate-note aria-live="polite">Monthly billing. Choose annual for 2 months free.</p>
            </div>
        </header>

        <div class="lp-rates__plans">
            @foreach($businessPlans as $plan)
                <article class="lp-rates__plan lp-rates__plan--{{ $plan['key'] }}" aria-labelledby="plan-{{ $plan['key'] }}">
                    <div class="lp-rates__plan-intro">
                        <span class="lp-rates__eyebrow">{{ $plan['for'] }}</span>
                        <h3 id="plan-{{ $plan['key'] }}">{{ $plan['name'] }}</h3>
                        <p class="lp-rates__description">{{ $plan['description'] }}</p>
                    </div>
                    <div class="lp-rates__price-block">
                        <div class="lp-rates__price"><span>R</span><strong data-rate-swap data-monthly="{{ $plan['monthly'] }}" data-annual="{{ $plan['annual'] }}">{{ $plan['monthly'] }}</strong></div>
                        <p class="lp-rates__unit">{{ $plan['unit'] }}</p>
                        @if($plan['extra_monthly'])
                            <p class="lp-rates__extra" data-rate-swap data-monthly="{{ $plan['extra_monthly'] }}" data-annual="{{ $plan['extra_annual'] }}">{{ $plan['extra_monthly'] }}</p>
                        @endif
                        <p class="lp-rates__setup" data-rate-swap data-monthly="{{ $plan['monthly_setup'] }}" data-annual="{{ $plan['annual_setup'] }}">{{ $plan['monthly_setup'] }}</p>
                    </div>
                    <div class="lp-rates__features">
                        <span class="lp-rates__features-label">What's included</span>
                        <ul>
                            @foreach($plan['features'] as $feature)
                                <li><i class="ph ph-check" aria-hidden="true"></i>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="lp-rates__actions">
                    <a href="{{ route('signup', ['plan' => $plan['key'], 'interval' => 'monthly']) }}" class="lp-rates__link" data-signup-link data-plan="{{ $plan['key'] }}" aria-label="Start a free trial of {{ $plan['name'] }}">Start free trial<i class="ph ph-arrow-right" aria-hidden="true"></i></a>
                    <a href="{{ url('/') }}?plan={{ $plan['key'] }}#booking" class="lp-rates__demo">or book a demo</a>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Scale: scoped, not a priced plan --}}
        <div class="lp-rates__scale">
            <div>
                <h3>Larger operation? <em>Let's scope it.</em></h3>
                <p>For established businesses with multiple teams, locations or high job volumes: multi-location support, custom integrations, advanced analytics, a dedicated account manager and 4-hour SLA support.</p>
            </div>
            <a href="{{ url('/') }}?plan=scale#booking">Discuss your requirements <i class="ph ph-arrow-up-right" aria-hidden="true"></i></a>
        </div>

        <div class="lp-rates__footer"><p>Not sure which plan fits? We can work through it with you.</p><a href="{{ url('/') }}#booking">Talk to us <i class="ph ph-arrow-right" aria-hidden="true"></i></a></div>
    </div>
</section>

@push('body-scripts')
<script>
(function () {
    var section = document.querySelector('[data-business-pricing]');
    if (!section) return;
    var buttons = section.querySelectorAll('[data-rate-billing]');
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            var period = button.getAttribute('data-rate-billing');
            buttons.forEach(function (item) { item.setAttribute('aria-pressed', String(item === button)); });
            section.querySelectorAll('[data-rate-swap]').forEach(function (item) {
                item.textContent = item.getAttribute('data-' + period);
            });
            section.querySelectorAll('[data-signup-link]').forEach(function (link) {
                var url = new URL(link.href);
                url.searchParams.set('interval', period);
                link.href = url.toString();
            });
            section.querySelector('[data-rate-note]').textContent = period === 'annual'
                ? 'Annual billing. Monthly equivalent shown.'
                : 'Monthly billing. Choose annual for 2 months free.';
        });
    });
})();
</script>
@endpush
