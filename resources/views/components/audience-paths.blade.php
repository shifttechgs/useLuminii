@php
    $paths = [
        [
            'key'       => 'personal',
            'title'     => 'Your business.<br>Without the evening admin.',
            'who'       => 'For solo operators, freelancers and sole traders who do the work and run the business.',
            'benefits'  => ['Answer enquiries while you work.', 'Send quotes from your phone.', 'Invoice before the day gets away.'],
            'preview'   => ['My day', 'Personal workspace'],
            'rows'      => [
                ['Bathroom repair', 'Quote ready to send', '2,400', 'amount'],
                ['Garden maintenance', 'Invoice INV-018', 'Paid', 'status'],
            ],
            'href'      => route('personal'),
            'cta'       => 'Explore Personal',
        ],
        [
            'key'       => 'business',
            'title'     => 'A growing team.<br>One shared way of working.',
            'who'       => 'For service businesses bringing the office, technicians and clients into the same flow.',
            'benefits'  => ['Keep the office and technicians aligned.', 'Track quotes, schedules and job progress.', 'See payments and business performance.'],
            'preview'   => ['Team schedule', 'Business workspace'],
            'rows'      => [
                ['Water heater replacement', 'Thabo · Riverside', '11:00', 'time'],
                ['Maintenance visit', 'Lerato · Northside', '14:30', 'time'],
            ],
            'href'      => route('solutions.business-operating-system'),
            'cta'       => 'Explore Business',
        ],
    ];
@endphp

{{-- AUDIENCE PATHS: a two-row index. Hover or focus a row to unfold it;
     the first row starts open. Without JS (and on phones) both stay open. --}}
<section class="lp-paths" id="built-for" aria-labelledby="paths-heading">
    <div class="lp-wrap">
        <header class="lp-paths__intro">
            <div class="lp-section__label">One platform. Two ways to work.</div>
            <h2 id="paths-heading">Built for the way <em>you work.</em></h2>
            <p>Whether you run the jobs yourself or manage a growing team, keep the business moving from enquiry to payment.</p>
        </header>

        <ol class="lp-paths__index" data-paths>
            @foreach($paths as $i => $path)
            <li class="lp-paths__row lp-paths__row--{{ $path['key'] }}{{ $i === 0 ? ' is-open' : '' }}" data-paths-row>
                <div class="lp-paths__head">
                    <span class="lp-paths__num">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="lp-paths__title">
                        <a href="{{ $path['href'] }}" id="path-{{ $path['key'] }}">{!! $path['title'] !!}</a>
                    </h3>
                    <p class="lp-paths__who">{{ $path['who'] }}</p>
                    <span class="lp-paths__arrow" aria-hidden="true"><i class="ph ph-arrow-up-right"></i></span>
                </div>

                <div class="lp-paths__body">
                    <div class="lp-paths__body-inner">
                        <ul class="lp-paths__benefits">
                            @foreach($path['benefits'] as $benefit)
                            <li><i class="ph ph-check" aria-hidden="true"></i>{{ $benefit }}</li>
                            @endforeach
                        </ul>

                        <figure class="lp-paths__preview" aria-label="Illustrative {{ $path['key'] }} workspace">
                            <div class="lp-paths__preview-header"><span>{{ $path['preview'][0] }}</span><span>{{ $path['preview'][1] }}</span></div>
                            @foreach($path['rows'] as [$name, $meta, $value, $kind])
                            <div class="lp-paths__preview-row">
                                <span><strong>{{ $name }}</strong><small>{{ $meta }}</small></span>
                                <span class="lp-paths__{{ $kind }}">{{ $value }}</span>
                            </div>
                            @endforeach
                            <figcaption>Illustrative preview · Sample data</figcaption>
                        </figure>

                        <a href="{{ $path['href'] }}" class="lp-paths__link" tabindex="-1" aria-hidden="true">{{ $path['cta'] }} <i class="ph ph-arrow-right"></i></a>
                    </div>
                </div>
            </li>
            @endforeach
        </ol>
    </div>
</section>
