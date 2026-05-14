@extends("layouts.master")
@push('styles')
    <link rel="stylesheet" href="assets/css/work-portfolio.css">
@endpush
@section("content")

    <!-- ==================== Hero Section ==================== -->
    <section class="work-hero">

        <img src="assets/images/shapes/sqaure_shape.png"
             alt="Shape"
             class="position-absolute top-0 tw-end-0 tw-me-12-percent"
             style="filter: brightness(50%); opacity: 0.2;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                <span class="work-hero__badge" data-aos="fade-down" data-aos-duration="800">
                    <i class=""></i> Custom Software Development Agency
                </span>
                    <h1 class="work-hero__title" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        Building Software For Fast-Moving Companies.
                    </h1>
                    <p class="work-hero__subtitle" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        While others hide behind buzzwords, we focus on execution.
                        MVPs in weeks. Scalable platforms for teams that are ready to grow.
                    </p>

                    <!-- Stats Pills -->
                    <div class="work-hero__stats" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="stat-pill">
                            <i class="ph-bold ph-rocket-launch"></i>
                            <span>150+ Projects</span>
                        </div>
                        <div class="stat-pill">
                            <i class="ph-bold ph-users-three"></i>
                            <span>98% Satisfaction</span>
                        </div>
                        <div class="stat-pill">
                            <i class="ph-bold ph-clock"></i>
                            <span>24hr Response</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<!-- Who We Are -->
<section style="background: white; padding: 120px 0;">
    <div class="container"
         style="border-radius: 16px; background: #ffffff; padding: 60px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">

        <div class="row">
            <div class="col-lg-5 mb-5 mb-lg-0">
                <h2 style="color: #0f1419; font-size: 48px; line-height: 1.2; font-weight: 700; margin-bottom: 32px;">
                    Who we are
                </h2>

                <p style="color: #666; font-size: 18px; line-height: 1.7; margin-bottom: 24px;">
                    We're a software agency based in Cape Town and Harare. We work with startups burning through runway, SMEs stuck with legacy systems, and enterprises that need to ship yesterday.
                </p>

                <p style="color: #666; font-size: 18px; line-height: 1.7; margin-bottom: 24px;">
                    Founded by <strong>Prosper</strong> after watching too many good ideas die because agencies were either too expensive, too slow, or both. We decided to do better.
                </p>

                <p style="color: #666; font-size: 18px; line-height: 1.7;">
                    Now we're the team that helps companies move from PowerPoint to production in weeks, not quarters.
                </p>
            </div>

            <div class="col-lg-6 offset-lg-1">
                <div style="background: #f8f9fa; padding: 48px; border-left: 4px solid #74b812; border-radius: 12px;">

                    <h3 style="color: #0f1419; font-size: 24px; font-weight: 700; margin-bottom: 24px;">
                        What we believe
                    </h3>

                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="color: #666; font-size: 16px; line-height: 1.8; margin-bottom: 16px; padding-left: 28px; position: relative;">
                            <span style="position: absolute; left: 0; color: #74b812; font-weight: 700;">→</span>
                            Speed matters more than perfection. Ship it, then iterate.
                        </li>

                        <li style="color: #666; font-size: 16px; line-height: 1.8; margin-bottom: 16px; padding-left: 28px; position: relative;">
                            <span style="position: absolute; left: 0; color: #74b812; font-weight: 700;">→</span>
                            Code should solve problems, not showcase frameworks.
                        </li>

                        <li style="color: #666; font-size: 16px; line-height: 1.8; margin-bottom: 16px; padding-left: 28px; position: relative;">
                            <span style="position: absolute; left: 0; color: #74b812; font-weight: 700;">→</span>
                            Transparent pricing. No "it depends" or scope creep.
                        </li>

                        <li style="color: #666; font-size: 16px; line-height: 1.8; margin-bottom: 16px; padding-left: 28px; position: relative;">
                            <span style="position: absolute; left: 0; color: #74b812; font-weight: 700;">→</span>
                            Talk to developers, not account managers.
                        </li>

                        <li style="color: #666; font-size: 16px; line-height: 1.8; padding-left: 28px; position: relative;">
                            <span style="position: absolute; left: 0; color: #74b812; font-weight: 700;">→</span>
                            You own your code. Always. No lock-in.
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- What We Roll Our Eyes At -->
<section style="background: linear-gradient(135deg, #002b22 0%, #002b22 100%); padding: 120px 0;">
    <div class="container">

        <div class="row">
            <div class="col-lg-10">
                <h2 style="color: white; font-size: 48px; line-height: 1.2; font-weight: 700; margin-bottom: 48px;">
                    What we roll our eyes at
                </h2>
            </div>
        </div>

        <div class="row g-4">

            <!-- Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div style="
                    padding: 32px;
                    background: rgba(255,255,255,0.05);
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 14px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                ">
                    <h4 class="quote-title">
                        We need to align stakeholders first
                    </h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 16px; line-height: 1.6; margin: 0;">
                        By the time you've had 6 meetings, your competitor shipped. Start building, iterate with real users.
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div style="
                    padding: 32px;
                    background: rgba(255,255,255,0.05);
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 14px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                ">
                    <h4 class="quote-title">
                        Let's add AI to everything
                    </h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 16px; line-height: 1.6; margin: 0;">
                        AI is a tool, not a strategy. We build AI features when they solve real problems, not for the press release.
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div style="
                    padding: 32px;
                    background: rgba(255,255,255,0.05);
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 14px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                ">
                    <h4 class="quote-title">
                        We need enterprise-grade from day one
                    </h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 16px; line-height: 1.6; margin: 0;">
                        You have 10 users. You don't need Kubernetes. Build for today, architect for tomorrow.
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div style="
                    padding: 32px;
                    background: rgba(255,255,255,0.05);
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 14px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                ">
                    <h4 class="quote-title">
                        Can you make it pop?
                    </h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 16px; line-height: 1.6; margin: 0;">
                        We design interfaces that work, not ones that "pop." Clean, fast, intuitive. That's it.
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div style="
                    padding: 32px;
                    background: rgba(255,255,255,0.05);
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 14px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                ">
                    <h4 class="quote-title">
                        Agile ceremonies are essential
                    </h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 16px; line-height: 1.6; margin: 0;">
                        We do weekly demos and daily check-ins. That's it. No retrospectives on our retrospectives.
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div style="
                    padding: 32px;
                    background: rgba(255,255,255,0.05);
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 14px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                ">
                    <h4 class="quote-title">
                        Budget? It depends...
                    </h4>
                    <p style="color: rgba(255,255,255,0.65); font-size: 16px; line-height: 1.6; margin: 0;">
                        We give you a number upfront. Fixed scope, fixed price. Changes? New quote. Simple.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Clients -->
