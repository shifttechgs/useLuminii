@extends("layouts.master")

@push('styles')
    <link rel="stylesheet" href="assets/css/work-portfolio.css">
@endpush

@section("content")
<?php
// Hardcoded Projects Array
    $projects = [
        [
            'title' => 'luminii CRM',
            'client_name' => 'UseLuminii',
            'service_type' => 'web-app',
            'service_label' => 'Web Application',
            'industry' => 'SaaS',
            'value_proposition' => 'Simplified customer onboarding by automating account setup and follow-ups',
            'featured_image' => 'luminii.png',
            'technologies' => ['Angular', 'C#', 'SQL'],
        ],
        [
            'title' => 'zimAlert Emergency Response',
            'client_name' => 'zimAlert',
            'service_type' => 'mobile-app',
            'service_label' => 'Mobile Application',
            'industry' => 'Healthcare',
            'value_proposition' => 'Improved emergency response coordination using live location tracking',
            'featured_image' => 'zimAlert.png',
            'technologies' => ['Flutter', 'C#', 'Firebase', 'SQL'],
        ],
        [
            'title' => 'PayHouse Finance Platform',
            'client_name' => 'PayHouse',
            'service_type' => 'web-app',
            'service_label' => 'Web Application',
            'industry' => 'Fintech',
            'value_proposition' => 'Reduced loan processing delays through automated verification workflows',
            'featured_image' => 'pay.png',
            'technologies' => ['Laravel', 'PHP', 'MySQL'],
        ],
        [
            'title' => 'Vision Plus Wealth Management',
            'client_name' => 'Vision Plus Wealth',
            'service_type' => 'website',
            'service_label' => 'Website',
            'industry' => 'Finance',
            'value_proposition' => 'Generated more qualified leads with a clearer service presentation',
            'featured_image' => 'vwp.png',
            'technologies' => ['Laravel', 'PHP', 'MySQL'],
        ],
        [
            'title' => 'BSL Auction Services',
            'client_name' => 'BSL',
            'service_type' => 'web-app',
            'service_label' => 'Web Application',
            'industry' => 'E-commerce',
            'value_proposition' => 'Digitized auction management to reduce paperwork and admin time',
            'featured_image' => 'bsl.png',
            'technologies' =>  ['Laravel', 'PHP', 'MySQL'],
        ],
        [
            'title' => 'Lifestyle Laundry',
            'client_name' => 'Lifestyle Laundry',
            'service_type' => 'mobile-app',
            'service_label' => 'Mobile Application',
            'industry' => 'Services',
            'value_proposition' => 'Enabled customers to book, pay and track their laundry orders online anytime',
            'featured_image' => 'lifestyle.png',
            'technologies' => ['Flutter', 'Firebase', 'Stripe', 'C#', 'SQL'],
        ],
        [
            'title' => 'luminii SaaS Platform',
            'client_name' => 'UseLuminii',
            'service_type' => 'custom-software',
            'service_label' => 'Custom Software',
            'industry' => 'SaaS',
            'value_proposition' => 'Built a scalable multi-tenant platform for managing multiple client accounts and streamline operations from leads, quotes, invoicing and job scheduling',
            'featured_image' => 'saas.png',
            'technologies' => ['Angular', 'C#', 'SQL'],
        ],
    ];
    ?>


<!-- ==================== Hero Section ==================== -->
<section class="work-hero">

    <img src="assets/images/shapes/sqaure_shape.png"
         alt="Shape"
         class="position-absolute top-0 tw-end-0 tw-me-12-percent"
         style="filter: brightness(50%); opacity: 0.2;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <span class="work-hero__badge" data-aos="fade-down" data-aos-duration="800">
                    <i class="ph-bold ph-trophy"></i> 150+ Projects Delivered
                </span>
                <h1 class="work-hero__title" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    Work That Drives Real Business Results
                </h1>
                <p class="work-hero__subtitle" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    From startups to enterprises, we build software solutions that solve real problems and deliver measurable impact.
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

<!-- ==================== Filter Controls ==================== -->
<section class="filter-controls" id="filterControls">
    <div class="container">
        <div class="filter-controls__wrapper">
            <div class="filter-controls__label">Filter by:</div>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">
                    All Projects
                </button>
                <button class="filter-btn" data-filter="web-app">
                    Web Apps
                </button>
                <button class="filter-btn" data-filter="mobile-app">
                    Mobile Apps
                </button>
                <button class="filter-btn" data-filter="website">
                    Websites
                </button>
                <button class="filter-btn" data-filter="custom-software">
                    Custom Software
                </button>
            </div>
        </div>
    </div>
</section>

<!-- ==================== Portfolio Grid ==================== -->
<section class="portfolio-grid">
    <div class="container">
        <div class="row" id="portfolioGrid">
            @foreach($projects as $index => $project)
                <div class="col-lg-4 col-md-6 col-12 portfolio-item"
                     data-category="{{ $project['service_type'] }}"
                     data-aos="fade-up"
                     data-aos-duration="800"
                     data-aos-delay="{{ $index * 100 }}">
                    <article class="project-card">
                        <div class="project-card__image">
                            <img src="assets/images/thumbs/work/{{ $project['featured_image'] }}"
                                 alt="{{ $project['title'] }}"
                                 loading="lazy">
                            <div class="">
                                <a href="{{ route('contact.page') }}" class="view-project-btn">
                                    <i class="ph-bold ph-arrow-up-right"></i> Get Started
                                </a>
                            </div>
                        </div>
                        <div class="project-card__content">
                            <div class="project-card__tags">
                                <span class="tag tag--service">{{ $project['service_label'] }}</span>
                                <span class="tag tag--industry">{{ $project['industry'] }}</span>
                            </div>
                            <h3 class="project-card__title">{{ $project['title'] }}</h3>
                            <p class="project-card__client">{{ $project['client_name'] }}</p>
                            <p class="project-card__value">
                                <i class="ph-bold ph-chart-line-up"></i>
                                {{ $project['value_proposition'] }}
                            </p>
                            <div class="project-card__tech">
                                @foreach($project['technologies'] as $tech)
                                    <span class="tech-badge">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                    </article>
                </div>


            @endforeach
        </div>
    </div>
</section>

<!-- ==================== Stats Bar ==================== -->


@endsection

@push('scripts')
    <script src="assets/js/work-portfolio.js"></script>
@endpush
