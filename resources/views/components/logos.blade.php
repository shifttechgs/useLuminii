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
@php
    // h = rendered height in px, tuned per mark so every logo reads at the same optical weight.
    // dark = a light mark (white/yellow on transparent) that needs a silhouette to show on the light band.
    $clientLogos = [
        ['file' => 'vpw.png',              'name' => 'Vision Plus Wealth',         'w' => 718, 'hh' => 234, 'h' => 44],
        ['file' => 'payhse.png',           'name' => 'Payhouse Finance',           'w' => 722, 'hh' => 296, 'h' => 58],
        ['file' => 'BSlwebbold.png',       'name' => 'BSL Services',               'w' => 508, 'hh' => 219, 'h' => 56],
        ['file' => 'baardy.png',           'name' => 'Baardy Micro Capital',       'w' => 510, 'hh' => 151, 'h' => 46],
        ['file' => 'spring_kleaners.png',  'name' => 'Spring Kleaners',            'w' => 275, 'hh' => 200, 'h' => 54, 'dark' => true],
    ];
    $clientLogos = array_values(array_filter(
        $clientLogos,
        fn ($logo) => file_exists(public_path('assets/images/logo/clients/' . $logo['file']))
    ));
@endphp
<section class="lp-clients" aria-labelledby="clients-heading">
    <div class="lp-wrap">
        <h2 class="lp-clients__statement" id="clients-heading">
            Your whole business, connected.
            <span>From first enquiry to final payment.</span>
        </h2>

        <div class="lp-clients__strip">
            <span class="lp-clients__mark lp-clients__mark--tl" aria-hidden="true"></span>
            <span class="lp-clients__mark lp-clients__mark--tr" aria-hidden="true"></span>
            <span class="lp-clients__mark lp-clients__mark--bl" aria-hidden="true"></span>
            <span class="lp-clients__mark lp-clients__mark--br" aria-hidden="true"></span>

            <p class="lp-clients__label">Our clients</p>
            <ul class="lp-clients__logos" aria-label="Client businesses" style="--count: {{ count($clientLogos) }}">
                @foreach($clientLogos as $logo)
                <li class="{{ !empty($logo['dark']) ? 'is-light-mark' : '' }}" style="--h: {{ $logo['h'] }}px">
                    <img src="{{ asset('assets/images/logo/clients/' . $logo['file']) }}" alt="{{ $logo['name'] }}" width="{{ $logo['w'] }}" height="{{ $logo['hh'] }}" loading="lazy" decoding="async">
                </li>
                @endforeach
            </ul>
        </div>
        <p class="lp-clients__index" aria-hidden="true"><i></i>01 Clients</p>
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