<section style="background: white; padding: 120px 0;">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8">
                <h2 style="color: #0f1419; font-size: 48px; line-height: 1.2; font-weight: 700; margin-bottom: 24px;">
                    Trusted by teams across Africa and beyond
                </h2>
                <p style="color: #666; font-size: 18px; line-height: 1.7;">
                    From funded startups to government institutions, we work with companies that value speed and quality.
                </p>
            </div>
        </div>
        <div class="row g-4 align-items-center" style="opacity: 0.6;">
            <div class="col-6 col-md-4 col-lg-3 text-center">
                <img src="assets/images/logo/clients/wcbs_header_logo.png" alt="WesternCape Blood Service" style="max-height: 50px; max-width: 100%; filter: grayscale(100%);">
            </div>
            <div class="col-6 col-md-4 col-lg-3 text-center">
                <img src="assets/images/logo/clients/vpw.png" alt="Vision Plus Wealth" style="max-height: 50px; max-width: 100%; filter: grayscale(100%);">
            </div>
            <div class="col-6 col-md-4 col-lg-3 text-center">
                <img src="assets/images/logo/clients/payhse.png" alt="Payhouse Finance" style="max-height: 50px; max-width: 100%; filter: grayscale(100%);">
            </div>
            <div class="col-6 col-md-4 col-lg-3 text-center">
                <img src="assets/images/logo/clients/BSlwebbold.png" alt="BSL Services" style="max-height: 50px; max-width: 100%; filter: grayscale(100%);">
            </div>
            <div class="col-6 col-md-4 col-lg-3 text-center">
                <img src="assets/images/logo/clients/logo.png" alt="Ray & Sons Plumbing" style="max-height: 50px; max-width: 100%; filter: grayscale(100%);">
            </div>
            <div class="col-6 col-md-4 col-lg-3 text-center">
                <img src="assets/images/logo/clients/useluminii_logo.png" alt="UseLuminii" style="max-height: 50px; max-width: 100%; filter: grayscale(100%);">
            </div>
            <div class="col-6 col-md-4 col-lg-3 text-center">
                <img src="assets/images/logo/clients/nhume_logo.png" alt="Nhume" style="max-height: 50px; max-width: 100%; filter: grayscale(100%);">
            </div>
            <div class="col-6 col-md-4 col-lg-3 text-center">
                <img src="assets/images/logo/clients/trax_boats.png" alt="Trax Boats" style="max-height: 50px; max-width: 100%; filter: grayscale(100%);">
            </div>
        </div>
    </div>
</section>

