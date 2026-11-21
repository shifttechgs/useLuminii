@php
    $workflowSteps = ['Enquiry', 'Quote', 'Job', 'Invoice', 'Payment'];
    $connected = ['Client details', 'Agreed scope', 'Job history', 'Payments'];
@endphp

{{-- WORKFLOW: one oversized line of the job's stages that slides sideways as
     the page scrolls; the stage crossing the centre lights up gold.
     JS adds .is-kinetic; without it (or with reduced motion) the line wraps statically. --}}
<section class="lp-workflow" id="workflow" aria-labelledby="workflow-heading">
    <div class="lp-wrap">
        <header class="lp-workflow__intro">
            <div>
                <div class="lp-workflow__label">Every workflow</div>
                <h2 id="workflow-heading">Every part of the job. <em>Connected.</em></h2>
            </div>
            <div class="lp-workflow__intro-side">
                <p>The details move with the work. Your team can follow the job from the first request to the final payment, with the client history always close by.</p>
                <a href="{{ url('/') }}#booking">See the whole flow <i class="ph ph-arrow-up-right" aria-hidden="true"></i></a>
            </div>
        </header>
    </div>

    <ol class="lp-workflow__sr" aria-label="The five stages of a job">
        @foreach($workflowSteps as $step)<li>{{ $step }}</li>@endforeach
    </ol>

    <div class="lp-workflow__band" data-flow aria-hidden="true">
        <div class="lp-workflow__track" data-flow-track>
            @for($pass = 0; $pass < 3; $pass++)
                @foreach($workflowSteps as $step)
                <span class="lp-workflow__word{{ $pass > 0 ? ' is-repeat' : '' }}" data-flow-word>{{ $step }}</span>
                <span class="lp-workflow__sep{{ $pass > 0 ? ' is-repeat' : '' }}"><i class="ph ph-arrow-right"></i></span>
                @endforeach
            @endfor
        </div>
    </div>

    <div class="lp-wrap">
        <div class="lp-workflow__record">
            <p class="lp-workflow__record-label">What stays connected</p>
            <ul aria-label="Shared context across the workflow">
                @foreach($connected as $item)<li>{{ $item }}</li>@endforeach
            </ul>
            <p class="lp-workflow__record-note">One continuous record of the work.</p>
        </div>
    </div>
</section>
