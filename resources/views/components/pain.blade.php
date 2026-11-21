@php
    $executionGaps = [
        [
            'stage'        => 'Enquiry',
            'icon'         => 'ph-phone-incoming',
            'kicker'       => 'Response time',
            'title'        => 'A new enquiry comes in',
            'before'       => 'You are on-site. By the time you reply, the client has called someone else.',
            'after'        => 'Every enquiry is answered, qualified and routed while you are doing the work.',
            'ref'          => 'ENQ-0482',
            'time'         => '09:14',
            'client'       => 'Thandi Mokoena',
            'detail'       => 'Water heater replacement · Lakeview',
            'before_status'=> 'Reply pending',
            'before_meta'  => 'Unanswered for 3h 12m',
            'after_status' => 'Site visit booked',
            'after_meta'   => 'Answered in 2 min · Thu 10:00',
        ],
        [
            'stage'        => 'Quote',
            'icon'         => 'ph-file-text',
            'kicker'       => 'Follow-through',
            'title'        => 'A quote needs a decision',
            'before'       => 'The quote is sent, then disappears into WhatsApp, email and a busy week.',
            'after'        => 'Quotes are sent professionally and followed up until the client decides.',
            'ref'          => 'QUO-1137',
            'time'         => 'Mon',
            'client'       => 'Brightside Dental',
            'detail'       => 'Aircon service contract · 18,400',
            'before_status'=> 'No follow-up',
            'before_meta'  => 'Sent 9 days ago · no reply',
            'after_status' => 'Quote accepted',
            'after_meta'   => 'Reminder on day 3 · signed day 5',
        ],
        [
            'stage'        => 'Job',
            'icon'         => 'ph-calendar-check',
            'kicker'       => 'Job coordination',
            'title'        => 'The day changes on the move',
            'before'       => 'The office, technician and client all have a different version of the schedule.',
            'after'        => 'One live job record keeps the whole team and the client up to date.',
            'ref'          => 'JOB-2290',
            'time'         => '11:40',
            'client'       => 'Unit 4, Harbour View',
            'detail'       => 'Leak repair · moved to 14:30',
            'before_status'=> 'Schedule conflict',
            'before_meta'  => 'Three versions of the day',
            'after_status' => 'Everyone updated',
            'after_meta'   => 'Office, technician and client notified',
        ],
        [
            'stage'        => 'Invoice',
            'icon'         => 'ph-receipt',
            'kicker'       => 'Cash flow',
            'title'        => 'The job is complete',
            'before'       => 'The invoice and payment reminder happen days later, if they happen at all.',
            'after'        => 'Invoices go out promptly and payment follow-up is already in motion.',
            'ref'          => 'INV-0917',
            'time'         => '16:05',
            'client'       => 'Kruger & Sons',
            'detail'       => '6,250 · due on completion',
            'before_status'=> 'Still in drafts',
            'before_meta'  => 'Job finished 6 days ago',
            'after_status' => 'Invoice sent',
            'after_meta'   => 'Same day · reminder set for day 7',
        ],
    ];
    $gapTotal = str_pad((string) count($executionGaps), 2, '0', STR_PAD_LEFT);
@endphp

<!-- EXECUTION GAP: each moment shows the slip, then closes it as you scroll -->
<section class="lp-gap" id="pain" aria-labelledby="lp-gap-title">
    <div class="lp-wrap">
        <header class="lp-gap__intro">
            <div class="lp-section__label">The execution gap</div>
            <h2 class="lp-gap__h2" id="lp-gap-title">The work gets done.<br><em>The follow-through doesn't.</em></h2>
            <div class="lp-gap__intro-foot">
                <p class="lp-gap__sub">When enquiries, quotes, jobs and payments live across calls, WhatsApp and spreadsheets, good work still falls through the cracks.</p>
                <p class="lp-gap__count"><span>{{ $gapTotal }}</span> moments where it slips</p>
            </div>
        </header>
    </div>

    <div class="lp-gap__track" data-gap>
        <div class="lp-gap__pin">
            <div class="lp-wrap lp-gap__frame">
                <ol class="lp-gap__rail" aria-hidden="true">
                    @foreach($executionGaps as $index => $gap)
                    <li class="lp-gap__rail-step{{ $index === 0 ? ' is-active' : '' }}" data-gap-step="{{ $index }}">
                        <span class="lp-gap__rail-num">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="lp-gap__rail-name">{{ $gap['stage'] }}</span>
                        <span class="lp-gap__rail-bar"><span></span></span>
                    </li>
                    @endforeach
                </ol>

                <div class="lp-gap__scenes">
                    @foreach($executionGaps as $index => $gap)
                    <article class="lp-gap__scene{{ $index === 0 ? ' is-active' : '' }}" data-gap-scene="{{ $index }}">
                        <div class="lp-gap__copy">
                            <p class="lp-gap__kicker">
                                <span>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                {{ $gap['kicker'] }}
                            </p>
                            <h3 class="lp-gap__title">{{ $gap['title'] }}</h3>

                            <div class="lp-gap__lines">
                                <div class="lp-gap__line lp-gap__line--before">
                                    <span class="lp-gap__line-label">Without a flow</span>
                                    <p><span>{{ $gap['before'] }}</span></p>
                                </div>
                                <div class="lp-gap__line lp-gap__line--after">
                                    <span class="lp-gap__line-label">With useLuminii</span>
                                    <p>{{ $gap['after'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="lp-gap__record" aria-hidden="true">
                            <div class="lp-gap__ticket">
                                <div class="lp-gap__ticket-head">
                                    <span class="lp-gap__ticket-icon"><i class="ph {{ $gap['icon'] }}"></i></span>
                                    <span class="lp-gap__ticket-ref">{{ $gap['ref'] }}</span>
                                    <span class="lp-gap__ticket-time">{{ $gap['time'] }}</span>
                                </div>
                                <p class="lp-gap__ticket-client">{{ $gap['client'] }}</p>
                                <p class="lp-gap__ticket-detail">{{ $gap['detail'] }}</p>

                                <div class="lp-gap__ticket-cut"></div>

                                <div class="lp-gap__status">
                                    <div class="lp-gap__status-state lp-gap__status-state--before">
                                        <span class="lp-gap__dot"></span>
                                        <strong>{{ $gap['before_status'] }}</strong>
                                        <small>{{ $gap['before_meta'] }}</small>
                                    </div>
                                    <div class="lp-gap__status-state lp-gap__status-state--after">
                                        <span class="lp-gap__dot"></span>
                                        <strong>{{ $gap['after_status'] }}</strong>
                                        <small>{{ $gap['after_meta'] }}</small>
                                    </div>
                                </div>

                                <span class="lp-gap__stamp">Handled</span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
