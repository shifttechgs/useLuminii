@php
    // Each circle: the figure and what it counts. dx/dy = the direction it drifts in from before the circles connect.
    $impactItems = [
        ['n' => 1, 'label' => 'Client record. <br>The full conversation.',            'dx' => -1, 'dy' => -1],
        ['n' => 4, 'label' => 'Connected stages. <br>Enquiry to invoice.',             'dx' =>  1, 'dy' => -1],
        ['n' => 3, 'label' => 'Revenue, expenses <br>and outstanding balances.',       'dx' => -1, 'dy' =>  1],
        ['n' => 1, 'label' => 'Shared job record. <br>The same plan for everyone.',    'dx' =>  1, 'dy' =>  1],
    ];
@endphp
<section class="lp-impact" id="impact" aria-labelledby="impact-heading">
    <div class="lp-wrap lp-impact__layout">
        <header class="lp-impact__intro">
            <div class="lp-section__label">The impact</div>
            <h2 id="impact-heading"><span>Less chasing.</span> <br>More control <br>over the day.</h2>
            <p>Client details, job progress and the money behind the work, connected. So your team can see what needs attention and keep the next step moving.</p>
        </header>

        <div class="lp-impact__field" data-impact>
            <dl class="lp-impact__numbers">
                @foreach($impactItems as $i => $item)
                <div class="lp-impact__item" data-impact-item style="--i: {{ $i }}; --dx: {{ $item['dx'] }}; --dy: {{ $item['dy'] }}; --n: {{ $item['n'] }}">
                    <dt>{!! $item['label'] !!}</dt>
                    <dd>
                        <span class="lp-impact__sr">{{ $item['n'] }}</span>
                        {{-- odometer reel: 0-9 twice, lands on the second pass so it always makes a full spin --}}
                        <span class="lp-impact__odo" aria-hidden="true"><span class="lp-impact__reel">@for($pass = 0; $pass < 2; $pass++)@for($d = 0; $d <= 9; $d++)<span>{{ $d }}</span>@endfor @endfor</span></span>
                    </dd>
                </div>
                @endforeach
            </dl>
            {{-- the four points where the circles touch --}}
            <span class="lp-impact__node lp-impact__node--t" aria-hidden="true"></span>
            <span class="lp-impact__node lp-impact__node--r" aria-hidden="true"></span>
            <span class="lp-impact__node lp-impact__node--b" aria-hidden="true"></span>
            <span class="lp-impact__node lp-impact__node--l" aria-hidden="true"></span>
        </div>
    </div>
</section>
