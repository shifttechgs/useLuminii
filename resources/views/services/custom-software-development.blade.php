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
                                   Custom Software
                                </span>
                            <h1 class="service-hero__title">
                                Enterprise software solutions tailored to your<span style="font-style: italic; color: #74b812;"> business</span>
                            </h1>
                            <p class="service-hero__subtitle">
                                From business automation to complex integrations, we build custom software that solves unique challenges and scales with your operations.
                            </p>

                            <!-- Trust Badges -->
                            <div class="d-flex flex-wrap tw-gap-3 mb-4">
                                <span class="trust-badge">
                                    <i class="ph-bold ph-check-circle"></i>
                                    100+ Projects Delivered
                                </span>
                                <span class="trust-badge">
                                    <i class="ph-bold ph-clock"></i>
                                    Agile Development
                                </span>
                                <span class="trust-badge">
                                    <i class="ph-bold ph-shield-check"></i>
                                    Scalable Architecture
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
                            <img src="/assets/images/thumbs/services/4.png" alt="Custom Software Development" style="width: 100%; height: auto;">
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
                                   Why Custom Software Matters
                                </span>
                        <h2 class="section-title">
                            Off-the-shelf solutions don't fit, custom software <span style="font-style: italic; color: #74b812;">solves unique problems</span>
                        </h2>
                        <p class="section-subtitle mb-4">
                            Every business has unique workflows, processes, and challenges. Custom software gives you competitive advantages that generic solutions can't provide.
                        </p>
                        <div class="d-flex align-items-start tw-gap-3 mb-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0"><strong>Tailored solutions</strong> that match your exact business requirements</p>
                        </div>
                        <div class="d-flex align-items-start tw-gap-3 mb-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0"><strong>Scalable architecture</strong> that grows with your business needs</p>
                        </div>
                        <div class="d-flex align-items-start tw-gap-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0">Full ownership and control over your technology stack and data</p>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800">
                        <div class="value-section__image">
                            <img src="/assets/images/thumbs/services/1.png" alt="Custom Software Solutions" class="w-100 h-100 object-fit-cover">
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
                        A <span style="font-style: italic; color: #74b812;">custom software development partner</span> you can trust
                    </h2>
                </div>

                <div class="row g-5 justify-content-center text-center">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600">
                        <div class="metric-item">
                            <div class="metric-item__number">100+</div>
                            <p class="metric-item__description">Custom software projects delivered across industries</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                        <div class="metric-item">
                            <div class="metric-item__number">75%</div>
                            <p class="metric-item__description">Reduction in manual processes through automation</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                        <div class="metric-item">
                            <div class="metric-item__number">99.9%</div>
                            <p class="metric-item__description">Average uptime across all production systems</p>
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
{{--                        <span class="section-badge">ShiftTech software solutions</span>--}}
                        <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-black fw-medium tw-text-sm tw-mb-4"
                              style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                  ShiftTech Software Solutions
                                </span>
                        <h2 class="section-title">
                            Build smarter, automate faster, <span style="font-style: italic; color: #74b812;">scale confidently</span>
                        </h2>
                        <p class="section-subtitle mb-4">
                            We build enterprise-grade custom software using modern tech stacks including Laravel, React, Node.js, and Python. Full-stack development teams with expertise in databases, APIs, and cloud infrastructure.
                        </p>
                        <p class="section-subtitle mb-5">
                            From requirements gathering to deployment and maintenance, we handle the entire software development lifecycle with agile methodologies and continuous delivery.
                        </p>
                        <a href="{{ url('/contact') }}" class="btn btn-lg fw-bold px-5 py-3 hover--translate-y-1" style="background: #74b812; color: white; border-radius: 50px; border: none;">
                            Book Your Free Discovery Call <i class="ph-bold ph-arrow-right ms-2"></i>
                        </a>
                    </div>

                    <div class="col-lg-6 order-lg-1" data-aos="fade-right" data-aos-duration="800">
                        <div class="integrated-section__image">
                            <img src="/assets/images/thumbs/services/7.png" alt="Custom Software Solutions" class="w-100 h-100 object-fit-cover">
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
                        Custom software development services, <span style="font-style: italic; color: #74b812;">built to scale</span>
                    </h2>
                </div>

                <div class="row g-4">
                    <!-- Business Automation -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #74b812 0%, #5a9a0a 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Gear mechanism representing automation -->
                                    <circle cx="100" cy="100" r="45" fill="rgba(255,255,255,0.2)" stroke="white" stroke-width="3"/>
                                    <circle cx="100" cy="100" r="25" fill="white"/>
                                    <!-- Rotating gears -->
                                    <g transform="rotate(0 100 100)">
                                        <path d="M100 45 L105 55 L95 55 Z" fill="white"/>
                                        <path d="M100 155 L105 145 L95 145 Z" fill="white"/>
                                        <path d="M45 100 L55 95 L55 105 Z" fill="white"/>
                                        <path d="M155 100 L145 95 L145 105 Z" fill="white"/>
                                        <path d="M65 65 L72 68 L68 75 Z" fill="white"/>
                                        <path d="M135 135 L128 132 L132 125 Z" fill="white"/>
                                        <path d="M135 65 L132 72 L125 68 Z" fill="white"/>
                                        <path d="M65 135 L68 128 L75 132 Z" fill="white"/>
                                    </g>
                                    <!-- Lightning bolt for automation power -->
                                    <path d="M110 85 L95 105 L105 105 L90 125 L110 100 L100 100 Z" fill="#74b812" opacity="0.8"/>
                                    <!-- Connection nodes -->
                                    <circle cx="60" cy="60" r="8" fill="white" opacity="0.6"/>
                                    <circle cx="140" cy="60" r="8" fill="white" opacity="0.6"/>
                                    <circle cx="140" cy="140" r="8" fill="white" opacity="0.6"/>
                                    <line x1="100" y1="100" x2="60" y2="60" stroke="white" stroke-width="2" opacity="0.4"/>
                                    <line x1="100" y1="100" x2="140" y2="60" stroke="white" stroke-width="2" opacity="0.4"/>
                                    <line x1="100" y1="100" x2="140" y2="140" stroke="white" stroke-width="2" opacity="0.4"/>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Business Automation</h4>
                                <p class="service-card__description">
                                    Automate repetitive tasks, streamline workflows, and reduce manual errors with intelligent process automation tailored to your operations.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Enterprise Applications -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #0a3622 0%, #002b22 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Building/Enterprise structure -->
                                    <rect x="60" y="40" width="80" height="120" rx="4" fill="rgba(255,255,255,0.2)" stroke="white" stroke-width="3"/>
                                    <rect x="70" y="50" width="60" height="100" fill="rgba(116,184,18,0.3)"/>
                                    <!-- Windows grid -->
                                    <g opacity="0.8">
                                        <rect x="75" y="60" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="93" y="60" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="111" y="60" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="75" y="78" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="93" y="78" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="111" y="78" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="75" y="96" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="93" y="96" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="111" y="96" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="75" y="114" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="93" y="114" width="12" height="12" fill="white" rx="2"/>
                                        <rect x="111" y="114" width="12" height="12" fill="white" rx="2"/>
                                    </g>
                                    <!-- Security shield overlay -->
                                    <path d="M100 130 L85 135 L85 150 Q85 160 100 165 Q115 160 115 150 L115 135 Z" fill="white" opacity="0.9"/>
                                    <path d="M95 145 L98 150 L108 140" stroke="#74b812" stroke-width="3" fill="none" stroke-linecap="round"/>
                                    <!-- Data flow lines -->
                                    <circle cx="40" cy="100" r="6" fill="#74b812"/>
                                    <circle cx="160" cy="100" r="6" fill="#74b812"/>
                                    <path d="M46 100 L54 100" stroke="#74b812" stroke-width="2" stroke-dasharray="2,2"/>
                                    <path d="M146 100 L154 100" stroke="#74b812" stroke-width="2" stroke-dasharray="2,2"/>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Enterprise Applications</h4>
                                <p class="service-card__description">
                                    Large-scale enterprise software with complex business logic, multi-user roles, and advanced security features.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- API Development -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Central hub -->
                                    <circle cx="100" cy="100" r="30" fill="white"/>
                                    <circle cx="100" cy="100" r="20" fill="#f59e0b"/>
                                    <text x="100" y="108" text-anchor="middle" fill="white" font-size="16" font-weight="bold" font-family="monospace">API</text>
                                    <!-- Connected nodes -->
                                    <circle cx="50" cy="50" r="15" fill="rgba(255,255,255,0.9)" stroke="white" stroke-width="2"/>
                                    <circle cx="150" cy="50" r="15" fill="rgba(255,255,255,0.9)" stroke="white" stroke-width="2"/>
                                    <circle cx="50" cy="150" r="15" fill="rgba(255,255,255,0.9)" stroke="white" stroke-width="2"/>
                                    <circle cx="150" cy="150" r="15" fill="rgba(255,255,255,0.9)" stroke="white" stroke-width="2"/>
                                    <circle cx="100" cy="35" r="12" fill="rgba(255,255,255,0.9)" stroke="white" stroke-width="2"/>
                                    <circle cx="165" cy="100" r="12" fill="rgba(255,255,255,0.9)" stroke="white" stroke-width="2"/>
                                    <!-- Connection lines with data flow -->
                                    <line x1="70" y1="100" x2="60" y2="60" stroke="white" stroke-width="3" opacity="0.6"/>
                                    <line x1="130" y1="100" x2="140" y2="60" stroke="white" stroke-width="3" opacity="0.6"/>
                                    <line x1="70" y1="100" x2="60" y2="140" stroke="white" stroke-width="3" opacity="0.6"/>
                                    <line x1="130" y1="100" x2="140" y2="140" stroke="white" stroke-width="3" opacity="0.6"/>
                                    <line x1="100" y1="70" x2="100" y2="47" stroke="white" stroke-width="3" opacity="0.6"/>
                                    <line x1="130" y1="100" x2="153" y2="100" stroke="white" stroke-width="3" opacity="0.6"/>
                                    <!-- Data packets -->
                                    <circle cx="85" cy="75" r="4" fill="#74b812">
                                        <animate attributeName="cx" values="85;65;85" dur="3s" repeatCount="indefinite"/>
                                        <animate attributeName="cy" values="75;55;75" dur="3s" repeatCount="indefinite"/>
                                    </circle>
                                    <circle cx="115" cy="75" r="4" fill="#74b812">
                                        <animate attributeName="cx" values="115;145;115" dur="2.5s" repeatCount="indefinite"/>
                                        <animate attributeName="cy" values="75;55;75" dur="2.5s" repeatCount="indefinite"/>
                                    </circle>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">API Development & Integration</h4>
                                <p class="service-card__description">
                                    RESTful and GraphQL APIs with comprehensive documentation. Seamless third-party integrations and microservices architecture.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Database Design -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Database stack -->
                                    <g opacity="0.9">
                                        <!-- Top database -->
                                        <ellipse cx="100" cy="60" rx="50" ry="15" fill="white"/>
                                        <rect x="50" y="60" width="100" height="25" fill="white"/>
                                        <ellipse cx="100" cy="85" rx="50" ry="15" fill="rgba(255,255,255,0.9)"/>

                                        <!-- Middle database -->
                                        <ellipse cx="100" cy="100" rx="50" ry="15" fill="rgba(255,255,255,0.95)"/>
                                        <rect x="50" y="100" width="100" height="25" fill="rgba(255,255,255,0.95)"/>
                                        <ellipse cx="100" cy="125" rx="50" ry="15" fill="rgba(255,255,255,0.85)"/>

                                        <!-- Bottom database -->
                                        <ellipse cx="100" cy="140" rx="50" ry="15" fill="rgba(255,255,255,0.9)"/>
                                        <rect x="50" y="140" width="100" height="25" fill="rgba(255,255,255,0.9)"/>
                                        <ellipse cx="100" cy="165" rx="50" ry="15" fill="rgba(255,255,255,0.8)"/>
                                    </g>
                                    <!-- Data visualization bars -->
                                    <g opacity="0.7">
                                        <rect x="65" y="70" width="8" height="12" fill="#3b82f6" rx="2"/>
                                        <rect x="80" y="65" width="8" height="17" fill="#3b82f6" rx="2"/>
                                        <rect x="95" y="68" width="8" height="14" fill="#3b82f6" rx="2"/>
                                        <rect x="110" y="62" width="8" height="20" fill="#74b812" rx="2"/>
                                        <rect x="125" y="70" width="8" height="12" fill="#3b82f6" rx="2"/>
                                    </g>
                                    <!-- Speed/optimization indicator -->
                                    <path d="M165 45 L175 50 L165 55 L168 50 Z" fill="#74b812"/>
                                    <path d="M155 50 L168 50" stroke="#74b812" stroke-width="2"/>
                                    <!-- Network connections -->
                                    <circle cx="30" cy="110" r="8" fill="rgba(255,255,255,0.8)"/>
                                    <circle cx="170" cy="110" r="8" fill="rgba(255,255,255,0.8)"/>
                                    <line x1="38" y1="110" x2="50" y2="110" stroke="white" stroke-width="2" stroke-dasharray="3,3"/>
                                    <line x1="150" y1="110" x2="162" y2="110" stroke="white" stroke-width="2" stroke-dasharray="3,3"/>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Database Architecture</h4>
                                <p class="service-card__description">
                                    Optimized database design with MySQL, PostgreSQL, MongoDB. Performance tuning, indexing strategies, and data migration services.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Legacy Modernization -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Old system (left side) -->
                                    <g opacity="0.6">
                                        <rect x="30" y="70" width="50" height="60" fill="rgba(255,255,255,0.3)" stroke="white" stroke-width="2" rx="3"/>
                                        <line x1="40" y1="85" x2="70" y2="85" stroke="white" stroke-width="1"/>
                                        <line x1="40" y1="95" x2="65" y2="95" stroke="white" stroke-width="1"/>
                                        <line x1="40" y1="105" x2="70" y2="105" stroke="white" stroke-width="1"/>
                                        <text x="55" y="122" text-anchor="middle" fill="white" font-size="10" opacity="0.7">OLD</text>
                                    </g>

                                    <!-- Transformation arrow -->
                                    <g>
                                        <path d="M85 100 L115 100" stroke="#74b812" stroke-width="4"/>
                                        <path d="M115 100 L105 95 M115 100 L105 105" stroke="#74b812" stroke-width="4" stroke-linecap="round"/>
                                        <circle cx="100" cy="100" r="12" fill="#74b812"/>
                                        <path d="M95 100 L100 105 L105 95" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                                    </g>

                                    <!-- New modern system (right side) -->
                                    <g>
                                        <rect x="120" y="60" width="55" height="80" fill="white" stroke="white" stroke-width="3" rx="6"/>
                                        <rect x="127" y="68" width="41" height="8" fill="#8b5cf6" rx="2"/>
                                        <rect x="127" y="82" width="30" height="4" fill="#e0e0e0" rx="1"/>
                                        <rect x="127" y="90" width="35" height="4" fill="#e0e0e0" rx="1"/>
                                        <rect x="127" y="98" width="25" height="4" fill="#e0e0e0" rx="1"/>
                                        <circle cx="135" cy="115" r="8" fill="#74b812"/>
                                        <circle cx="153" cy="115" r="8" fill="#8b5cf6"/>
                                        <rect x="127" y="128" width="18" height="6" fill="#74b812" rx="2"/>
                                        <rect x="148" y="128" width="18" height="6" fill="#e0e0e0" rx="2"/>
                                        <text x="147" y="152" text-anchor="middle" fill="#8b5cf6" font-size="9" font-weight="bold">NEW</text>
                                    </g>

                                    <!-- Sparkle effects -->
                                    <circle cx="165" cy="55" r="3" fill="white" opacity="0.8"/>
                                    <circle cx="180" cy="70" r="2" fill="white" opacity="0.6"/>
                                    <circle cx="175" cy="140" r="2.5" fill="white" opacity="0.7"/>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Legacy System Modernization</h4>
                                <p class="service-card__description">
                                    Transform outdated systems into modern, maintainable applications. Code refactoring, technology stack upgrades, and gradual migration paths.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Maintenance & Support -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Laptop/monitor -->
                                    <rect x="50" y="60" width="100" height="70" rx="4" fill="white" stroke="white" stroke-width="3"/>
                                    <rect x="57" y="67" width="86" height="56" fill="#ec4899" opacity="0.3"/>

                                    <!-- Heartbeat/monitoring line -->
                                    <path d="M65 95 L75 95 L80 85 L85 105 L90 95 L100 95 L105 90 L110 100 L115 95 L135 95"
                                          stroke="#74b812" stroke-width="3" fill="none" stroke-linecap="round"/>

                                    <!-- Laptop base -->
                                    <path d="M45 130 L155 130 L150 140 L50 140 Z" fill="white"/>

                                    <!-- Tools overlay -->
                                    <g transform="translate(145, 75)">
                                        <!-- Wrench -->
                                        <path d="M0 0 L3 8 L-3 8 Z" fill="white" opacity="0.9"/>
                                        <rect x="-1.5" y="7" width="3" height="12" fill="white" opacity="0.9" rx="1"/>
                                        <circle cx="0" cy="2" r="3" fill="none" stroke="white" stroke-width="1.5" opacity="0.9"/>
                                    </g>

                                    <!-- Support shield -->
                                    <g transform="translate(160, 105)">
                                        <path d="M0 0 L-8 2 L-8 10 Q-8 16 0 18 Q8 16 8 10 L8 2 Z" fill="white" opacity="0.95"/>
                                        <path d="M-3 8 L-1 11 L5 5" stroke="#ec4899" stroke-width="2" fill="none" stroke-linecap="round"/>
                                    </g>

                                    <!-- Status indicators -->
                                    <circle cx="30" cy="95" r="6" fill="#74b812">
                                        <animate attributeName="opacity" values="1;0.3;1" dur="2s" repeatCount="indefinite"/>
                                    </circle>
                                    <circle cx="30" cy="110" r="6" fill="white" opacity="0.7"/>
                                    <circle cx="30" cy="125" r="6" fill="white" opacity="0.7"/>

                                    <!-- Notification badges -->
                                    <circle cx="140" cy="55" r="8" fill="#74b812"/>
                                    <text x="140" y="59" text-anchor="middle" fill="white" font-size="10" font-weight="bold">✓</text>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Maintenance & Support</h4>
                                <p class="service-card__description">
                                    Ongoing software maintenance, bug fixes, security patches, and feature enhancements to keep your systems running smoothly.
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
                                Software development, <span style="font-style: italic; color: #74b812;">minus the complexity</span>
                            </h2>
                            <p class="text-white mb-5" style="opacity: 0.8; font-size: 1.125rem; line-height: 1.7;">
                                Agile methodology with continuous delivery. Transparent communication, regular demos, and iterative development that keeps your project on track.
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
                                <h4 class="process-step__title">Requirements Analysis</h4>
                                <p class="process-step__description">
                                    We analyze your business processes, identify pain points, and document detailed functional requirements.
                                </p>
                            </div>

                            <!-- Step 2 -->
                            <div class="process-step" data-step="2">
                                <div class="process-step__number">2</div>
                                <h4 class="process-step__title">Architecture Design</h4>
                                <p class="process-step__description">
                                    Technical architecture, database schema, API design, and technology stack selection tailored to your needs.
                                </p>
                            </div>

                            <!-- Step 3 -->
                            <div class="process-step" data-step="3">
                                <div class="process-step__number">3</div>
                                <h4 class="process-step__title">Agile Development</h4>
                                <p class="process-step__description">
                                    Sprint-based development with regular demos, continuous integration, and automated testing.
                                </p>
                            </div>

                            <!-- Step 4 -->
                            <div class="process-step" data-step="4">
                                <div class="process-step__number">4</div>
                                <h4 class="process-step__title">Quality Assurance</h4>
                                <p class="process-step__description">
                                    Comprehensive testing including unit tests, integration tests, and UAT to ensure reliability and performance.
                                </p>
                            </div>

                            <!-- Step 5 -->
                            <div class="process-step" data-step="5">
                                <div class="process-step__number">5</div>
                                <h4 class="process-step__title">Deployment</h4>
                                <p class="process-step__description">
                                    Seamless deployment to production with CI/CD pipelines, monitoring setup, and documentation.
                                </p>
                            </div>

                            <!-- Step 6 -->
                            <div class="process-step" data-step="6">
                                <div class="process-step__number">6</div>
                                <h4 class="process-step__title">Ongoing Support</h4>
                                <p class="process-step__description">
                                    Post-launch maintenance, security updates, performance monitoring, and feature enhancements.
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
                            This is just one of many creative services, what you do with them is up to you. Let's build something remarkable together.
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

                    <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-black fw-medium tw-text-sm tw-mb-4"
                          style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                  Got Questions?
                                </span>
                    <h2 class="section-title mb-3">
                        Frequently Asked <span style="font-style: italic; color: #74b812;">Questions</span>
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>How long does custom software development take?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Timeline depends on complexity and scope. Small business automation tools take 2-4 months. Medium-sized enterprise applications take 4-8 months. Large-scale systems with complex integrations can take 8-18 months. We use agile methodology with 2-week sprints, delivering working features incrementally so you see progress throughout development.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>What technologies do you use for custom software?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                We work with modern, proven technology stacks including Laravel/PHP, Node.js, Python/Django, React, Vue.js, and Angular for web applications. For databases we use MySQL, PostgreSQL, MongoDB, and Redis. All infrastructure is cloud-hosted on AWS, Google Cloud, or Azure with containerization using Docker and Kubernetes when needed.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Can you modernize our legacy software?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Absolutely! We specialize in legacy system modernization. We analyze your existing system, identify pain points, and create a migration strategy that minimizes disruption. We can refactor code, migrate databases, update technology stacks, and integrate with modern APIs while maintaining data integrity and business continuity.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>How much does custom software development cost?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Costs vary significantly based on complexity. Small automation tools start at $20,000-$50,000. Medium business applications range from $50,000-$150,000. Large enterprise systems can be $150,000-$500,000+. We provide fixed-price quotes for smaller projects and time-and-materials for larger initiatives. We always start with a detailed requirements analysis to give accurate estimates.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Will I own the source code?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Yes! You receive full ownership of all source code, documentation, and intellectual property we create for your project. We provide complete code repositories, technical documentation, architecture diagrams, and deployment guides. You're never locked in and can take the code to any other development team if needed.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Do you provide ongoing support after launch?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Yes! We offer comprehensive maintenance and support packages including bug fixes, security updates, performance monitoring, feature enhancements, and technical support. We provide 3 months of warranty support included, then offer flexible monthly retainer packages. Many clients keep us on retainer for ongoing development and improvements.
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
