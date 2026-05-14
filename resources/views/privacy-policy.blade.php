@extends('layouts.app')

@section('title', 'Privacy Policy - useLuminii')
@section('description', 'Read the useLuminii privacy policy for how we collect, use, and protect personal and business information.')
@section('robots', 'index, follow')

@section('content')
<div class="lp">
    <section class="lp-ph">
        <div class="lp-wrap">
            <div class="lp-ph__inner">
                <div class="lp-section__label">Legal</div>
                <h1 class="lp-ph__h1">Privacy <em>Policy</em></h1>
                <p class="lp-ph__sub">How useLuminii collects, uses, and protects information submitted through this website and platform.</p>
            </div>
        </div>
    </section>

    <section class="lp-section lp-section--white">
        <div class="lp-wrap" style="max-width: 840px;">
            <div class="lp-legal">
                <h2>Information <em>we collect</em></h2>
                <p>We collect the information you provide when you submit a contact form, book a demo, or communicate with our team. This may include your name, email address, phone number, business details, and any information you choose to share about your operations.</p>

                <h2>How we <em>use information</em></h2>
                <p>We use this information to respond to enquiries, schedule demos, assess your business flow, deliver onboarding, and improve our services. We may also use submitted information for internal reporting, lead management, and customer support.</p>

                <h2>How we <em>protect information</em></h2>
                <p>We take reasonable technical and operational steps to protect personal and business information from unauthorized access, misuse, or disclosure. Access is limited to people who need the information to serve you.</p>

                <h2>Sharing <em>information</em></h2>
                <p>We do not sell your personal information. We may share information with trusted service providers who help us operate the website, deliver demos, communicate with customers, or support the platform.</p>

                <h2><em>Retention</em></h2>
                <p>We keep information for as long as it is reasonably required for sales, support, compliance, record-keeping, and service delivery purposes.</p>

                <h2>Your <em>rights</em></h2>
                <p>You may request access to, correction of, or deletion of your personal information where applicable. To make a request, contact us at <a href="mailto:hello@useluminii.com">hello@useluminii.com</a>.</p>

                <h2><em>Contact</em></h2>
                <p>If you have questions about this policy, contact useLuminii at <a href="mailto:hello@useluminii.com">hello@useluminii.com</a> or <a href="tel:+27814303023">+27 81 430 3023</a>.</p>
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
