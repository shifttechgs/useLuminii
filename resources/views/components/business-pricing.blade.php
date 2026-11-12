@php
    $businessPlans = [
        ['key' => 'starter', 'name' => 'Starter', 'for' => 'A digital front door', 'description' => 'For solo operators and small teams that need a website, enquiry capture and a basic CRM.', 'monthly' => '999', 'annual' => '833', 'unit' => '/ month', 'monthly_setup' => 'Flat rate. Audit and standard build included.', 'annual_setup' => 'Flat rate. Audit and standard build included.', 'features' => ['Website that captures enquiries', 'AI receptionist, available 24/7', 'Lead capture and basic CRM', 'WhatsApp connected', 'Standard build and onboarding']],
        ['key' => 'growth', 'name' => 'Growth', 'for' => 'The full operating flow', 'description' => 'For growing teams connecting their clients, quotes, jobs and finances in one workspace.', 'monthly' => '299', 'annual' => '249', 'unit' => '/ user / month', 'monthly_setup' => 'Setup fee depends on the build scope.', 'annual_setup' => 'Setup fee waived with annual billing.', 'features' => ['Everything in Starter', 'Full CRM and deal pipeline', 'Quote and proposal builder', 'Job scheduling', 'Invoicing and expenses', 'Business reports', 'Priority onboarding and support']],
        ['key' => 'scale', 'name' => 'Scale', 'for' => 'Built around your operation', 'description' => 'For established businesses managing multiple teams, locations or high job volumes.', 'monthly' => null, 'annual' => null, 'unit' => '', 'monthly_setup' => 'Audit, enterprise build and dedicated onboarding.', 'annual_setup' => 'Audit, enterprise build and dedicated onboarding.', 'features' => ['Everything in Growth', 'Multi-location support', 'Custom integrations', 'Advanced analytics', 'Dedicated account manager', '4-hour SLA support', 'White-glove onboarding']],
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
                        @if($plan['monthly'])
                            <div class="lp-rates__price"><span>R</span><strong data-rate-price data-monthly="{{ $plan['monthly'] }}" data-annual="{{ $plan['annual'] }}">{{ $plan['monthly'] }}</strong></div>
                            <p class="lp-rates__unit">{{ $plan['unit'] }}</p>
                        @else
                            <div class="lp-rates__price lp-rates__price--custom">Custom</div>
                            <p class="lp-rates__unit">For your team size and scope</p>
                        @endif
                        <p class="lp-rates__setup" data-rate-setup data-monthly="{{ $plan['monthly_setup'] }}" data-annual="{{ $plan['annual_setup'] }}">{{ $plan['monthly_setup'] }}</p>
                    </div>
                    <div class="lp-rates__features">
                        <span class="lp-rates__features-label">What's included</span>
                        <ul>
                            @foreach($plan['features'] as $feature)
                                <li><i class="ph ph-check" aria-hidden="true"></i>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{ url('/') }}?plan={{ $plan['key'] }}#booking" class="lp-rates__link" aria-label="{{ $plan['key'] === 'scale' ? 'Discuss the Scale plan' : 'Book a demo of ' . $plan['name'] }}">{{ $plan['key'] === 'scale' ? 'Discuss your requirements' : 'Book a demo' }}<i class="ph ph-arrow-up-right" aria-hidden="true"></i></a>
                </article>
            @endforeach
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
            section.querySelectorAll('[data-rate-price], [data-rate-setup]').forEach(function (item) {
                item.textContent = item.getAttribute('data-' + period);
            });
            section.querySelector('[data-rate-note]').textContent = period === 'annual'
                ? 'Annual billing. Monthly equivalent shown.'
                : 'Monthly billing. Choose annual for 2 months free.';
        });
    });
})();
</script>
@endpush
