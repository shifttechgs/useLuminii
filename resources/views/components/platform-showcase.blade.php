@php
    $platformViews = [
        'enquiries' => ['title' => 'Enquiries', 'headline' => 'Know who needs a reply.', 'description' => 'Keep client details, requests and the next action together. Your team can pick up the conversation with the context already there.', 'icon' => 'ph-chat-circle-text'],
        'clients' => ['title' => 'Client history', 'headline' => 'The context stays with your business.', 'description' => 'Keep client details, requests and activity together, so the next person can pick up where the conversation left off.', 'icon' => 'ph-address-book'],
        'quotes' => ['title' => 'Quotes', 'headline' => 'See what is waiting on a yes.', 'description' => 'Build a quote, track its decision and keep the discussion against the client. An approved quote becomes the starting point for the job.', 'icon' => 'ph-file-text'],
        'jobs' => ['title' => 'Jobs', 'headline' => 'Give everyone the same plan.', 'description' => 'Bring the appointment, assigned technician and job status into one record. The office and the team work from the same information.', 'icon' => 'ph-calendar-check'],
        'payments' => ['title' => 'Payments', 'headline' => 'Know what is still outstanding.', 'description' => 'Connect the invoice to the work, record payments and see the remaining balance. Follow up with the full client history at hand.', 'icon' => 'ph-receipt'],
        'reports' => ['title' => 'Business reports', 'headline' => 'See the business behind the busy day.', 'description' => 'Bring revenue, expenses and outstanding invoices into view. Make the next decision with your business numbers in front of you.', 'icon' => 'ph-chart-line-up'],
    ];
@endphp

{{-- PLATFORM: one client record, six views. Chapters scroll on the left; the
     record window stays put on the right and follows the chapter in focus. --}}
<section class="lp-platform" id="features" aria-labelledby="platform-heading">
    <div class="lp-wrap">
        <header class="lp-platform__intro">
            <div class="lp-section__label">Built different</div>
            <h2 id="platform-heading">The details your business<br><em>cannot afford to miss.</em></h2>
            <p>From the first enquiry to the final payment, your team works from the same client history, schedule and next step.</p>
        </header>

        <div class="lp-platform__story" data-pf>
            <ol class="lp-platform__chapters">
                @foreach($platformViews as $key => $view)
                <li class="lp-platform__chapter{{ $loop->first ? ' is-active' : '' }}" data-pf-chapter="{{ $key }}">
                    <span class="lp-platform__num">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="lp-platform__chapter-copy">
                        <p class="lp-platform__kicker">{{ $view['title'] }}</p>
                        <h3>{{ $view['headline'] }}</h3>
                        <p>{{ $view['description'] }}</p>
                    </div>

                    {{-- small screens: each chapter carries its own view --}}
                    <figure class="lp-pf-window lp-pf-window--inline" aria-hidden="true">
                        <div class="lp-pf-window__bar"><span class="lp-pf-wordmark">use<strong>Luminii</strong></span><span>Workspace / {{ $view['title'] }}</span><span class="lp-pf-avatar">TN</span></div>
                        <div class="lp-pf-screen is-active">@include('components.partials.platform-screen', ['key' => $key, 'view' => $view])</div>
                    </figure>
                </li>
                @endforeach
            </ol>

            <div class="lp-platform__stage">
                <figure class="lp-pf-window lp-pf-window--stage">
                    <div class="lp-pf-window__bar">
                        <span class="lp-pf-wordmark">use<strong>Luminii</strong></span>
                        <span>Workspace / <b data-pf-crumb>{{ reset($platformViews)['title'] }}</b></span>
                        <span class="lp-pf-avatar">TN</span>
                    </div>
                    <div class="lp-pf-window__body">
                        <nav class="lp-pf-nav" aria-label="Product views">
                            @foreach($platformViews as $key => $view)
                            <button type="button" class="lp-pf-nav__item{{ $loop->first ? ' is-active' : '' }}" data-pf-nav="{{ $key }}">
                                <i class="ph {{ $view['icon'] }}" aria-hidden="true"></i><span>{{ $view['title'] }}</span>
                            </button>
                            @endforeach
                        </nav>
                        <div class="lp-pf-screens">
                            @foreach($platformViews as $key => $view)
                            <div class="lp-pf-screen{{ $loop->first ? ' is-active' : '' }}" data-pf-screen="{{ $key }}">
                                @include('components.partials.platform-screen', ['key' => $key, 'view' => $view])
                            </div>
                            @endforeach
                        </div>
                    </div>
                </figure>
                <p class="lp-platform__caption">Illustrative preview · sample business and client data</p>
            </div>
        </div>

        <div class="lp-platform__footer">
            <p>One client record. <em>The whole job history.</em></p>
            <a href="{{ url('/') }}#booking">See it in a demo <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>
