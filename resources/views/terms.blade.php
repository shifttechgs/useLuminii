@extends('layouts.app')

@section('title', 'Terms of Service - useLuminii')
@section('description', 'Read the basic terms of service for useLuminii website use, demo requests, and platform engagement.')
@section('robots', 'index, follow')

@section('content')
<div class="lp">
    <section class="lp-ph">
        <div class="lp-wrap">
            <div class="lp-ph__inner">
                <div class="lp-section__label">Legal</div>
                <h1 class="lp-ph__h1">Terms of <em>Service</em></h1>
                <p class="lp-ph__sub">Basic terms governing use of the useLuminii website, demo requests, and service engagement.</p>
            </div>
        </div>
    </section>

    <section class="lp-section lp-section--white">
        <div class="lp-wrap" style="max-width: 840px;">
            <div class="lp-legal">
                <h2>Website <em>use</em></h2>
                <p>By using this website, you agree to use it lawfully and not to interfere with its operation, security, or availability.</p>

                <h2>Information <em>submitted</em></h2>
                <p>When you submit a form or book a demo, you confirm that the information you provide is accurate to the best of your knowledge and that you are authorized to share it.</p>

                <h2>Service <em>discussions</em></h2>
                <p>Demo calls, proposals, onboarding discussions, and pricing conversations are provided for evaluation and planning purposes. Final deliverables, scope, timing, pricing, and support commitments are confirmed separately in writing.</p>

                <h2>Intellectual <em>property</em></h2>
                <p>All content, branding, design elements, and platform materials on this website remain the property of useLuminii or its licensors unless otherwise stated.</p>

                <h2>No guarantee <em>of results</em></h2>
                <p>Operational and financial results depend on your business model, responsiveness, team adoption, and implementation scope. We do not guarantee specific revenue, profit, or growth outcomes.</p>

                <h2><em>Availability</em></h2>
                <p>We may update, suspend, or change parts of the website or service offering from time to time as the business evolves.</p>

                <h2><em>Contact</em></h2>
                <p>If you have questions about these terms, contact useLuminii at <a href="mailto:hello@useluminii.com">hello@useluminii.com</a> or <a href="tel:+27814303023">+27 81 430 3023</a>.</p>
            </div>
        </div>
    </section>
</div>
@endsection

@push('head-styles')
<style>
.lp-ph {
    background: #060F1E;
    padding: 120px 0 80px;
    text-align: center;
    position: relative;
}
.lp-ph::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
}
.lp-ph__inner { position: relative; z-index: 2; }
.lp-ph__h1 {
    font-family: "Geist", system-ui, sans-serif;
    font-size: clamp(36px, 5vw, 60px);
    font-weight: 800;
    letter-spacing: -0.035em;
    line-height: 1.1;
    color: #fff;
    margin-bottom: 20px;
}
.lp-ph__h1 em {
    font-style: normal;
    color: rgba(255,255,255,0.45);
}
.lp-ph__sub {
    font-size: 17px;
    line-height: 1.65;
    color: rgba(255,255,255,0.6);
    max-width: 620px;
    margin: 0 auto;
}
.lp-section--white { background: #fff; }
.lp-legal {
    padding: 72px 0;
    color: #081D3A;
}
.lp-legal h2 {
    font-family: "Geist", system-ui, sans-serif;
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 14px;
}
.lp-legal h2 em {
    font-style: normal;
    color: #647082;
}
.lp-legal p {
    font-size: 15px;
    line-height: 1.8;
    color: #647082;
    margin: 0 0 28px;
}
.lp-legal a {
    color: #081D3A;
    text-decoration: underline;
}
</style>
@endpush
