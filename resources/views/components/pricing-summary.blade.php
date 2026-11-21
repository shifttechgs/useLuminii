@php
    // Plan lines are taken from the FAQ answer "Which plan should I choose?"
    $plans = [
        ['name' => 'Starter', 'line' => 'Website, enquiry capture and basic CRM.',              'from' => '', 'price' => 'R999', 'unit' => '/month, flat'],
        ['name' => 'Business', 'line' => 'Adds quotes, jobs, invoices and reports.', 'from' => 'from', 'price' => 'R1,799', 'unit' => '/month, 3 users'],
    ];
@endphp

{{-- PRICING SUMMARY: a price ledger. Name, one line, dotted leader, price.
     Hover fills the leader gold and slides an arrow in; each row opens full pricing. --}}
<section class="lp-cost" id="pricing" aria-labelledby="cost-heading">
    <div class="lp-wrap">
        <header class="lp-cost__intro">
            <div>
                <div class="lp-section__label">Pricing</div>
                <h2 id="cost-heading">Built around your business. <em>Priced clearly.</em></h2>
            </div>
            <p class="lp-cost__setup">Standard setup is included with Starter. Setup for other plans depends on your requirements and billing option.</p>
        </header>

        <ul class="lp-cost__ledger">
            @foreach($plans as $plan)
            <li>
                <a href="{{ route('pricing') }}" class="lp-cost__row">
                    <span class="lp-cost__name">{{ $plan['name'] }}</span>
                    <span class="lp-cost__line">{{ $plan['line'] }}</span>
                    <span class="lp-cost__leader" aria-hidden="true"></span>
                    <span class="lp-cost__price">
                        @if($plan['from'])<small>{{ $plan['from'] }}</small>@endif
                        <strong>{{ $plan['price'] }}</strong>
                        @if($plan['unit'])<small>{{ $plan['unit'] }}</small>@endif
                    </span>
                    <i class="ph ph-arrow-right lp-cost__go" aria-hidden="true"></i>
                </a>
            </li>
            @endforeach
        </ul>

        <p class="lp-cost__scale">Larger operation? <a href="{{ url('/') }}?plan=scale#booking">Let's scope it <i class="ph ph-arrow-right" aria-hidden="true"></i></a></p>

        <div class="lp-cost__actions">
            <a href="{{ url('/') }}#booking" class="lp-cost__primary">Book a demo <i class="ph ph-arrow-up-right" aria-hidden="true"></i></a>
            <a href="{{ route('pricing') }}" class="lp-cost__secondary">View full pricing <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>