<!-- Case Study Feature -->
<section style="background: #f8f9fa; padding: 120px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div style="background: linear-gradient(135deg, #002b22 0%, #002b22 100%); padding: 40px; border-radius: 10px; position: relative;">
                    <div style="position: absolute; top: -20px; left: -20px; width: 60px; height: 60px; background: #74b812;"></div>
                    <p style="color: #74b812; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;">Case Study</p>
                    <h3 style="color: white; font-size: 32px; font-weight: 700; line-height: 1.3; margin-bottom: 24px;">
                        We helped WesternCape Blood Service cut processing time by 75%
                    </h3>
                    <p style="color: rgba(255,255,255,0.7); font-size: 16px; line-height: 1.7; margin-bottom: 32px;">
                        Their background services were failing silently. We built a real-time monitoring system with AI-powered alerts. What they estimated would take 6 months, we delivered in 6 weeks.
                    </p>
                    <a href="{{ url('/contact') }}" style="color: #74b812; font-size: 16px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center;">
                        Book Your Free Discovery Call <i class="ph-bold ph-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div style="border-left: 4px solid #74b812; padding-left: 32px;">
                    <p style="color: #0f1419; font-size: 72px; font-weight: 700; line-height: 1; margin-bottom: 8px;">4x</p>
                    <p style="color: #666; font-size: 18px; margin-bottom: 40px;">Faster than their internal estimate</p>

                    <p style="color: #0f1419; font-size: 72px; font-weight: 700; line-height: 1; margin-bottom: 8px;">75%</p>
                    <p style="color: #666; font-size: 18px; margin-bottom: 40px;">Reduction in processing time</p>

                    <p style="color: #0f1419; font-size: 72px; font-weight: 700; line-height: 1; margin-bottom: 8px;">100%</p>
                    <p style="color: #666; font-size: 18px; margin-bottom: 0;">Service uptime since launch</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How We Work -->
<section style="background: white; padding: 120px 0;">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-6">
                <h2 style="color: #0f1419; font-size: 48px; line-height: 1.2; font-weight: 700; margin-bottom: 24px;">
                    How we work
                </h2>
                <p style="color: #666; font-size: 18px; line-height: 1.7;">
                    No 47-page proposals. No "it's in the backlog." Here's how we actually operate.
                </p>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-md-6">
                <div style="border-bottom: 2px solid #74b812; padding-bottom: 24px; margin-bottom: 24px;">
                    <h3 style="color: #0f1419; font-size: 28px; font-weight: 700; margin-bottom: 16px;">Week 0: Discovery</h3>
                </div>
                <p style="color: #666; font-size: 16px; line-height: 1.7; margin-bottom: 16px;">
                    One 30-minute call. We listen to what you need, ask the questions others don't, and tell you if we're the right fit.
                </p>
                <p style="color: #666; font-size: 16px; line-height: 1.7;">
                    Within 48 hours: Fixed quote, timeline, and what exactly you're getting. No "ballpark estimates."
                </p>
            </div>
            <div class="col-md-6">
                <div style="border-bottom: 2px solid #74b812; padding-bottom: 24px; margin-bottom: 24px;">
                    <h3 style="color: #0f1419; font-size: 28px; font-weight: 700; margin-bottom: 16px;">Weeks 1-N: Build</h3>
                </div>
                <p style="color: #666; font-size: 16px; line-height: 1.7; margin-bottom: 16px;">
                    Weekly demos. You see progress every Friday. Something wrong? We fix it before next week.
                </p>
                <p style="color: #666; font-size: 16px; line-height: 1.7;">
                    Direct Slack/WhatsApp access to your dev team. Questions answered in hours, not days.
                </p>
            </div>
            <div class="col-md-6">
                <div style="border-bottom: 2px solid #74b812; padding-bottom: 24px; margin-bottom: 24px;">
                    <h3 style="color: #0f1419; font-size: 28px; font-weight: 700; margin-bottom: 16px;">Launch Week</h3>
                </div>
                <p style="color: #666; font-size: 16px; line-height: 1.7; margin-bottom: 16px;">
                    We deploy to production, set up monitoring, hand over documentation, and train your team.
                </p>
                <p style="color: #666; font-size: 16px; line-height: 1.7;">
                    You get: Source code, deployment scripts, architecture docs, and admin credentials. It's yours.
                </p>
            </div>
            <div class="col-md-6">
                <div style="border-bottom: 2px solid #74b812; padding-bottom: 24px; margin-bottom: 24px;">
                    <h3 style="color: #0f1419; font-size: 28px; font-weight: 700; margin-bottom: 16px;">Post-Launch</h3>
                </div>
                <p style="color: #666; font-size: 16px; line-height: 1.7; margin-bottom: 16px;">
                    30 days of free support. Bug fixes, deployment issues, "how do I..." questions—all covered.
                </p>
                <p style="color: #666; font-size: 16px; line-height: 1.7;">
                    Need ongoing work? Monthly retainers start at $5k. Cancel anytime.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section style="background: linear-gradient(135deg, #002b22 0%, #002b22 100%); padding: 120px 0;">
    <div class="container">

        <div class="row mb-5">
            <div class="col-lg-8">
                <h2 style="color: white; font-size: 48px; line-height: 1.2; font-weight: 700; margin-bottom: 24px;">
                    Small team, big impact
                </h2>
                <p style="color: rgba(255,255,255,0.7); font-size: 18px; line-height: 1.7;">
                    No "talent acquisition specialists" or "growth hackers." Just developers, designers, and one person who makes sure we get paid on time.
                </p>
            </div>
        </div>

        <div class="row g-4">

            <!-- Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div style="
                    background: rgba(255,255,255,0.05);
                    padding: 32px;
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 10px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                ">
                    <div style="
                        width: 60px;
                        height: 60px;
                        background: #74b812;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 24px;
                        font-weight: 700;
                        color: #0f1419;
                        margin-bottom: 20px;
                        border-radius: 8px;
                    ">P</div>

                    <h4 style="color: white; font-size: 20px; font-weight: 700; margin-bottom: 8px;">
                        Prosper
                    </h4>
                    <p style="color: rgba(255,255,255,0.5); font-size: 14px; margin-bottom: 16px;">
                        Systems Designer
                    </p>
                    <p style="color: rgba(255,255,255,0.7); font-size: 14px; line-height: 1.6;">
                        Turns messy ideas into systems that actually work. Obsessed with clean architecture and shipping fast. Believes good design should be invisible. Great systems should feel effortless. Still writes code daily because real builders don’t hide behind slides.
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div style="
                    background: rgba(255,255,255,0.05);
                    padding: 32px;
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 10px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                ">
                    <div style="
                        width: 60px;
                        height: 60px;
                        background: #74b812;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 24px;
                        font-weight: 700;
                        color: #0f1419;
                        margin-bottom: 20px;
                        border-radius: 8px;
                    ">T</div>

                    <h4 style="color: white; font-size: 20px; font-weight: 700; margin-bottom: 8px;">
                        Tinashe
                    </h4>
                    <p style="color: rgba(255,255,255,0.5); font-size: 14px; margin-bottom: 16px;">
                        Systems Engineer
                    </p>
                    <p style="color: rgba(255,255,255,0.7); font-size: 14px; line-height: 1.6;">
                        Turns complex problems into reliable software. Obsessed with performance, clean code, and systems that scale. Believes every bug is feedback. Shipped 40+ client projects and counting. Builds. Tests. Improves. Repeats.
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div style="
                    background: rgba(255,255,255,0.05);
                    padding: 32px;
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 10px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                ">
                    <div style="
                        width: 60px;
                        height: 60px;
                        background: #74b812;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 24px;
                        font-weight: 700;
                        color: #0f1419;
                        margin-bottom: 20px;
                        border-radius: 8px;
                    ">C</div>

                    <h4 style="color: white; font-size: 20px; font-weight: 700; margin-bottom: 8px;">
                        Charity
                    </h4>
                    <p style="color: rgba(255,255,255,0.5); font-size: 14px; margin-bottom: 16px;">
                        Project Manager
                    </p>
                    <p style="color: rgba(255,255,255,0.7); font-size: 14px; line-height: 1.6;">
                        Turns deadlines into deliverables. Obsessed with timelines, clarity, and projects that actually ship. Believes communication beats assumptions every time. Keeps teams aligned and clients happy.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Tech Stack -->
<section style="background: #f5f5f7; padding: 100px 0;">
    <div class="container">
        <h2 style="color: #1d1d1f; font-size: 56px; line-height: 1.1; font-weight: 600; letter-spacing: -0.02em; margin-bottom: 16px;">
            The tools powering our work
        </h2>
        <p style="color: #6e6e73; font-size: 19px; line-height: 1.5; margin-bottom: 48px; max-width: 800px;">
            Our work runs on a powerful stack of tools—spanning design systems, collaboration, and automation. These platforms help us work smarter, scale faster, and deliver results that go beyond expectations.
        </p>

        <!-- Tools Grid -->
        <div style="display: flex; flex-wrap: wrap; gap: 16px;">
            <!-- React -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#61DAFB"><path d="M12 9.861a2.139 2.139 0 100 4.278 2.139 2.139 0 100-4.278zm-5.992 6.394l-.472-.12C2.018 15.246 0 13.737 0 11.996s2.018-3.25 5.536-4.139l.472-.119.133.468a23.53 23.53 0 001.363 3.578l.101.213-.101.213a23.307 23.307 0 00-1.363 3.578l-.133.467zm-.491-6.332c-2.577.818-4.013 1.981-4.013 3.073 0 1.092 1.436 2.255 4.013 3.073.296-1.023.64-2.054.984-3.073a24.5 24.5 0 01-.984-3.073zm12.475 6.332l-.133-.469a23.357 23.357 0 00-1.364-3.577l-.101-.213.101-.213a23.42 23.42 0 001.364-3.578l.133-.468.473.119c3.517.889 5.535 2.398 5.535 4.14s-2.018 3.25-5.535 4.139l-.473.12zm-.491-4.259c.48 1.039.877 2.06 1.146 3.073 2.577-.818 4.013-1.981 4.013-3.073 0-1.092-1.436-2.255-4.013-3.073a24.369 24.369 0 01-1.146 3.073zM5.515 8.995l-.133-.469C4.188 4.992 4.488 2.494 6 1.622c1.483-.856 3.864.155 6.359 2.716l.34.349-.34.349a23.552 23.552 0 00-2.422 2.967l-.135.193-.235.02a23.657 23.657 0 00-3.579.597l-.473.12zm1.482-6.533c-.326 0-.612.062-.848.18-.955.551-1.141 2.398-.501 4.994a24.44 24.44 0 012.696-.474 24.386 24.386 0 011.842-2.287c-1.373-1.319-2.623-2.413-3.189-2.413zm11.507 6.027c.326 0 .612.062.848.18.955.551 1.141 2.398.501 4.994a24.44 24.44 0 01-2.696-.474 24.386 24.386 0 01-1.842-2.287c1.373-1.319 2.623-2.413 3.189-2.413zM12 8.996a24.32 24.32 0 011.964.143c.307-.578.639-1.134.982-1.676-.646-.047-1.306-.071-1.978-.071s-1.332.024-1.978.071c.343.542.675 1.098.982 1.676A24.32 24.32 0 0112 8.996zm0 6.008a24.32 24.32 0 01-1.964-.143 24.26 24.26 0 01-.982 1.676c.646.047 1.306.071 1.978.071s1.332-.024 1.978-.071a24.26 24.26 0 01-.982-1.676 24.32 24.32 0 01-1.028.143z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">React</span>
            </div>

            <!-- Angular -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#DD0031"><path d="M9.931 12.645h4.138l-2.07-4.908m0-7.737L.68 3.982l1.726 14.771L12 24l9.596-5.242L23.32 3.984 11.999.001zm7.064 18.31h-2.638l-1.422-3.503H8.996l-1.422 3.504h-2.64L12 2.65z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Angular</span>
            </div>

            <!-- Laravel -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#FF2D20"><path d="M23.642 5.43a.364.364 0 01.014.1v5.149c0 .135-.073.26-.189.326l-4.323 2.49v4.934a.378.378 0 01-.188.326L9.93 23.949a.316.316 0 01-.066.027c-.008.002-.016.008-.024.01a.348.348 0 01-.192 0c-.011-.002-.02-.008-.03-.012-.02-.006-.043-.012-.063-.025L.533 18.755a.376.376 0 01-.189-.326V2.974c0-.033.005-.066.014-.098.003-.012.01-.02.014-.032a.369.369 0 01.023-.058c.004-.013.015-.022.023-.033l.033-.045c.012-.01.025-.018.037-.027.014-.012.027-.024.041-.034h.001L5.044.05a.375.375 0 01.377 0L9.935 2.697h.001l.038.027c.013.014.02.03.033.045.008.011.02.021.025.033.01.02.017.038.024.058.003.011.01.021.013.032.01.031.014.064.014.098v9.652l3.76-2.164V5.527c0-.033.004-.066.013-.098.003-.01.01-.02.013-.032a.487.487 0 01.024-.059c.007-.012.018-.02.025-.033.012-.015.021-.03.033-.043.012-.012.025-.02.037-.028.014-.01.026-.023.041-.032h.001l4.513-2.598a.375.375 0 01.377 0l4.513 2.598c.016.01.027.021.042.031.012.01.025.018.036.028.013.014.022.03.034.044.008.012.019.021.024.033.011.02.018.04.024.06.006.01.012.021.015.032zm-.74 5.032V6.179l-1.578.908-2.182 1.256v4.283zm-4.514 7.75v-4.287l-2.147 1.225-6.126 3.498v4.325zM1.093 3.624v14.588l8.273 4.761v-4.325l-4.322-2.445-.002-.003c-.014-.01-.025-.021-.04-.031-.012-.012-.025-.02-.035-.03l-.001-.002c-.013-.012-.021-.025-.031-.04-.01-.011-.021-.022-.028-.036-.008-.014-.013-.031-.02-.047-.006-.016-.014-.027-.018-.043a.49.49 0 01-.008-.057c-.002-.014-.006-.027-.006-.041V5.789l-2.18-1.257zM5.23.81L1.47 2.974l3.76 2.164 3.758-2.164zm1.956 13.505l2.182-1.256V3.624l-1.58.91-2.182 1.255v9.435zm11.581-10.95l-3.76 2.163 3.76 2.163 3.759-2.164zm-.376 4.978L16.21 7.087l-1.58-.907v4.283l2.182 1.256 1.58.908zm-8.65 9.654l5.514-3.148 2.756-1.572-3.757-2.163-4.324 2.49-3.939 2.267z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Laravel</span>
            </div>

            <!-- Flutter -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#02569B"><path d="M14.314 0L2.3 12 6 15.7 21.684.013h-7.357zm.014 11.072L7.857 17.53l6.47 6.47H21.7l-6.46-6.468 6.46-6.46h-7.37z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Flutter</span>
            </div>

            <!-- C# -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#512BD4"><path d="M12 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0zM9.426 7.12a5.55 5.55 0 011.985.38v1.181a4.5 4.5 0 00-2.25-.566 3.439 3.439 0 00-2.625 1.087 4.099 4.099 0 00-1.012 2.906 3.9 3.9 0 00.945 2.754 3.217 3.217 0 002.482 1.023 4.657 4.657 0 002.464-.634l-.004 1.08a5.543 5.543 0 01-2.625.555 4.211 4.211 0 01-3.228-1.297 4.793 4.793 0 01-1.212-3.43 5.156 5.156 0 011.327-3.752A4.451 4.451 0 019.426 7.12zm7.594.96l.64.001.077.004-.073.294-.471 1.895h1.323l-.149.609H16.99l-.794 3.157a2.631 2.631 0 00-.1.677c0 .263.134.396.404.396a1.47 1.47 0 00.537-.117l-.082.509a2.085 2.085 0 01-.756.125c-.486 0-.73-.262-.73-.787a3.54 3.54 0 01.15-.895l.794-3.065h-.91l.122-.609h.936l.35-1.418zm-2.508.004h.637l.078.004-.471 1.895.073-.294h1.323l-.149.609h-1.377l-.794 3.157a2.631 2.631 0 00-.1.677c0 .263.135.396.405.396a1.47 1.47 0 00.536-.117l-.082.509a2.085 2.085 0 01-.756.125c-.486 0-.73-.262-.73-.787a3.54 3.54 0 01.151-.895l.793-3.065h-.91l.123-.609h.936z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">C#</span>
            </div>

            <!-- Docker -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#2496ED"><path d="M13.983 11.078h2.119a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.119a.185.185 0 00-.185.185v1.888c0 .102.083.185.185.185m-2.954-5.43h2.118a.186.186 0 00.186-.186V3.574a.186.186 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.888c0 .102.082.185.185.186m0 2.716h2.118a.187.187 0 00.186-.186V6.29a.186.186 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.887c0 .102.082.185.185.186m-2.93 0h2.12a.186.186 0 00.184-.186V6.29a.185.185 0 00-.185-.185H8.1a.185.185 0 00-.185.185v1.887c0 .102.083.185.185.186m-2.964 0h2.119a.186.186 0 00.185-.186V6.29a.185.185 0 00-.185-.185H5.136a.186.186 0 00-.186.185v1.887c0 .102.084.185.186.186m5.893 2.715h2.118a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.118a.185.185 0 00-.185.185v1.888c0 .102.082.185.185.185m-2.93 0h2.12a.185.185 0 00.184-.185V9.006a.185.185 0 00-.184-.186h-2.12a.185.185 0 00-.184.185v1.888c0 .102.083.185.185.185m-2.964 0h2.119a.185.185 0 00.185-.185V9.006a.185.185 0 00-.184-.186h-2.12a.186.186 0 00-.186.186v1.887c0 .102.084.185.186.185m-2.92 0h2.12a.185.185 0 00.184-.185V9.006a.185.185 0 00-.184-.186h-2.12a.185.185 0 00-.184.185v1.888c0 .102.082.185.185.185M23.763 9.89c-.065-.051-.672-.51-1.954-.51-.338.001-.676.03-1.01.087-.248-1.7-1.653-2.53-1.716-2.566l-.344-.199-.226.327c-.284.438-.49.922-.612 1.43-.23.97-.09 1.882.403 2.661-.595.332-1.55.413-1.744.42H.751a.751.751 0 00-.75.748 11.376 11.376 0 00.692 4.062c.545 1.428 1.355 2.48 2.41 3.124 1.18.723 3.1 1.137 5.275 1.137.983.003 1.963-.086 2.93-.266a12.248 12.248 0 003.823-1.389c.98-.567 1.86-1.288 2.61-2.136 1.252-1.418 1.998-2.997 2.553-4.4h.221c1.372 0 2.215-.549 2.68-1.009.309-.293.55-.65.707-1.046l.098-.288Z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Docker</span>
            </div>

            <!-- AWS -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#FF9900"><path d="M6.763 10.036c0 .296.032.535.088.71.064.176.144.368.256.576.04.063.056.127.056.183 0 .08-.048.16-.152.24l-.503.335a.383.383 0 01-.208.072c-.08 0-.16-.04-.239-.112a2.47 2.47 0 01-.287-.375 6.18 6.18 0 01-.248-.471c-.622.734-1.405 1.101-2.347 1.101-.67 0-1.205-.191-1.596-.574-.391-.384-.59-.894-.59-1.533 0-.678.239-1.23.726-1.644.487-.415 1.133-.623 1.955-.623.272 0 .551.024.846.064.296.04.6.104.918.176v-.583c0-.607-.127-1.03-.375-1.277-.255-.248-.686-.367-1.3-.367-.28 0-.568.031-.863.103-.295.072-.583.16-.862.272a2.287 2.287 0 01-.28.104.488.488 0 01-.127.023c-.112 0-.168-.08-.168-.247v-.391c0-.128.016-.224.056-.28a.597.597 0 01.224-.167c.279-.144.614-.264 1.005-.36a4.84 4.84 0 011.246-.151c.95 0 1.644.216 2.091.647.439.43.662 1.085.662 1.963v2.586zm-3.24 1.214c.263 0 .534-.048.822-.144.287-.096.543-.271.758-.51.128-.152.224-.32.272-.512.047-.191.08-.423.08-.694v-.335a6.66 6.66 0 00-.735-.136 6.02 6.02 0 00-.75-.048c-.535 0-.926.104-1.19.32-.263.215-.39.518-.39.917 0 .375.095.655.295.846.191.2.47.296.838.296zm6.41.862c-.144 0-.24-.024-.304-.08-.064-.048-.12-.16-.168-.311L7.586 5.55a1.398 1.398 0 01-.072-.32c0-.128.064-.2.191-.2h.783c.151 0 .255.025.31.08.065.048.113.16.16.312l1.342 5.284 1.245-5.284c.04-.16.088-.264.151-.312a.549.549 0 01.32-.08h.638c.152 0 .256.025.32.08.063.048.12.16.151.312l1.261 5.348 1.381-5.348c.048-.16.104-.264.16-.312a.52.52 0 01.311-.08h.743c.127 0 .2.065.2.2 0 .04-.009.08-.017.128a1.137 1.137 0 01-.056.2l-1.923 6.17c-.048.16-.104.263-.168.311a.51.51 0 01-.303.08h-.687c-.151 0-.255-.024-.32-.08-.063-.056-.119-.16-.15-.32l-1.238-5.148-1.23 5.14c-.04.16-.087.264-.15.32-.065.056-.177.08-.32.08zm10.256.215c-.415 0-.83-.048-1.229-.143-.399-.096-.71-.2-.918-.32-.128-.071-.215-.151-.247-.223a.563.563 0 01-.048-.224v-.407c0-.167.064-.247.183-.247.048 0 .096.008.144.024.048.016.12.048.2.08.271.12.566.215.878.279.319.064.63.096.95.096.502 0 .894-.088 1.165-.264a.86.86 0 00.415-.758.777.777 0 00-.215-.559c-.144-.151-.416-.287-.807-.415l-1.157-.36c-.583-.183-1.014-.454-1.277-.813a1.902 1.902 0 01-.4-1.158c0-.335.073-.63.216-.886.144-.255.335-.479.575-.654.24-.184.51-.32.83-.415.32-.096.655-.136 1.006-.136.175 0 .359.008.535.032.183.024.35.056.518.088.16.04.312.08.455.127.144.048.256.096.336.144a.69.69 0 01.24.2.43.43 0 01.071.263v.375c0 .168-.064.256-.184.256a.83.83 0 01-.303-.096 3.652 3.652 0 00-1.532-.311c-.455 0-.815.071-1.062.223-.248.152-.375.383-.375.71 0 .224.08.416.24.567.159.152.454.304.877.44l1.134.358c.574.184.99.44 1.237.767.247.327.367.702.367 1.117 0 .343-.072.655-.207.926-.144.272-.336.511-.583.703-.248.2-.543.343-.886.447-.36.111-.734.167-1.142.167zM21.698 16.207c-2.626 1.94-6.442 2.969-9.722 2.969-4.598 0-8.74-1.7-11.87-4.526-.247-.223-.024-.527.27-.351 3.384 1.963 7.559 3.153 11.877 3.153 2.914 0 6.114-.607 9.06-1.852.439-.2.814.287.385.607zM22.792 14.961c-.336-.43-2.22-.207-3.074-.103-.255.032-.295-.192-.063-.36 1.5-1.053 3.967-.75 4.254-.399.287.36-.08 2.826-1.485 4.007-.215.184-.423.088-.327-.151.32-.79 1.03-2.57.695-2.994z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">AWS</span>
            </div>

            <!-- SQL -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#4479A1"><path d="M12 3C7.58 3 4 4.79 4 7s3.58 4 8 4 8-1.79 8-4-3.58-4-8-4zM4 9v3c0 2.21 3.58 4 8 4s8-1.79 8-4V9c0 2.21-3.58 4-8 4s-8-1.79-8-4zm0 5v3c0 2.21 3.58 4 8 4s8-1.79 8-4v-3c0 2.21-3.58 4-8 4s-8-1.79-8-4z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">SQL</span>
            </div>

            <!-- Claude -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#D97757"><path d="M4.709 15.955l4.72-2.647.08-.23-.08-.128H9.2l-.79-.048-2.698-.063-2.107-.08-1.26-.063.063-.063.126-.67.063-.377.127-.67.063-.126.063-.063.776.063 1.197.08 1.07.063.67.063.71.08.71.063h.67l.69.048.58.045.17-.05.14-.17v-.19l-.44-.58-.96-1.39-.65-.99-.58-.93-.44-.67-.44-.71-.38-.62-.23-.4-.05-.2.3-.33.41-.5.23-.27.23-.05h.13l.31.31.65.69.62.67.59.71.96 1.07.56.65.52.58.5.56.52.54.28.17h.36l.06-.1.08-.41.42-1.81.25-1.13.33-1.35.36-1.41.33-1.29.16-.58.1-.17.1-.06.44-.1.38-.1h.25l.13.06.06.12v.17l-.13.83-.33 1.94-.31 2.04-.23 1.32-.17 1.23-.13.9.04.28.14.2h.34l.17-.08.31-.23 1.04-.88 1.19-.96 1.37-1.1.94-.72.75-.62.27-.17.17-.04.13.04.52.56.46.5.1.21-.06.15-.27.23-1.12.86-.88.73-1.62 1.26-.98.83-.86.71-.71.56-.15.15-.05.19.05.1.56.65.77.92.69.79.56.67.56.77.24.25.03.12-.07.13-.21.25-.67.58-1.45 1.13-.75.61-.85.65-.98.79-.63.52-.48.33-.13.27.04.25.19.42.54 1.02.44.75.42.71.38.63.38.63.38.69.35.67.17.15v.12l-.08.15-.38.35-.42.38-.29.27-.13.04-.16-.06-.57-.63-.65-.79-.57-.65-.46-.56-.57-.65-.46-.56-.23-.33-.2-.12-.2.04-.11.14-.19.98-.36 1.89-.33 1.56-.25 1.43-.04.37-.12.15-.15.04-.42-.06-.44-.06-.15-.08-.06-.12.02-.19.25-1.47.42-2.37.29-1.58.25-1.45.02-.35-.1-.23-.23-.04-.23.08-.65.44-.98.71-1.6 1.14-.82.6-.61.44-.19.1-.17.04-.17-.13-.48-.52-.54-.6-.33-.35-.06-.16.04-.13.21-.23.44-.42.96-.86.73-.63 1.27-1.1.88-.73.25-.25.06-.14-.02-.13-.33-.44-.77-.96-.62-.82-.61-.77-.4-.54-.08-.14.04-.15.13-.13.73-.5 1.1-.75.71-.56 1.14-.86.1-.16-.01-.15-.26-.24-.54-.5-.48-.48-.73-.71-.52-.5-.1-.12.02-.15.25-.38.35-.48.1-.1Z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Claude</span>
            </div>

            <!-- ChatGPT -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#10A37F"><path d="M22.282 9.821a5.985 5.985 0 0 0-.516-4.91 6.046 6.046 0 0 0-6.51-2.9A6.065 6.065 0 0 0 4.981 4.18a5.985 5.985 0 0 0-3.998 2.9 6.046 6.046 0 0 0 .743 7.097 5.98 5.98 0 0 0 .51 4.911 6.051 6.051 0 0 0 6.515 2.9A5.985 5.985 0 0 0 13.26 24a6.056 6.056 0 0 0 5.772-4.206 5.99 5.99 0 0 0 3.997-2.9 6.056 6.056 0 0 0-.747-7.073zM13.26 22.43a4.476 4.476 0 0 1-2.876-1.04l.141-.081 4.779-2.758a.795.795 0 0 0 .392-.681v-6.737l2.02 1.168a.071.071 0 0 1 .038.052v5.583a4.504 4.504 0 0 1-4.494 4.494zM3.6 18.304a4.47 4.47 0 0 1-.535-3.014l.142.085 4.783 2.759a.771.771 0 0 0 .78 0l5.843-3.369v2.332a.08.08 0 0 1-.033.062L9.74 19.95a4.5 4.5 0 0 1-6.14-1.646zM2.34 7.896a4.485 4.485 0 0 1 2.366-1.973V11.6a.766.766 0 0 0 .388.676l5.815 3.355-2.02 1.168a.076.076 0 0 1-.071 0l-4.83-2.786A4.504 4.504 0 0 1 2.34 7.872zm16.597 3.855l-5.833-3.387L15.119 7.2a.076.076 0 0 1 .071 0l4.83 2.791a4.494 4.494 0 0 1-.676 8.105v-5.678a.79.79 0 0 0-.407-.667zm2.01-3.023l-.141-.085-4.774-2.782a.776.776 0 0 0-.785 0L9.409 9.23V6.897a.066.066 0 0 1 .028-.061l4.83-2.787a4.5 4.5 0 0 1 6.68 4.66zm-12.64 4.135l-2.02-1.164a.08.08 0 0 1-.038-.057V6.075a4.5 4.5 0 0 1 7.375-3.453l-.142.08L8.704 5.46a.795.795 0 0 0-.393.681zm1.097-2.365l2.602-1.5 2.607 1.5v2.999l-2.597 1.5-2.607-1.5z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">ChatGPT</span>
            </div>

            <!-- Webflow -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#4353FF"><path d="M17.802 8.56s-1.946 6.103-2.105 6.607c-.02-.64-.053-8.609-.053-8.609-1.817 0-2.761 1.267-3.299 2.606 0 0-2.047 5.105-2.222 5.54-.004-1.813-.054-7.234-.054-7.234-.032-1.19-.964-2.37-2.654-2.37L7.398 14.57s.014 8.33.014 8.33c1.86.013 2.834-1.265 3.376-2.596l2.177-5.378.04 7.974c1.872 0 2.847-1.207 3.4-2.536l4.74-11.79c-1.639 0-2.723.953-3.343 2.527"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Webflow</span>
            </div>

            <!-- Notion -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#000000"><path d="M4.459 4.208c.746.606 1.026.56 2.428.466l13.215-.793c.28 0 .047-.28-.046-.326L17.86 1.968c-.42-.326-.98-.7-2.055-.607L3.01 2.295c-.466.046-.56.28-.374.466zm.793 3.08v13.904c0 .747.373 1.027 1.214.98l14.523-.84c.841-.046.935-.56.935-1.167V6.354c0-.606-.233-.933-.748-.886l-15.177.887c-.56.047-.747.327-.747.933zm14.337.745c.093.42 0 .84-.42.888l-.7.14v10.264c-.608.327-1.168.514-1.635.514-.748 0-.935-.234-1.495-.933l-4.577-7.186v6.952l1.448.327s0 .84-1.168.84l-3.22.186c-.094-.186 0-.653.327-.746l.84-.233V9.854L7.822 9.76c-.094-.42.14-1.026.793-1.073l3.456-.233 4.764 7.279v-6.44l-1.215-.139c-.093-.514.28-.886.747-.933zM2.718 1.321l13.496-.933c1.662-.14 2.1.093 2.802.606l3.876 2.754c.467.326.607.42.607.793v15.858c0 .98-.373 1.587-1.635 1.68l-15.458.934c-.934.046-1.381-.094-1.868-.7L1.2 18.91c-.56-.7-.793-1.214-.793-1.82V2.948c0-.793.373-1.54 1.311-1.627z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Notion</span>
            </div>

            <!-- Slack -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36"><path fill="#E01E5A" d="M5.042 15.165a2.528 2.528 0 0 1-2.52 2.523A2.528 2.528 0 0 1 0 15.165a2.527 2.527 0 0 1 2.522-2.52h2.52v2.52zm1.271 0a2.527 2.527 0 0 1 2.521-2.52 2.527 2.527 0 0 1 2.521 2.52v6.313A2.528 2.528 0 0 1 8.834 24a2.528 2.528 0 0 1-2.521-2.522v-6.313z"/><path fill="#36C5F0" d="M8.834 5.042a2.528 2.528 0 0 1-2.521-2.52A2.528 2.528 0 0 1 8.834 0a2.528 2.528 0 0 1 2.521 2.522v2.52H8.834zm0 1.271a2.528 2.528 0 0 1 2.521 2.521 2.528 2.528 0 0 1-2.521 2.521H2.522A2.528 2.528 0 0 1 0 8.834a2.528 2.528 0 0 1 2.522-2.521h6.312z"/><path fill="#2EB67D" d="M18.956 8.834a2.528 2.528 0 0 1 2.522-2.521A2.528 2.528 0 0 1 24 8.834a2.528 2.528 0 0 1-2.522 2.521h-2.522V8.834zm-1.27 0a2.528 2.528 0 0 1-2.522 2.521 2.528 2.528 0 0 1-2.521-2.521V2.522A2.528 2.528 0 0 1 15.165 0a2.528 2.528 0 0 1 2.521 2.522v6.312z"/><path fill="#ECB22E" d="M15.165 18.956a2.528 2.528 0 0 1 2.521 2.522A2.528 2.528 0 0 1 15.165 24a2.527 2.527 0 0 1-2.521-2.522v-2.522h2.521zm0-1.27a2.527 2.527 0 0 1-2.521-2.522 2.527 2.527 0 0 1 2.521-2.521h6.313A2.528 2.528 0 0 1 24 15.165a2.528 2.528 0 0 1-2.522 2.521h-6.313z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Slack</span>
            </div>

            <!-- Figma -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36"><path fill="#1abcfe" d="M12 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0z"/><path fill="#0acf83" d="M4 20a4 4 0 0 1 4-4h4v4a4 4 0 1 1-8 0z"/><path fill="#ff7262" d="M12 0v8h4a4 4 0 1 0 0-8h-4z"/><path fill="#f24e1e" d="M4 4a4 4 0 0 0 4 4h4V0H8a4 4 0 0 0-4 4z"/><path fill="#a259ff" d="M4 12a4 4 0 0 0 4 4h4V8H8a4 4 0 0 0-4 4z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Figma</span>
            </div>


            <!-- Google Meet -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36"><path fill="#00832d" d="M12.29 14.548v2.47h3.39a3.478 3.478 0 0 1-3.39 2.711 3.729 3.729 0 1 1 0-7.458c.913 0 1.78.334 2.455.936l1.796-1.795A6.185 6.185 0 0 0 12.29 9.78a6.22 6.22 0 1 0 0 12.44c3.59 0 6.074-2.52 6.074-6.074 0-.47-.051-.928-.145-1.372H12.29z"/><path fill="#0066da" d="M5 12v4.635L9.063 12z"/><path fill="#e94235" d="M5 7.365v4.636l4.063-4.636z"/><path fill="#2684fc" d="M9.063 12L5 16.636v.728C5 18.265 5.735 19 6.636 19h.728L12 14.363z"/><path fill="#00ac47" d="M12 9.636L7.364 5h-.728C5.735 5 5 5.735 5 6.636v.729L9.063 12z"/><path fill="#00832d" d="M7.364 19H17.09l-5.09-4.636z"/><path fill="#00ac47" d="M19 6.636v10.728L14.273 12z"/><path fill="#ffba00" d="M19 6.636C19 5.735 18.265 5 17.364 5h-.273L12 9.636 17.09 15l1.91-1.636z"/><path fill="#0066da" d="M17.09 19l-5.09-4.636V19z"/><path fill="#e94235" d="M12 9.636V5h5.364L12 9.636z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Meet</span>
            </div>



            <!-- Perplexity -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#20808D"><path d="M12 0L4 4.5v6.036L0 13.5v3l4-2.25V21l8 3 8-3v-6.75l4 2.25v-3l-4-2.964V4.5L12 0zm6 9.804v3.446l-6 3.375-6-3.375V9.804l6-3.554 6 3.554zM5 5.304L12 1.5l7 3.804v4.032l-7-4.086-7 4.086V5.304zm0 13.392v-4.032l6 3.375v4.211l-6-3.554zm14 0l-6 3.554v-4.211l6-3.375v4.032z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Perplexity</span>
            </div>

            <!-- Stripe -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#635BFF"><path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.591-7.305z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Stripe</span>
            </div>

            <!-- Calendly -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#006BFF"><path d="M19.5 3h-3V1.5a.75.75 0 0 0-1.5 0V3h-6V1.5a.75.75 0 0 0-1.5 0V3h-3A2.25 2.25 0 0 0 2.25 5.25v15A2.25 2.25 0 0 0 4.5 22.5h15a2.25 2.25 0 0 0 2.25-2.25v-15A2.25 2.25 0 0 0 19.5 3zm.75 17.25a.75.75 0 0 1-.75.75h-15a.75.75 0 0 1-.75-.75V9h16.5v11.25zM12 12.75a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm0 4.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Calendly</span>
            </div>

            <!-- Google Drive -->
            <div class="tool-item" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div style="width: 72px; height: 72px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                    <svg viewBox="0 0 24 24" width="36" height="36"><path fill="#4285F4" d="M6.59 21.41L2 13.5h7.73l4.58 7.91z"/><path fill="#FBBC05" d="m22 13.5-4.59 7.91H9.73L14.32 13.5z"/><path fill="#34A853" d="M14.32 13.5H22L14.32 0H6.59z"/><path fill="#EA4335" d="m2 13.5 4.59-7.91L14.32 0H6.59L2 7.91z"/><path fill="#188038" d="M6.59 5.59 2 13.5l4.59 7.91 4.59-7.91z"/><path fill="#1967D2" d="m9.73 21.41 4.59-7.91H6.59l4.59 7.91z"/></svg>
                </div>
                <span style="font-size: 12px; color: #6e6e73; font-weight: 500;">Drive</span>
            </div>



        </div>
    </div>
</section>

<style>
    .tool-item:hover > div:first-child {
        transform: scale(1.07);
        transition: transform 0.3s ease;
    }
    .tool-item > div:first-child {
        transition: transform 0.3s ease;
    }
</style>

<style>
    @media (max-width: 768px) {
        section h1 {
            font-size: 42px !important;
        }
        section h2 {
            font-size: 36px !important;
        }
        section h3 {
            font-size: 24px !important;
        }
    }
</style>

@endsection
