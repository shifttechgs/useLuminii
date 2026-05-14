@extends("layouts.master")

@push('styles')
    <style>
        /* Service Page Specific Styles - Superside Inspired + Conversion Optimized */
        .service-hero {
            background: linear-gradient(135deg, #002b22 0%, #002b22 100%);
            min-height: 75vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 120px 0 60px;
        }

        .service-hero__content {
            position: relative;
            z-index: 2;
        }

        .service-hero__badge {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(116, 184, 18, 0.2);
            border: 1px solid #74b812;
            border-radius: 50px;
            color: #74b812;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 24px;
        }

        .service-hero__title {
            font-size: 3.5rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.1;
            margin-bottom: 24px;
        }

        .service-hero__subtitle {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            max-width: 700px;
            margin-bottom: 40px;
        }

        .service-hero__image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
        }

        .service-hero__image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Trust Badge */
        .trust-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 16px;
            border-radius: 50px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
            backdrop-filter: blur(10px);
        }

        .trust-badge i {
            color: #74b812;
        }

        /* Limited Offer Banner */
        .limited-offer-banner {
            background: linear-gradient(135deg, #74b812 0%, #5a9a0a 100%);
            padding: 12px 0;
            text-align: center;
            position: fixed;
            top: 80px;
            left: 0;
            right: 0;
            z-index: 998;
            box-shadow: 0 4px 20px rgba(116, 184, 18, 0.3);
        }

        .limited-offer-banner__text {
            color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            margin: 0;
        }

        .limited-offer-banner__highlight {
            color: #002b22;
            font-weight: 700;
        }

        /* Service Icons Carousel */
        .service-icons-carousel {
            background: #ffffff;
            padding: 40px 0;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
        }

        .service-icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .service-icon-item:hover {
            transform: translateY(-5px);
        }

        .service-icon-item__icon {
            width: 60px;
            height: 60px;
            background: rgba(116, 184, 18, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .service-icon-item__icon i {
            font-size: 1.75rem;
            color: #74b812;
        }

        .service-icon-item__label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #0a3622;
        }

        /* Social Proof Section */
        .social-proof-section {
            padding: 60px 0;
            background: #f9fafb;
        }

        .social-proof-section h6 {
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 32px;
        }

        /* Value Proposition Section */
        .value-section {
            padding: 100px 0;
        }

        .value-section__image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        /* Metrics Section */
        .metrics-section {
            background: linear-gradient(135deg, #0a3622 0%, #002b22 100%);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .metrics-section:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /*background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");*/
        }

        .metric-item {
            position: relative;
            z-index: 2;
        }

        .metric-item__number {
            font-size: 3.5rem;
            font-weight: 700;
            color: #74b812;
            line-height: 1;
            margin-bottom: 16px;
        }

        .metric-item__description {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.125rem;
            line-height: 1.6;
        }

        /* Integrated Services Section */
        .integrated-section {
            padding: 100px 0;
            background: #ffffff;
        }

        .integrated-section__image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        /* Service Card */
        .service-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            height: 100%;
            border: 2px solid transparent;
        }

        .service-card:hover {
            border-color: #74b812;
            box-shadow: 0 10px 40px rgba(116, 184, 18, 0.15);
            transform: translateY(-8px);
        }

        .service-card__image {
            width: 100%;
            height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .service-card__image svg {
            width: 140px;
            height: 140px;
            position: relative;
            z-index: 2;
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .service-card:hover .service-card__image svg {
            transform: scale(1.1) rotate(5deg);
        }

        /* Animated background patterns */
        .service-card__image::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        .service-card__image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(0,0,0,0.05) 100%);
            z-index: 1;
        }

        .service-card__content {
            padding: 32px 28px;
        }

        .service-card__title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0a3622;
            margin-bottom: 16px;
        }

        .service-card__description {
            color: #6b7280;
            line-height: 1.7;
            font-size: 1rem;
        }

        /* Use Case Section */
        .use-case-card {
            background: #ffffff;
            padding: 40px 32px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            height: 100%;
            border: 2px solid transparent;
        }

        .use-case-card:hover {
            border-color: #74b812;
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(116, 184, 18, 0.15);
        }

        .use-case-card__icon {
            width: 56px;
            height: 56px;
            background: rgba(116, 184, 18, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .use-case-card__icon i {
            font-size: 1.75rem;
            color: #74b812;
        }

        .use-case-card__title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0a3622;
            margin-bottom: 12px;
        }

        .use-case-card__description {
            color: #6b7280;
            line-height: 1.7;
        }

        /* Process Section - Vertical Stepper */
        .process-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #002b22 0%, #0a3622 100%);
            position: relative;
            overflow: hidden;
        }

        .process-section:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /*background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");*/
        }

        .process-content {
            position: relative;
            z-index: 2;
        }

        .process-timeline {
            position: relative;
            padding: 40px 0;
        }

        .timeline-line {
            position: absolute;
            left: 23px;
            top: 60px;
            width: 2px;
            height: calc(100% - 120px);
            background: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }

        .timeline-line-progress {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0%;
            background: #74b812;
            transition: height 0.3s ease-out;
            z-index: 0;
        }

        .process-step {
            position: relative;
            padding-left: 80px;
            margin-bottom: 60px;
            opacity: 0.5;
            transform: translateX(-20px);
            transition: all 0.6s ease-out;
            z-index: 1;
        }

        .process-step.active {
            opacity: 1;
            transform: translateX(0);
        }

        .process-step__number {
            position: absolute;
            left: 0;
            top: 0;
            width: 48px;
            height: 48px;
            background: #002b22;
            border: 3px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            z-index: 10;
            transition: all 0.4s ease;
        }

        .process-step.active .process-step__number {
            background: #74b812;
            border-color: #74b812;
            color: #ffffff;
            box-shadow: 0 0 0 8px rgba(116, 184, 18, 0.2);
        }

        .process-step__title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 12px;
            text-transform: capitalize;
        }

        .process-step__description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
            font-size: 1rem;
        }

        .process-step:last-child {
            margin-bottom: 0;
        }

        /* Testimonial Card */
        .testimonial-card {
            background: #ffffff;
            padding: 40px 32px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            height: 100%;
            position: relative;
        }

        .testimonial-card__quote {
            font-size: 3rem;
            color: #74b812;
            opacity: 0.2;
            position: absolute;
            top: 20px;
            left: 20px;
            line-height: 1;
        }

        .testimonial-card__text {
            color: #4b5563;
            line-height: 1.7;
            font-size: 1rem;
            margin-bottom: 24px;
            position: relative;
            z-index: 2;
        }

        .testimonial-card__author {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .testimonial-card__avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #74b812 0%, #5a9a0a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .testimonial-card__name {
            font-weight: 700;
            color: #0a3622;
            margin-bottom: 4px;
        }

        .testimonial-card__position {
            font-size: 0.875rem;
            color: #6b7280;
        }

        /* FAQ Section */
        .faq-section {
            padding: 100px 0;
            background: #ffffff;
        }

        .faq-item {
            background: #f9fafb;
            border-radius: 12px;
            margin-bottom: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .faq-question {
            padding: 24px 28px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            font-weight: 700;
            color: #0a3622;
            font-size: 1.125rem;
        }

        .faq-icon {
            font-size: 1.5rem;
            color: #74b812;
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            padding: 0 28px;
            color: #6b7280;
            line-height: 1.7;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            padding: 0 28px 24px 28px;
        }

        /* Guarantee Section */
        .guarantee-section {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            padding: 60px 0;
            border-top: 2px solid #74b812;
            border-bottom: 2px solid #74b812;
        }

        .guarantee-badge {
            width: 120px;
            height: 120px;
            background: #74b812;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 10px 40px rgba(116, 184, 18, 0.3);
            margin: 0 auto 24px;
        }

        .guarantee-badge__top {
            font-size: 2rem;
            line-height: 1;
        }

        .guarantee-badge__bottom {
            font-size: 0.875rem;
            margin-top: 4px;
        }

        /* Final CTA Section */
        .final-cta-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            position: relative;
            overflow: hidden;
        }

        .final-cta__image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
        }

        /* Section Badge */
        .section-badge {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(116, 184, 18, 0.15);
            border: 1px solid rgba(116, 184, 18, 0.3);
            border-radius: 50px;
            color: #0a3622;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 16px;
            text-transform: uppercase;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 700;
            color: #0a3622;
            line-height: 1.2;
            margin-bottom: 24px;
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: #6b7280;
            line-height: 1.7;
            max-width: 800px;
        }

        /* Floating CTA Button */
        .floating-cta {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            box-shadow: 0 10px 40px rgba(116, 184, 18, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .service-hero__title {
                font-size: 3rem;
            }
            .section-title {
                font-size: 2.5rem;
            }
            .metric-item__number {
                font-size: 3rem;
            }
            .limited-offer-banner {
                top: 60px;
            }
            .process-section h2 {
                font-size: 2.5rem !important;
            }
            .sticky-top {
                position: relative !important;
                top: 0 !important;
            }
        }

        @media (max-width: 768px) {
            .service-hero__title {
                font-size: 2.5rem;
            }
            .service-hero__subtitle {
                font-size: 1.25rem;
            }
            .section-title {
                font-size: 2rem;
            }
            .floating-cta {
                bottom: 20px;
                right: 20px;
            }
            .limited-offer-banner {
                top: 60px;
                padding: 8px 0;
            }
            .limited-offer-banner__text {
                font-size: 0.8rem;
            }
            .process-section h2 {
                font-size: 2rem !important;
            }
            .process-step__title {
                font-size: 1.25rem;
            }
            .process-step__description {
                font-size: 0.9rem;
            }
            .timeline-line {
                left: 20px;
            }
            .process-step {
                padding-left: 60px;
                margin-bottom: 40px;
            }
            .process-step__number {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>
@endpush

@section("content")
    <div id="smooth-content">



        <!-- ============================= Hero Section ============================== -->
        <section class="service-hero" style="margin-top: 40px;">
            <img src="/assets/images/shapes/sqaure_shape.png"
                 alt="Shape"
                 class="position-absolute top-0 tw-end-0 tw-me-12-percent"
                 style="filter: brightness(50%); opacity: 0.2;">

            <div class="container">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-6">
                        <div class="service-hero__content" data-aos="fade-up" data-aos-duration="800">

                            <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-white fw-medium tw-text-sm tw-mb-4"
                                  style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                  Mobile App Development
                                </span>
                            <h1 class="service-hero__title">
                                High-performance mobile apps that<span style="font-style: italic; color: #74b812;">  scale</span> with your business.
                            </h1>
                            <p class="service-hero__subtitle">
                                We build fast, secure native and cross-platform mobile apps for iOS and Android. From idea to launch, we deliver seamless user experiences your customers will love.
                            </p>

                            <!-- Trust Badges -->
                            <div class="d-flex flex-wrap tw-gap-3 mb-4">
                                <span class="trust-badge">
                                    <i class="ph-bold ph-check-circle"></i>
                                    98% Client Satisfaction
                                </span>
                                <span class="trust-badge">
                                    <i class="ph-bold ph-clock"></i>
                                    8-12 Week Delivery
                                </span>
                                <span class="trust-badge">
                                    <i class="ph-bold ph-shield-check"></i>
                                   App Store Submission
                                </span>
                            </div>


                            <div class="d-flex align-items-center tw-gap-4 flex-wrap">
                                <a href="{{ url('/contact') }}" class="btn btn-main-two hover-style-two button--stroke d-inline-flex align-items-center justify-content-center tw-gap-3 group active--translate-y-2 tw-px-9 rounded-pill tw-py-4 fw-semibold">
                                    <span class="button__flair"></span>
                                    <i class="ph ph-phone-call tw-text-xl tw-text-white group-hover-text-white"></i>
                                    <span class="button__label">Book Your Free Discovery Call</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800">
                        <div class="service-hero__image">
                            <img src="/assets/images/thumbs/work/lifestyle.png" alt="Mobile App Development" style="width: 100%; height: auto;">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================ Brand Slider Start =========================== -->
        <div class="bg-white tw-py-4 border-top border-neutral-100 overflow-hidden">
            <div class="container">
                <div class="brand-slider swiper">
                    <div class="swiper-wrapper align-items-center">

                        <div class="swiper-slide">
                            <div class="text-center tw-py-4 tw-px-4 brand-item-hover">
                                <img src="/assets/images/logo/clients/vpw.png" alt="Vision Plus Wealth" class="brand-logo tw-max-h-12 w-auto mx-auto" style="filter: grayscale(100%); opacity: 0.6;">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="text-center tw-py-4 tw-px-4 brand-item-hover">
                                <img src="/assets/images/logo/clients/payhse.png" alt="Payhouse Finance" class="brand-logo tw-max-h-12 w-auto mx-auto" style="filter: grayscale(100%); opacity: 0.6;">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="text-center tw-py-4 tw-px-4 brand-item-hover">
                                <img src="/assets/images/logo/clients/BSlwebbold.png" alt="bslServices" class="brand-logo tw-max-h-12 w-auto mx-auto" style="filter: grayscale(100%); opacity: 0.6;">
                            </div>
                        </div>


                        <div class="swiper-slide">
                            <div class="text-center tw-py-4 tw-px-4 brand-item-hover">
                                <img src="/assets/images/logo/clients/logo.png" alt="Ray&Sons Plumbing" class="brand-logo tw-max-h-12 w-auto mx-auto" style="filter: grayscale(100%); opacity: 0.6;">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="text-center tw-py-4 tw-px-4 brand-item-hover">
                                <img src="/assets/images/logo/clients/useluminii_logo.png" alt="Client" class="brand-logo tw-max-h-12 w-auto mx-auto" style="filter: grayscale(100%); opacity: 0.6;">
                            </div>
                        </div>

                        <!-- Duplicate for smooth loop -->
                        <div class="swiper-slide">
                            <div class="text-center tw-py-4 tw-px-4 brand-item-hover">
                                <img src="/assets/images/logo/clients/nhume_logo.png" alt="Vision Plus Wealth" class="brand-logo tw-max-h-12 w-auto mx-auto" style="filter: grayscale(100%); opacity: 0.6;">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="text-center tw-py-4 tw-px-4 brand-item-hover">
                                <img src="/assets/images/logo/clients/payhse.png" alt="Payhouse Finance" class="brand-logo tw-max-h-12 w-auto mx-auto" style="filter: grayscale(100%); opacity: 0.6;">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <style>
            .brand-item-hover:hover .brand-logo {
                filter: grayscale(0%) !important;
                opacity: 1 !important;
                transition: all 0.4s ease;
            }

            .brand-logo {
                transition: all 0.4s ease;
            }
        </style>
        <!-- ============================ Brand Slider End =========================== -->

        <!-- ========================== Why Mobile Apps Section ============================= -->
        <section class="value-section">
            <div class="container">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">
{{--                        <span class="section-badge">Why Mobile Apps Matter</span>--}}
                        <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-black fw-medium tw-text-sm tw-mb-4"
                              style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                   Why Mobile Apps Matter
                                </span>
                        <h2 class="section-title">
                            Your mobile app isn't just software, it's a <span style="font-style: italic; color: #74b812;">direct channel</span> to your customers
                        </h2>
                        <p class="section-subtitle mb-4">
                            In a mobile-first world, your app is how customers interact with your brand daily. Push notifications, offline access, and native performance create experiences websites can't match.
                        </p>
                        <div class="d-flex align-items-start tw-gap-3 mb-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0"><strong>85% of mobile time</strong> is spent in apps vs mobile browsers</p>
                        </div>
                        <div class="d-flex align-items-start tw-gap-3 mb-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0"><strong>Push notifications</strong> get 7x higher engagement than email</p>
                        </div>
                        <div class="d-flex align-items-start tw-gap-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0">Native mobile apps provide seamless offline functionality and superior performance</p>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800">
                        <div class="value-section__image">
                            <img src="/assets/images/thumbs/services/lifeApp.png" alt="Mobile App Dashboard" class="w-100 h-100 object-fit-cover">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================== Metrics Section ============================= -->
        <section class="metrics-section">
            <div class="container position-relative" style="z-index: 2;">
                <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="800">

                    <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-white fw-medium tw-text-sm tw-mb-4"
                          style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                 Metrics That Matter
                                </span>
                    <h2 class="section-title text-white mb-3 service-hero__title">
                        A <span class="d-inline-block fw-semibold" style="font-style: italic; color: #74b812; ">mobile app development partner</span> you can trust
                    </h2>
                </div>

                <div class="row g-5 justify-content-center text-center">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600">
                        <div class="metric-item">
                            <div class="metric-item__number">50+</div>
                            <p class="metric-item__description">Mobile apps built for iOS and Android platforms</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                        <div class="metric-item">
                            <div class="metric-item__number">4.8★</div>
                            <p class="metric-item__description">Average app store rating for our client apps</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                        <div class="metric-item">
                            <div class="metric-item__number">100%</div>
                            <p class="metric-item__description">App store approval success rate on first submission</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================== Integrated Services Section ============================= -->
        <section class="integrated-section">
            <div class="container">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-6 order-lg-2" data-aos="fade-left" data-aos-duration="800">

                        <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-black fw-medium tw-text-sm tw-mb-4"
                              style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                   ShiftTech Mobile Solutions
                                </span>
                        <h2 class="section-title">
                            Build once, deploy everywhere, <span style="font-style: italic; color: #74b812;">reach millions</span>
                        </h2>
                        <p class="section-subtitle mb-4">
                            We build native iOS and Android apps, plus cross-platform solutions using React Native and Flutter. One codebase, multiple platforms, consistent user experience.
                        </p>
                        <p class="section-subtitle mb-5">
                            From concept to App Store submission and beyond, we handle the entire mobile app lifecycle including ongoing updates and feature enhancements.
                        </p>
                        <a href="{{ url('/contact') }}" class="btn btn-lg fw-bold px-5 py-3 hover--translate-y-1" style="background: #74b812; color: white; border-radius: 50px; border: none;">
                            Book Your Free Discovery Call <i class="ph-bold ph-arrow-right ms-2"></i>
                        </a>
                    </div>

                    <div class="col-lg-6 order-lg-1" data-aos="fade-right" data-aos-duration="800">
                        <div class="integrated-section__image">
                            <img src="/assets/images/thumbs/services/alertApp.png" alt="Mobile App Solutions" class="w-100 h-100 object-fit-cover">
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- ========================== What We Offer Section ============================= -->
        <section class="py-120 bg-light">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="800">

                    <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-black fw-medium tw-text-sm tw-mb-4"
                          style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                  What We Offer
                                </span>
                    <h2 class="section-title mb-3">
                        Mobile app development services, <span style="font-style: italic; color: #74b812;">built to scale</span>
                    </h2>
                </div>

                <div class="row g-4">
                    <!-- Native iOS Development -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #000000 0%, #1f1f1f 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- iPhone device frame -->
                                    <rect x="60" y="35" width="80" height="130" rx="12" fill="white" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                                    <!-- Screen -->
                                    <rect x="65" y="45" width="70" height="110" fill="#000000" rx="8"/>
                                    <!-- Notch -->
                                    <rect x="85" y="45" width="30" height="5" rx="2.5" fill="#1f1f1f"/>
                                    <!-- App icons grid -->
                                    <g opacity="0.9">
                                        <rect x="72" y="58" width="12" height="12" rx="3" fill="#007AFF"/>
                                        <rect x="88" y="58" width="12" height="12" rx="3" fill="#5AC8FA"/>
                                        <rect x="104" y="58" width="12" height="12" rx="3" fill="#FF9500"/>
                                        <rect x="120" y="58" width="12" height="12" rx="3" fill="#34C759"/>

                                        <rect x="72" y="74" width="12" height="12" rx="3" fill="#FF2D55"/>
                                        <rect x="88" y="74" width="12" height="12" rx="3" fill="#AF52DE"/>
                                        <rect x="104" y="74" width="12" height="12" rx="3" fill="#FF3B30"/>
                                        <rect x="120" y="74" width="12" height="12" rx="3" fill="#74b812"/>

                                        <rect x="72" y="90" width="12" height="12" rx="3" fill="#5856D6"/>
                                        <rect x="88" y="90" width="12" height="12" rx="3" fill="#007AFF"/>
                                        <rect x="104" y="90" width="12" height="12" rx="3" fill="#34C759"/>
                                        <rect x="120" y="90" width="12" height="12" rx="3" fill="#FF9500"/>
                                    </g>
                                    <!-- Dock -->
                                    <rect x="70" y="145" width="60" height="6" rx="3" fill="rgba(255,255,255,0.2)"/>
                                    <rect x="75" y="146" width="10" height="4" rx="2" fill="#007AFF"/>
                                    <rect x="90" y="146" width="10" height="4" rx="2" fill="#34C759"/>
                                    <rect x="105" y="146" width="10" height="4" rx="2" fill="#FF3B30"/>
                                    <rect x="120" y="146" width="10" height="4" rx="2" fill="#5AC8FA"/>

                                    <!-- Swift logo accent -->
                                    <g transform="translate(145, 45)">
                                        <circle cx="0" cy="0" r="18" fill="rgba(255,149,0,0.2)"/>
                                        <text x="0" y="6" text-anchor="middle" fill="#FF9500" font-size="16" font-weight="bold" font-family="Arial">S</text>
                                    </g>

                                    <!-- Apple logo -->
                                    <path d="M175 130 Q175 125 172 125 Q170 125 170 127 L170 133 Q170 135 172 135 Q175 135 175 133 L175 132 L173 132"
                                          fill="white" opacity="0.9"/>
                                    <circle cx="172" cy="123" r="1" fill="white" opacity="0.9"/>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Native iOS Development</h4>
                                <p class="service-card__description">
                                    Swift-based iOS apps optimized for iPhone and iPad. Native performance, seamless iOS integration, and full App Store compliance.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Native Android Development -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #3ddc84 0%, #2bb571 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Android phone frame -->
                                    <rect x="55" y="30" width="90" height="140" rx="10" fill="white" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                                    <!-- Screen -->
                                    <rect x="60" y="40" width="80" height="120" fill="#1a1a1a" rx="6"/>

                                    <!-- Material Design layers -->
                                    <g opacity="0.9">
                                        <!-- Top App Bar -->
                                        <rect x="65" y="45" width="70" height="10" fill="#3ddc84"/>
                                        <circle cx="70" cy="50" r="2" fill="white"/>
                                        <circle cx="130" cy="50" r="2" fill="white"/>
                                        <circle cx="125" cy="50" r="2" fill="white"/>

                                        <!-- FAB (Floating Action Button) -->
                                        <circle cx="125" cy="145" r="10" fill="#3ddc84"/>
                                        <path d="M125 140 L125 150 M120 145 L130 145" stroke="white" stroke-width="2"/>

                                        <!-- Cards -->
                                        <rect x="68" y="60" width="64" height="18" rx="4" fill="rgba(255,255,255,0.15)"/>
                                        <rect x="68" y="82" width="64" height="18" rx="4" fill="rgba(255,255,255,0.15)"/>
                                        <rect x="68" y="104" width="64" height="18" rx="4" fill="rgba(255,255,255,0.15)"/>

                                        <!-- Bottom Navigation -->
                                        <rect x="65" y="150" width="70" height="8" fill="rgba(0,0,0,0.3)"/>
                                        <circle cx="75" cy="154" r="2" fill="white"/>
                                        <circle cx="90" cy="154" r="2" fill="white"/>
                                        <circle cx="105" cy="154" r="2" fill="white"/>
                                        <circle cx="120" cy="154" r="2" fill="white"/>
                                    </g>

                                    <!-- Android robot -->
                                    <g transform="translate(160, 50)">
                                        <!-- Head -->
                                        <rect x="-8" y="0" width="16" height="12" rx="2" fill="white" opacity="0.95"/>
                                        <!-- Antennas -->
                                        <line x1="-4" y1="0" x2="-6" y2="-4" stroke="white" stroke-width="2" opacity="0.95"/>
                                        <line x1="4" y1="0" x2="6" y2="-4" stroke="white" stroke-width="2" opacity="0.95"/>
                                        <!-- Eyes -->
                                        <circle cx="-3" cy="5" r="1.5" fill="#3ddc84"/>
                                        <circle cx="3" cy="5" r="1.5" fill="#3ddc84"/>
                                        <!-- Body -->
                                        <rect x="-8" y="12" width="16" height="12" fill="white" opacity="0.95"/>
                                        <!-- Arms -->
                                        <rect x="-12" y="12" width="3" height="10" rx="1.5" fill="white" opacity="0.95"/>
                                        <rect x="9" y="12" width="3" height="10" rx="1.5" fill="white" opacity="0.95"/>
                                        <!-- Legs -->
                                        <rect x="-6" y="24" width="3" height="8" rx="1.5" fill="white" opacity="0.95"/>
                                        <rect x="3" y="24" width="3" height="8" rx="1.5" fill="white" opacity="0.95"/>
                                    </g>

                                    <!-- Kotlin symbol -->
                                    <text x="30" y="85" fill="white" font-size="20" font-weight="bold" opacity="0.3">K</text>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Native Android Development</h4>
                                <p class="service-card__description">
                                    Kotlin-powered Android apps for smartphones and tablets. Material Design implementation with full Google Play Store support.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Cross-Platform Apps -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #61dafb 0%, #4fa8c5 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Code sharing concept - Two devices with shared code -->

                                    <!-- Left phone (iOS) -->
                                    <rect x="30" y="60" width="50" height="80" rx="6" fill="white" opacity="0.95"/>
                                    <rect x="35" y="67" width="40" height="63" fill="#000" rx="3"/>
                                    <rect x="45" y="67" width="20" height="3" rx="1.5" fill="#1f1f1f"/>
                                    <g opacity="0.8">
                                        <rect x="40" y="75" width="8" height="8" rx="2" fill="#61dafb"/>
                                        <rect x="50" y="75" width="8" height="8" rx="2" fill="#4fa8c5"/>
                                        <rect x="40" y="86" width="8" height="8" rx="2" fill="#74b812"/>
                                        <rect x="50" y="86" width="8" height="8" rx="2" fill="#007AFF"/>
                                    </g>

                                    <!-- Right phone (Android) -->
                                    <rect x="120" y="60" width="50" height="80" rx="6" fill="white" opacity="0.95"/>
                                    <rect x="125" y="66" width="40" height="66" fill="#1a1a1a" rx="3"/>
                                    <rect x="130" y="68" width="30" height="6" fill="#3ddc84"/>
                                    <g opacity="0.8">
                                        <rect x="130" y="77" width="8" height="8" rx="2" fill="#61dafb"/>
                                        <rect x="140" y="77" width="8" height="8" rx="2" fill="#4fa8c5"/>
                                        <rect x="130" y="88" width="8" height="8" rx="2" fill="#74b812"/>
                                        <rect x="140" y="88" width="8" height="8" rx="2" fill="#3ddc84"/>
                                    </g>

                                    <!-- Central code module -->
                                    <rect x="80" y="85" width="40" height="30" rx="4" fill="white"/>
                                    <!-- Code brackets -->
                                    <text x="90" y="103" fill="#61dafb" font-size="14" font-weight="bold" font-family="monospace">&lt;/&gt;</text>

                                    <!-- Connection lines showing code sharing -->
                                    <path d="M80 100 L82 100" stroke="white" stroke-width="2"/>
                                    <path d="M118 100 L120 100" stroke="white" stroke-width="2"/>
                                    <line x1="82" y1="100" x2="80" y2="100" stroke="white" stroke-width="3" opacity="0.8"/>
                                    <line x1="118" y1="100" x2="120" y2="100" stroke="white" stroke-width="3" opacity="0.8"/>

                                    <!-- Data flow arrows -->
                                    <path d="M82 95 L90 100 L82 105" stroke="white" stroke-width="2" fill="none" opacity="0.7">
                                        <animate attributeName="opacity" values="0.3;0.9;0.3" dur="2s" repeatCount="indefinite"/>
                                    </path>
                                    <path d="M118 95 L110 100 L118 105" stroke="white" stroke-width="2" fill="none" opacity="0.7">
                                        <animate attributeName="opacity" values="0.3;0.9;0.3" dur="2s" repeatCount="indefinite" begin="1s"/>
                                    </path>

                                    <!-- React Native / Flutter badge -->
                                    <circle cx="100" cy="145" r="15" fill="white" opacity="0.9"/>
                                    <text x="100" y="151" text-anchor="middle" fill="#61dafb" font-size="18" font-weight="bold">RN</text>

                                    <!-- Efficiency indicator -->
                                    <g transform="translate(100, 50)">
                                        <circle cx="0" cy="0" r="12" fill="rgba(255,255,255,0.2)"/>
                                        <path d="M-4 0 L0 -6 L4 0 L0 4 Z" fill="#74b812"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Cross-Platform Apps</h4>
                                <p class="service-card__description">
                                    React Native and Flutter development. One codebase for iOS and Android, faster development, lower costs, consistent UX.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile UI/UX Design -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #74b812 0%, #5a9a0a 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Design canvas/artboard -->
                                    <rect x="50" y="40" width="100" height="120" rx="8" fill="white" opacity="0.95"/>

                                    <!-- Wireframe elements -->
                                    <g opacity="0.7">
                                        <!-- Header wireframe -->
                                        <rect x="58" y="48" width="84" height="12" rx="2" fill="none" stroke="#74b812" stroke-width="2" stroke-dasharray="4,2"/>
                                        <circle cx="64" cy="54" r="2" fill="#74b812"/>
                                        <line x1="70" y1="52" x2="90" y2="52" stroke="#74b812" stroke-width="1"/>
                                        <line x1="70" y1="56" x2="80" y2="56" stroke="#74b812" stroke-width="1"/>

                                        <!-- Content blocks -->
                                        <rect x="58" y="65" width="38" height="25" rx="3" fill="none" stroke="#74b812" stroke-width="2"/>
                                        <rect x="100" y="65" width="42" height="12" rx="2" fill="none" stroke="#74b812" stroke-width="1" stroke-dasharray="2,1"/>
                                        <rect x="100" y="80" width="42" height="5" rx="1" fill="none" stroke="#74b812" stroke-width="1" stroke-dasharray="2,1"/>
                                        <rect x="100" y="88" width="30" height="2" fill="#74b812" opacity="0.5"/>

                                        <!-- Button wireframe -->
                                        <rect x="58" y="95" width="84" height="10" rx="5" fill="none" stroke="#74b812" stroke-width="2"/>
                                        <text x="100" y="102" text-anchor="middle" fill="#74b812" font-size="6">CTA</text>

                                        <!-- List items -->
                                        <circle cx="62" cy="112" r="2" fill="#74b812"/>
                                        <line x1="68" y1="112" x2="135" y2="112" stroke="#74b812" stroke-width="1"/>
                                        <circle cx="62" cy="120" r="2" fill="#74b812"/>
                                        <line x1="68" y1="120" x2="135" y2="120" stroke="#74b812" stroke-width="1"/>
                                        <circle cx="62" cy="128" r="2" fill="#74b812"/>
                                        <line x1="68" y1="128" x2="135" y2="128" stroke="#74b812" stroke-width="1"/>
                                    </g>

                                    <!-- Design tools icons -->
                                    <g transform="translate(160, 55)">
                                        <!-- Pen tool -->
                                        <path d="M0 0 L4 8 L-4 8 Z" fill="white" opacity="0.9"/>
                                        <line x1="0" y1="8" x2="0" y2="14" stroke="white" stroke-width="2" opacity="0.9"/>
                                    </g>

                                    <g transform="translate(160, 80)">
                                        <!-- Color palette -->
                                        <circle cx="0" cy="0" r="3" fill="#74b812"/>
                                        <circle cx="8" cy="0" r="3" fill="white"/>
                                        <circle cx="4" cy="6" r="3" fill="#5a9a0a"/>
                                    </g>

                                    <!-- User-centered design icon -->
                                    <g transform="translate(30, 100)">
                                        <circle cx="0" cy="0" r="12" fill="rgba(255,255,255,0.3)"/>
                                        <circle cx="0" cy="-2" r="4" fill="white"/>
                                        <path d="M-6 6 Q-6 2 0 2 Q6 2 6 6" fill="white"/>
                                    </g>

                                    <!-- Touch gesture indicator -->
                                    <g transform="translate(170, 130)">
                                        <circle cx="0" cy="0" r="8" fill="rgba(255,255,255,0.4)">
                                            <animate attributeName="r" values="8;12;8" dur="2s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0.4;0.1;0.4" dur="2s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="0" cy="0" r="4" fill="white"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Mobile UI/UX Design</h4>
                                <p class="service-card__description">
                                    User research, wireframes, prototypes, and pixel-perfect mobile UI. Optimized for touch, gestures, and mobile-first interactions.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- App Store Submission -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- App Store icon (Apple) -->
                                    <g transform="translate(70, 100)">
                                        <rect x="-30" y="-30" width="60" height="60" rx="12" fill="white" opacity="0.95"/>
                                        <path d="M-10 -5 L-5 -15 M5 -15 L10 -5" stroke="#007AFF" stroke-width="3" stroke-linecap="round"/>
                                        <line x1="-15" y1="5" x2="15" y2="5" stroke="#007AFF" stroke-width="3" stroke-linecap="round"/>
                                        <path d="M-8 5 L-12 13 M12 13 L8 5" stroke="#007AFF" stroke-width="3" stroke-linecap="round"/>
                                        <text x="0" y="25" text-anchor="middle" fill="#007AFF" font-size="8" font-weight="bold">App Store</text>
                                    </g>

                                    <!-- Google Play icon -->
                                    <g transform="translate(130, 100)">
                                        <rect x="-30" y="-30" width="60" height="60" rx="12" fill="white" opacity="0.95"/>
                                        <!-- Play triangle -->
                                        <path d="M-10 -15 L-10 15 L10 0 Z" fill="#3ddc84"/>
                                        <path d="M-10 -15 L10 0 L-10 15" fill="none" stroke="#2bb571" stroke-width="2"/>
                                        <text x="0" y="25" text-anchor="middle" fill="#3ddc84" font-size="7" font-weight="bold">Google Play</text>
                                    </g>

                                    <!-- Upload/submission arrows -->
                                    <g transform="translate(100, 45)">
                                        <circle cx="0" cy="0" r="15" fill="rgba(255,255,255,0.3)"/>
                                        <path d="M0 8 L0 -8 M-6 -2 L0 -8 L6 -2" stroke="white" stroke-width="3" fill="none" stroke-linecap="round">
                                            <animateTransform
                                                attributeName="transform"
                                                type="translate"
                                                values="0,0; 0,-3; 0,0"
                                                dur="1.5s"
                                                repeatCount="indefinite"/>
                                        </path>
                                    </g>

                                    <!-- Checkmarks for approval -->
                                    <circle cx="55" cy="75" r="8" fill="#74b812"/>
                                    <path d="M52 75 L54 77 L58 72" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>

                                    <circle cx="145" cy="75" r="8" fill="#74b812"/>
                                    <path d="M142 75 L144 77 L148 72" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>

                                    <!-- Stars for rating -->
                                    <g transform="translate(100, 155)" opacity="0.9">
                                        <path d="M-20 0 L-18 6 L-12 6 L-17 10 L-15 16 L-20 12 L-25 16 L-23 10 L-28 6 L-22 6 Z" fill="white"/>
                                        <path d="M-8 0 L-6 6 L0 6 L-5 10 L-3 16 L-8 12 L-13 16 L-11 10 L-16 6 L-10 6 Z" fill="white"/>
                                        <path d="M4 0 L6 6 L12 6 L7 10 L9 16 L4 12 L-1 16 L1 10 L-4 6 L2 6 Z" fill="white"/>
                                        <path d="M16 0 L18 6 L24 6 L19 10 L21 16 L16 12 L11 16 L13 10 L8 6 L14 6 Z" fill="white"/>
                                        <path d="M28 0 L30 6 L36 6 L31 10 L33 16 L28 12 L23 16 L25 10 L20 6 L26 6 Z" fill="#f59e0b" opacity="0.3"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">App Store Submission</h4>
                                <p class="service-card__description">
                                    Complete App Store and Google Play submission. Screenshots, descriptions, compliance reviews, and approval management.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- App Maintenance & Updates -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Phone with update cycle -->
                                    <rect x="70" y="50" width="60" height="100" rx="8" fill="white" opacity="0.95"/>
                                    <rect x="75" y="60" width="50" height="80" fill="#1a1a1a" rx="4"/>

                                    <!-- Update progress -->
                                    <circle cx="100" cy="100" r="20" fill="none" stroke="rgba(139,92,246,0.3)" stroke-width="3"/>
                                    <circle cx="100" cy="100" r="20" fill="none" stroke="#8b5cf6" stroke-width="3"
                                            stroke-dasharray="125" stroke-dashoffset="30" stroke-linecap="round">
                                        <animateTransform
                                            attributeName="transform"
                                            type="rotate"
                                            from="0 100 100"
                                            to="360 100 100"
                                            dur="3s"
                                            repeatCount="indefinite"/>
                                    </circle>

                                    <!-- Update percentage -->
                                    <text x="100" y="105" text-anchor="middle" fill="#8b5cf6" font-size="14" font-weight="bold">75%</text>

                                    <!-- Update icon -->
                                    <g transform="translate(100, 85)">
                                        <path d="M-4 0 L0 -6 L4 0" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                                        <path d="M-4 -3 L0 3 L4 -3" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                                    </g>

                                    <!-- Version numbers -->
                                    <text x="82" y="128" fill="rgba(255,255,255,0.5)" font-size="8">v2.1</text>
                                    <text x="105" y="128" fill="white" font-size="8" font-weight="bold">→ v2.2</text>

                                    <!-- Circular update cycle arrows -->
                                    <g transform="translate(40, 100)">
                                        <circle cx="0" cy="0" r="15" fill="rgba(255,255,255,0.2)"/>
                                        <path d="M0 -10 A10 10 0 1 1 0 10" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                                        <path d="M-3 -7 L0 -10 L3 -7" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                                    </g>

                                    <g transform="translate(160, 100)">
                                        <circle cx="0" cy="0" r="15" fill="rgba(255,255,255,0.2)"/>
                                        <path d="M0 10 A10 10 0 1 1 0 -10" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                                        <path d="M3 7 L0 10 L-3 7" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                                    </g>

                                    <!-- Maintenance tools -->
                                    <g transform="translate(45, 60)">
                                        <rect x="-3" y="0" width="6" height="15" rx="1" fill="white" opacity="0.8"/>
                                        <circle cx="0" cy="3" r="3" fill="none" stroke="white" stroke-width="1.5" opacity="0.8"/>
                                    </g>

                                    <!-- Bug fixes checkmark -->
                                    <g transform="translate(155, 65)">
                                        <circle cx="0" cy="0" r="8" fill="#74b812"/>
                                        <path d="M-3 0 L-1 2 L3 -3" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                                    </g>

                                    <!-- Performance gauge -->
                                    <g transform="translate(100, 160)">
                                        <path d="M-12 0 A12 12 0 0 1 12 0" stroke="rgba(255,255,255,0.3)" stroke-width="2" fill="none"/>
                                        <path d="M-12 0 A12 12 0 0 1 8 -8" stroke="#74b812" stroke-width="2" fill="none" stroke-linecap="round"/>
                                        <circle cx="0" cy="0" r="2" fill="white"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Maintenance & Updates</h4>
                                <p class="service-card__description">
                                    Ongoing app support, OS updates, bug fixes, feature enhancements, and performance monitoring to keep your app running smoothly.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- ========================== Process Section ============================= -->
        <section class="process-section" id="process-section">
            <div class="container process-content">
                <div class="row align-items-start">
                    <!-- Left Column: Title & Description -->
                    <div class="col-lg-5 mb-5 mb-lg-0">
                        <div class="sticky-top" style="top: 120px;">
          <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-white fw-medium tw-text-sm tw-mb-4"
                                  style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                  Our Process
                                </span>
                            <h2 class="text-white mb-4" style="font-size: 3.5rem; font-weight: 700; line-height: 1.1; margin-top: 20px;">
                                Mobile app development, <span style="font-style: italic; color: #74b812;">minus the complexity</span>
                            </h2>
                            <p class="text-white mb-5" style="opacity: 0.8; font-size: 1.125rem; line-height: 1.7;">
                                From concept to App Store launch. Our proven process delivers production-ready mobile apps on time and on budget.
                            </p>
                            <a href="{{ url('/contact') }}" class="btn btn-lg fw-bold px-5 py-3 hover--translate-y-1" style="background: #74b812; color: white; border-radius: 50px; border: none;">
                                Book Your Free Discovery Call <i class="ph-bold ph-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Vertical Timeline -->
                    <div class="col-lg-7">
                        <div class="process-timeline">
                            <!-- Vertical Line -->
                            <div class="timeline-line">
                                <div class="timeline-line-progress" id="timeline-progress"></div>
                            </div>

                            <!-- Step 1 -->
                            <div class="process-step" data-step="1">
                                <div class="process-step__number">1</div>
                                <h4 class="process-step__title">Discovery and planning</h4>
                                <p class="process-step__description">
                                    We define your app requirements, target platforms, user personas, and core features. Technical architecture planning begins here.
                                </p>
                            </div>

                            <!-- Step 2 -->
                            <div class="process-step" data-step="2">
                                <div class="process-step__number">2</div>
                                <h4 class="process-step__title">Design and prototyping</h4>
                                <p class="process-step__description">
                                    Mobile-first wireframes, interactive prototypes, and pixel-perfect UI design. User testing ensures intuitive mobile experience.
                                </p>
                            </div>

                            <!-- Step 3 -->
                            <div class="process-step" data-step="3">
                                <div class="process-step__number">3</div>
                                <h4 class="process-step__title">Native development</h4>
                                <p class="process-step__description">
                                    Swift/Kotlin for native apps or React Native/Flutter for cross-platform. Clean code, scalable architecture, offline-first approach.
                                </p>
                            </div>

                            <!-- Step 4 -->
                            <div class="process-step" data-step="4">
                                <div class="process-step__number">4</div>
                                <h4 class="process-step__title">Backend integration</h4>
                                <p class="process-step__description">
                                    API development, database setup, cloud services integration, push notifications, and real-time sync capabilities.
                                </p>
                            </div>

                            <!-- Step 5 -->
                            <div class="process-step" data-step="5">
                                <div class="process-step__number">5</div>
                                <h4 class="process-step__title">Testing and submission</h4>
                                <p class="process-step__description">
                                    Comprehensive testing on real devices, bug fixes, App Store/Play Store submission, and approval management.
                                </p>
                            </div>

                            <!-- Step 6 -->
                            <div class="process-step" data-step="6">
                                <div class="process-step__number">6</div>
                                <h4 class="process-step__title">Launch and support</h4>
                                <p class="process-step__description">
                                    App launch coordination, user onboarding, analytics setup, ongoing maintenance, OS updates, and feature enhancements.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================== Final CTA Section ============================= -->
        <section class="final-cta-section">
            <div class="container">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">

                        <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-black fw-medium tw-text-sm tw-mb-4"
                              style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                  Ready To Get Started?
                                </span>
                        <h2 class="section-title  mb-4">
                            Now imagine this <span style="font-style: italic; color: #74b812;">creative power</span> behind your next project
                        </h2>
                        <p class="section-subtitle  mb-5" style="opacity: 0.9;">
                            This is just one of many creative services—what you do with them is up to you. Let's build something remarkable together.
                        </p>
                        <a href="{{ url('/contact') }}" class="btn btn-lg fw-bold px-5 py-3 hover--translate-y-1" style="background: #74b812; color: white; border-radius: 50px; border: none;">
                            Book Your Free Discovery Call <i class="ph-bold ph-arrow-right ms-2"></i>
                        </a>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800">
                        <div class="final-cta__image">
                            <img src="/assets/images/thumbs/services/13.png" alt="ShiftTech Web Design" class="w-100 h-100 object-fit-cover">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================== FAQ Section ============================= -->
        <section class="faq-section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="800">
                    <span class="section-badge">got questions?</span>
                    <h2 class="section-title mb-3">
                        Frequently Asked <span style="font-style: italic; color: #74b812;">Questions</span>
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>How long does it take to develop a mobile app?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Most mobile apps take 8-12 weeks from start to finish. Simple apps with basic features can be ready in 6-8 weeks. Complex apps with advanced features, custom animations, and backend integration may take 12-16 weeks. Timeline depends on features, platforms (iOS, Android, or both), and complexity.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Do you build apps for both iOS and Android?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Yes! We build native apps using Swift for iOS and Kotlin for Android. We also develop cross-platform apps using React Native or Flutter, which allows us to build one codebase that works on both iOS and Android, reducing development time and cost by up to 40%.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Will you handle App Store and Play Store submission?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Absolutely! We handle the entire submission process for both Apple App Store and Google Play Store. This includes preparing all required assets, writing store descriptions, setting up screenshots, handling app review responses, and managing the approval process. We have a 100% first-time approval success rate.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>How much does it cost to develop a mobile app?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Costs vary based on complexity and features. Simple apps start around $15,000-$30,000. Medium complexity apps with custom features range from $30,000-$60,000. Complex apps with advanced features, real-time capabilities, and backend infrastructure can range from $60,000-$150,000+. We provide detailed quotes after understanding your requirements.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Do you provide ongoing maintenance and updates?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Yes! We offer comprehensive maintenance packages including bug fixes, OS compatibility updates, security patches, performance optimization, and new feature development. Mobile apps need regular updates to stay compatible with new iOS and Android versions. We provide 3 months of free support after launch, then offer flexible monthly maintenance plans.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Can you add features to my existing app?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Yes! We can enhance existing mobile apps by adding new features, improving performance, redesigning the UI/UX, integrating third-party services, or completely refactoring outdated code. We work with apps built in any technology stack including native iOS/Android, React Native, Flutter, and hybrid frameworks.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Floating CTA Button -->
        <a href="{{ url('/contact') }}" class="floating-cta btn btn-main-two hover-style-two button--stroke d-none d-md-inline-flex align-items-center justify-content-center tw-gap-3 group tw-px-6 rounded-pill tw-py-3 fw-semibold">
            <span class="button__flair"></span>
            <i class="ph ph-phone-call tw-text-xl tw-text-white"></i>
            <span class="button__label">Get Started</span>
        </a>

    </div>

    <!-- FAQ Toggle Script -->
    <script>
        function toggleFAQ(element) {
            const faqItem = element.closest('.faq-item');
            const allFaqItems = document.querySelectorAll('.faq-item');

            // Close all other FAQs
            allFaqItems.forEach(item => {
                if (item !== faqItem) {
                    item.classList.remove('active');
                }
            });

            // Toggle current FAQ
            faqItem.classList.toggle('active');
        }

        // Process Timeline Scroll Animation
        document.addEventListener('DOMContentLoaded', function() {
            const processSection = document.getElementById('process-section');
            const timelineProgress = document.getElementById('timeline-progress');
            const processSteps = document.querySelectorAll('.process-step');

            if (!processSection || !timelineProgress || processSteps.length === 0) return;

            // Intersection Observer for individual steps
            const stepObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.5,
                rootMargin: '-100px 0px -100px 0px'
            });

            // Observe each step
            processSteps.forEach(step => {
                stepObserver.observe(step);
            });

            // Scroll progress line animation
            function updateTimelineProgress() {
                const section = processSection;
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                const scrollPosition = window.scrollY + window.innerHeight / 2;

                // Calculate progress within the section
                const progress = (scrollPosition - sectionTop) / sectionHeight;
                const clampedProgress = Math.max(0, Math.min(1, progress));

                // Update timeline progress height
                timelineProgress.style.height = `${clampedProgress * 100}%`;
            }

            // Update on scroll with throttle for performance
            let ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        updateTimelineProgress();
                        ticking = false;
                    });
                    ticking = true;
                }
            });

            // Initial update
            updateTimelineProgress();
        });
    </script>
@endsection
