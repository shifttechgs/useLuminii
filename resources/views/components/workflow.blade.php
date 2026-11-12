@php
    $workflowSteps = [
        ['title' => 'Enquiry', 'detail' => 'Capture the request and the person behind it. Keep the next action visible.'],
        ['title' => 'Quote', 'detail' => 'Set out the scope, price and client decision against the same request.'],
        ['title' => 'Job', 'detail' => 'Carry the agreed work into a job. Assign the technician and schedule the visit.'],
        ['title' => 'Invoice', 'detail' => 'Create the invoice from the work. Keep the amount due connected to the client.'],
        ['title' => 'Payment', 'detail' => 'Record what has been paid and see what remains. Keep the history for next time.'],
    ];
@endphp

<section class="lp-workflow" id="workflow" aria-labelledby="workflow-heading">
    <div class="lp-wrap">
        <header class="lp-workflow__intro">
            <div>
                <div class="lp-workflow__label">Every workflow</div>
                <h2 id="workflow-heading">Every part of the job.<br><em>Connected.</em></h2>
            </div>
            <div class="lp-workflow__intro-side">
                <p>The details move with the work. Your team can follow the job from the first request to the final payment, with the client history always close by.</p>
                <a href="{{ url('/') }}#booking">See the whole flow <i class="ph ph-arrow-up-right" aria-hidden="true"></i></a>
            </div>
        </header>

        <ol class="lp-workflow__steps" aria-label="The five stages of a job">
            @foreach($workflowSteps as $step)
                <li>
                    <div class="lp-workflow__step-top"><span>/ 0{{ $loop->iteration }}</span><i class="ph {{ $loop->last ? 'ph-check' : 'ph-arrow-right' }}" aria-hidden="true"></i></div>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['detail'] }}</p>
                </li>
            @endforeach
        </ol>

        <div class="lp-workflow__record">
            <div class="lp-workflow__record-label">What stays connected</div>
            <ul aria-label="Shared context across the workflow"><li>Client details</li><li>Agreed scope</li><li>Job history</li><li>Payments</li></ul>
            <p>One continuous record of the work.</p>
        </div>
    </div>
</section>
