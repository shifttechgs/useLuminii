@php
    $executionGaps = [
        [
            'icon' => 'ph-phone-incoming',
            'title' => 'A new enquiry comes in',
            'kicker' => 'Response time',
            'before' => 'You are on-site. By the time you reply, the client has called someone else.',
            'after' => 'Every enquiry is answered, qualified and routed while you are doing the work.',
            'before_status' => 'Reply pending',
            'after_status' => 'Site visit booked',
        ],
        [
            'icon' => 'ph-file-text',
            'title' => 'A quote needs a decision',
            'kicker' => 'Follow-through',
            'before' => 'The quote is sent, then disappears into WhatsApp, email and a busy week.',
            'after' => 'Quotes are sent professionally and followed up until the client decides.',
            'before_status' => 'No follow-up scheduled',
            'after_status' => 'Follow-up queued',
        ],
        [
            'icon' => 'ph-calendar-check',
            'title' => 'The day changes on the move',
            'kicker' => 'Job coordination',
            'before' => 'The office, technician and client all have a different version of the schedule.',
            'after' => 'One live job record keeps the whole team and the client up to date.',
            'before_status' => 'Schedule conflict',
            'after_status' => 'Team updated',
        ],
        [
            'icon' => 'ph-receipt',
            'title' => 'The job is complete',
            'kicker' => 'Cash flow',
            'before' => 'The invoice and payment reminder happen days later, if they happen at all.',
            'after' => 'Invoices go out promptly and payment follow-up is already in motion.',
            'before_status' => 'Invoice not sent',
            'after_status' => 'Payment reminder set',
        ],
    ];
@endphp

<!-- EXECUTION GAP -->
<section class="lp-gap" id="pain">
    <div class="lp-wrap">
        <header class="lp-gap__stack-intro" data-aos="fade-up">
            <div class="lp-section__label">The execution gap</div>
            <div class="lp-gap__stack-intro-grid">
                <h2 class="lp-gap__h2">The work gets done.<br><em>The follow-through doesn't.</em></h2>
                <p class="lp-gap__sub">When enquiries, quotes, jobs and payments live across calls, WhatsApp and spreadsheets, good work still falls through the cracks.</p>
            </div>
        </header>

        <div class="lp-gap__stack" data-gap-stack>
            <div class="lp-gap__stack-stage">
                @foreach($executionGaps as $index => $gap)
                <article class="lp-gap__stack-card{{ $index === 0 ? ' is-active' : '' }}" data-gap-stack-card="{{ $index }}" style="--stack-index: {{ $index }}">
                    <div class="lp-gap__stack-content">
                        <div>
                            <div class="lp-gap__stack-meta">
                                <span>/{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }} <span>/ 04</span></span>
                                <span>{{ $gap['kicker'] }}</span>
                            </div>
                            <h3>{{ $gap['title'] }}</h3>
                        </div>

                        <div class="lp-gap__stack-copy">
                            <div class="lp-gap__stack-copy-row lp-gap__stack-copy-row--before">
                                <span><i class="ph ph-warning-circle"></i> Without a flow</span>
                                <p>{{ $gap['before'] }}</p>
                            </div>
                            <div class="lp-gap__stack-copy-row lp-gap__stack-copy-row--after">
                                <span><i class="ph ph-check-circle"></i> With useLuminii</span>
                                <p>{{ $gap['after'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="lp-gap__stack-visual" aria-hidden="true">
                        <div class="lp-gap__visual-top">
                            <span class="lp-gap__icon"><i class="ph {{ $gap['icon'] }}"></i></span>
                            <span>Live business flow</span>
                            <span class="lp-gap__visual-time">Today</span>
                        </div>
                        <div class="lp-gap__visual-states">
                            <div class="lp-gap__visual-state lp-gap__visual-state--before">
                                <span>Without a flow</span>
                                <strong>{{ $gap['before_status'] }}</strong>
                                <i class="ph ph-warning-circle"></i>
                            </div>
                            <div class="lp-gap__visual-line"><span></span></div>
                            <div class="lp-gap__visual-state lp-gap__visual-state--after">
                                <span>useLuminii</span>
                                <strong>{{ $gap['after_status'] }}</strong>
                                <i class="ph ph-check-circle"></i>
                            </div>
                        </div>
                        <div class="lp-gap__visual-footer"><span>Client</span><span>Team</span><span>Office</span></div>
                    </div>

                    <div class="lp-gap__stack-shade" aria-hidden="true"></div>
                </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
