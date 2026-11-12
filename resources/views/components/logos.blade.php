@php
    $isPersonal = ($audience ?? 'business') === 'personal';
    $tickerItems = $isPersonal ? [
        ['ph-wrench', 'Solo Plumbers'],
        ['ph-lightning', 'Electricians'],
        ['ph-hammer', 'Handymen'],
        ['ph-broom', 'Cleaners'],
        ['ph-camera', 'Photographers'],
        ['ph-barbell', 'Personal Trainers'],
        ['ph-scissors', 'Hair & Beauty'],
        ['ph-paint-roller', 'Painters'],
        ['ph-car', 'Mobile Mechanics'],
        ['ph-dog', 'Pet Groomers'],
        ['ph-chalkboard-teacher', 'Tutors'],
        ['ph-pen-nib', 'Designers'],
    ] : [
        ['ph-wrench', 'Plumbing'],
        ['ph-lightning', 'Electrical'],
        ['ph-tree', 'Landscaping'],
        ['ph-broom', 'Cleaning'],
        ['ph-bug', 'Pest Control'],
        ['ph-swimming-pool', 'Pool Services'],
        ['ph-thermometer-simple', 'HVAC & Air'],
        ['ph-hard-hat', 'Construction'],
        ['ph-shield-check', 'Security'],
        ['ph-paint-roller', 'Painting'],
        ['ph-hammer', 'Handyman'],
        ['ph-tree-evergreen', 'Tree Felling'],
    ];
@endphp
@if(!$isPersonal)
<section class="lp-clients" aria-labelledby="clients-heading">
    <div class="lp-wrap">
        <h2 class="lp-clients__statement" id="clients-heading">
            <span>Your whole business, connected.</span><br>
            From first enquiry to <em>final payment.</em>
        </h2>
        <div class="lp-clients__row">
            <p class="lp-clients__label">Our clients</p>
            <ul class="lp-clients__logos" aria-label="Client businesses">
                <li><img src="{{ asset('assets/images/logo/clients/wcbs_header_logo.png') }}" alt="Western Cape Blood Service" width="273" height="61" loading="lazy" decoding="async"></li>
                <li><img src="{{ asset('assets/images/logo/clients/vpw.png') }}" alt="Vision Plus Wealth" width="718" height="234" loading="lazy" decoding="async"></li>
                <li><img src="{{ asset('assets/images/logo/clients/payhse.png') }}" alt="Payhouse Finance" width="722" height="296" loading="lazy" decoding="async"></li>
                <li><img src="{{ asset('assets/images/logo/clients/BSlwebbold.png') }}" alt="BSL Services" width="508" height="219" loading="lazy" decoding="async"></li>
            </ul>
        </div>
    </div>
</section>
@else
<!-- PERSONAL TICKER -->
<div class="lp-ticker">
    <span class="lp-ticker__label">{{ $isPersonal ? 'Built For' : 'Working With' }}</span>
    <div class="lp-ticker__wrap">
        <div class="lp-ticker__track">
            {{-- Rendered twice for a seamless loop --}}
            @foreach([0, 1] as $pass)
                @foreach($tickerItems as [$icon, $label])
                    <span class="lp-ticker__item"@if($pass) aria-hidden="true"@endif><i class="ph {{ $icon }}"></i> {{ $label }}</span>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endif
