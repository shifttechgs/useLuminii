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
            object-fit: cover;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
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
            text-transform: lowercase;
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
                                   DevOps & Cloud Infrastructure
                                </span>
                            <h1 class="service-hero__title">
                                Cloud-native infrastructure built for<span style="font-style: italic; color: #74b812;"> scale and reliability</span>
                            </h1>
                            <p class="service-hero__subtitle">
                                From CI/CD pipelines to cloud architecture, we build and manage infrastructure that scales automatically, recovers from failures, and keeps your applications running 24/7.
                            </p>

                            <!-- Trust Badges -->
                            <div class="d-flex flex-wrap tw-gap-3 mb-4">
                                <span class="trust-badge">
                                    <i class="ph-bold ph-check-circle"></i>
                                    99.9% Uptime SLA
                                </span>
                                <span class="trust-badge">
                                    <i class="ph-bold ph-clock"></i>
                                    24/7 Monitoring
                                </span>
                                <span class="trust-badge">
                                    <i class="ph-bold ph-shield-check"></i>
                                    Auto-Scaling
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
                            <img src="/assets/images/thumbs/services/12.png" alt="DevOps & Cloud Infrastructure" style="width: 100%; height: auto;">
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

                        {{--                        <div class="swiper-slide">--}}
                        {{--                            <div class="text-center tw-py-4 tw-px-4 brand-item-hover">--}}
                        {{--                                <img src="assets/images/logo/clients/trax_boats_dark.png" alt="Vision Plus Wealth" class="brand-logo tw-max-h-12 w-auto mx-auto" style="filter: grayscale(100%); opacity: 0.6;">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
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

                        {{--                        <div class="swiper-slide">--}}
                        {{--                            <div class="text-center tw-py-4 tw-px-4 brand-item-hover">--}}
                        {{--                                <img src="assets/images/logo/clients/wcbs_header_logo.png" alt="WesternCape Blood Service" class="brand-logo tw-max-h-12 w-auto mx-auto" style="filter: grayscale(100%); opacity: 0.6;">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

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

        <!-- ========================== Why Web Section ============================= -->
        <section class="value-section">
            <div class="container">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">

                        <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-black fw-medium tw-text-sm tw-mb-4"
                              style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                  Why DevOps & Cloud Matter
                                </span>
                        <h2 class="section-title">
                            Manual deployments break, cloud infrastructure <span style="font-style: italic; color: #74b812;">scales automatically</span>
                        </h2>
                        <p class="section-subtitle mb-4">
                            Modern applications need infrastructure that adapts to demand, recovers from failures, and deploys updates without downtime. DevOps practices and cloud-native architecture make this possible.
                        </p>
                        <div class="d-flex align-items-start tw-gap-3 mb-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0"><strong>Automated CI/CD</strong> pipelines reduce deployment time from hours to minutes</p>
                        </div>
                        <div class="d-flex align-items-start tw-gap-3 mb-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0"><strong>Auto-scaling</strong> infrastructure handles traffic spikes without manual intervention</p>
                        </div>
                        <div class="d-flex align-items-start tw-gap-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0">Infrastructure as code ensures consistency and enables disaster recovery</p>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800">
                        <div class="value-section__image">
                            <img src="/assets/images/thumbs/services/14.png" alt="Cloud Infrastructure" class="w-100 h-100 object-fit-cover">
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
                    <h2 class="section-title text-white mb-3">
                        A <span style="font-style: italic; color: #74b812;">DevOps & cloud partner</span> you can trust
                    </h2>
                </div>

                <div class="row g-5 justify-content-center text-center">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600">
                        <div class="metric-item">
                            <div class="metric-item__number">99.9%</div>
                            <p class="metric-item__description">Average uptime across all managed infrastructure</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                        <div class="metric-item">
                            <div class="metric-item__number">80%</div>
                            <p class="metric-item__description">Reduction in deployment time with automated CI/CD pipelines</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                        <div class="metric-item">
                            <div class="metric-item__number">50%</div>
                            <p class="metric-item__description">Cost savings through cloud optimization and right-sizing</p>
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
                                 ShiftTech Cloud Solutions
                                </span>
                        <h2 class="section-title">
                            Deploy faster, scale smarter, <span style="font-style: italic; color: #74b812;">sleep better</span>
                        </h2>
                        <p class="section-subtitle mb-4">
                            We manage cloud infrastructure on AWS, Google Cloud, and Azure. From Kubernetes orchestration to serverless architectures, we build systems that scale automatically and recover from failures.
                        </p>
                        <p class="section-subtitle mb-5">
                            Complete DevOps lifecycle management including CI/CD automation, infrastructure as code, monitoring, security, and 24/7 support.
                        </p>
                        <a href="{{ url('/contact') }}" class="btn btn-lg fw-bold px-5 py-3 hover--translate-y-1" style="background: #74b812; color: white; border-radius: 50px; border: none;">
                            Book Your Free Discovery Call <i class="ph-bold ph-arrow-right ms-2"></i>
                        </a>
                    </div>

                    <div class="col-lg-6 order-lg-1" data-aos="fade-right" data-aos-duration="800">
                        <div class="integrated-section__image">
                            <img src="/assets/images/thumbs/services/14.png" alt="Cloud Infrastructure Solutions" class="w-100 h-100 object-fit-cover">
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
                        DevOps & cloud services, <span style="font-style: italic; color: #74b812;">built for reliability</span>
                    </h2>
                </div>

                <div class="row g-4">
                    <!-- CI/CD Pipeline Setup -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #74b812 0%, #5a9a0a 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="ph-bold ph-git-branch" style="font-size: 5rem; color: rgba(255,255,255,0.9);"></i>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">CI/CD Pipeline Setup</h4>
                                <p class="service-card__description">
                                    Automated build, test, and deployment pipelines using Jenkins, GitLab CI, GitHub Actions, or CircleCI. Deploy code from commit to production in minutes, not hours.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Cloud Infrastructure Management -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #0a3622 0%, #002b22 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="ph-bold ph-cloud" style="font-size: 5rem; color: rgba(116, 184, 18, 0.9);"></i>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Cloud Infrastructure Management</h4>
                                <p class="service-card__description">
                                    Complete cloud setup and management on AWS, Azure, or Google Cloud. Auto-scaling, load balancing, database optimization, and 24/7 monitoring included.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Container Orchestration -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="ph-bold ph-package" style="font-size: 5rem; color: rgba(255,255,255,0.9);"></i>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Container Orchestration</h4>
                                <p class="service-card__description">
                                    Docker containerization and Kubernetes cluster management for consistent deployments, zero-downtime updates, and efficient resource utilization at scale.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Infrastructure as Code -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="ph-bold ph-file-code" style="font-size: 5rem; color: rgba(255,255,255,0.9);"></i>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Infrastructure as Code</h4>
                                <p class="service-card__description">
                                    Version-controlled infrastructure using Terraform, AWS CloudFormation, or Ansible. Reproducible environments, automated provisioning, and disaster recovery made simple.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Monitoring & Alerting -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="ph-bold ph-chart-line" style="font-size: 5rem; color: rgba(255,255,255,0.9);"></i>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Monitoring & Alerting</h4>
                                <p class="service-card__description">
                                    Real-time monitoring with Prometheus, Grafana, ELK Stack, or Datadog. Custom dashboards, intelligent alerting, and incident response that keeps your systems running 24/7.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Security & Compliance -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="ph-bold ph-shield-check" style="font-size: 5rem; color: rgba(255,255,255,0.9);"></i>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Security & Compliance</h4>
                                <p class="service-card__description">
                                    Security hardening, SSL/TLS management, firewall configuration, automated backups, and compliance with SOC 2, HIPAA, or GDPR requirements for your industry.
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
                                DevOps workflows, <span style="font-style: italic; color: #74b812;">engineered for reliability</span>
                            </h2>
                            <p class="text-white mb-5" style="opacity: 0.8; font-size: 1.125rem; line-height: 1.7;">
                                No manual deployments, infrastructure guesswork, or downtime surprises. Just a proven system for automated, scalable cloud infrastructure.
                            </p>
                            <a href="{{ url('/contact') }}" class="btn btn-lg fw-bold px-5 py-3 hover--translate-y-1" style="background: #74b812; color: white; border-radius: 50px; border: none;">
                                Schedule a consultation <i class="ph-bold ph-arrow-right ms-2"></i>
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
                                <h4 class="process-step__title">Infrastructure assessment</h4>
                                <p class="process-step__description">
                                    We analyze your current infrastructure, identify bottlenecks, and design a cloud architecture that scales with your business needs.
                                </p>
                            </div>

                            <!-- Step 2 -->
                            <div class="process-step" data-step="2">
                                <div class="process-step__number">2</div>
                                <h4 class="process-step__title">DevOps team assignment</h4>
                                <p class="process-step__description">
                                    Get dedicated DevOps engineers, cloud architects, and security specialists assigned to your project with direct access throughout.
                                </p>
                            </div>

                            <!-- Step 3 -->
                            <div class="process-step" data-step="3">
                                <div class="process-step__number">3</div>
                                <h4 class="process-step__title">CI/CD pipeline setup</h4>
                                <p class="process-step__description">
                                    Automated build, test, and deployment pipelines configured with your git workflow. Deploy code from commit to production in minutes.
                                </p>
                            </div>

                            <!-- Step 4 -->
                            <div class="process-step" data-step="4">
                                <div class="process-step__number">4</div>
                                <h4 class="process-step__title">Infrastructure deployment</h4>
                                <p class="process-step__description">
                                    Cloud infrastructure provisioned using Infrastructure as Code (Terraform/CloudFormation) with auto-scaling, load balancing, and database optimization.
                                </p>
                            </div>

                            <!-- Step 5 -->
                            <div class="process-step" data-step="5">
                                <div class="process-step__number">5</div>
                                <h4 class="process-step__title">Monitoring & security</h4>
                                <p class="process-step__description">
                                    24/7 monitoring setup with Prometheus/Grafana, automated alerting, security hardening, SSL configuration, and backup automation.
                                </p>
                            </div>

                            <!-- Step 6 -->
                            <div class="process-step" data-step="6">
                                <div class="process-step__number">6</div>
                                <h4 class="process-step__title">Ongoing optimization</h4>
                                <p class="process-step__description">
                                    Continuous infrastructure optimization, cost reduction recommendations, performance tuning, and incident response as your application grows.
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
                                  Ready To Scale Your Infrastructure?
                                </span>
                        <h2 class="section-title  mb-4">
                            Now imagine this <span style="font-style: italic; color: #74b812;">engineering excellence</span> powering your applications
                        </h2>
                        <p class="section-subtitle  mb-5" style="opacity: 0.9;">
                            DevOps & Cloud is just one of many technical services we offer. From automated deployments to 99.9% uptime SLA, let's build infrastructure that scales.
                        </p>

                        <a href="{{ url('/contact') }}" class="btn btn-lg fw-bold px-5 py-3 hover--translate-y-1" style="background: #74b812; color: white; border-radius: 50px; border: none;">
                            Book Your Free Infrastructure Consultation <i class="ph-bold ph-arrow-right ms-2"></i>
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

                    <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-black fw-medium tw-text-sm tw-mb-4"
                          style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                  Got Questions
                                </span>
                    <h2 class="section-title mb-3">
                        Frequently Asked <span style="font-style: italic; color: #74b812;">Questions</span>
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>What cloud platforms do you support?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                We manage infrastructure on all major cloud platforms including AWS (Amazon Web Services), Google Cloud Platform (GCP), and Microsoft Azure. We also work with DigitalOcean, Linode, and other providers. We'll recommend the best platform based on your specific needs, budget, and technical requirements.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>What's included in your DevOps services?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Complete DevOps lifecycle management including CI/CD pipeline setup, infrastructure as code (Terraform/CloudFormation), container orchestration (Docker/Kubernetes), automated testing, deployment automation, monitoring and alerting (Prometheus/Grafana), log aggregation, security hardening, backup automation, and 24/7 incident response.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Can you migrate our existing infrastructure to the cloud?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Absolutely! We specialize in cloud migration from on-premise servers or between cloud providers. We assess your current infrastructure, design a migration strategy, handle data migration, minimize downtime, and ensure everything works seamlessly in the new environment. Most migrations are completed with zero to minimal downtime.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>How do you ensure high availability and uptime?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                We implement redundancy at every layer including multi-availability-zone deployments, load balancing, auto-scaling, database replication, automated failover, health checks, and disaster recovery plans. We provide 24/7 monitoring with automated alerts and incident response. Our managed infrastructure maintains 99.9% uptime SLA with most systems exceeding 99.95%.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>How much do DevOps and cloud services cost?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Costs depend on infrastructure complexity and support level. Initial setup ranges from $5,000-$30,000. Ongoing managed services start at $2,000/month for small applications and scale based on infrastructure size, traffic, and support requirements. We often save clients 30-50% on cloud costs through optimization and right-sizing. All quotes include both our services and estimated cloud provider costs.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Do you provide 24/7 monitoring and support?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Yes! Our managed services include 24/7 infrastructure monitoring, automated alerting, and incident response. We monitor server health, application performance, security threats, and resource usage. Critical alerts trigger immediate response from our on-call engineers. We provide detailed monthly reports on uptime, performance metrics, and optimization recommendations.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>




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
