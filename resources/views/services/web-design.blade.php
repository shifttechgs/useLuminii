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
                                    Web Designing
                                </span>
                            <h1 class="service-hero__title">
                                High-performing web solutions <span style="font-style: italic; color: #74b812;">built to grow</span> with your brand
                            </h1>
                            <p class="service-hero__subtitle">
                                Fast, scalable web experiences optimized for conversion. From UX strategy to development, we deliver websites that drive measurable business results.
                            </p>

                            <!-- Trust Badges -->
                            <div class="d-flex flex-wrap tw-gap-3 mb-4">
                                <span class="trust-badge">
                                    <i class="ph-bold ph-check-circle"></i>
                                    98% Client Satisfaction
                                </span>
                                <span class="trust-badge">
                                    <i class="ph-bold ph-clock"></i>
                                    2-4 Week Delivery
                                </span>
                                <span class="trust-badge">
                                    <i class="ph-bold ph-shield-check"></i>
                                   Free Website Audit
                                </span>
                            </div>


                            <div class="d-flex align-items-center tw-gap-4 flex-wrap">
                                <a href="{{ url('/contact') }}" class="btn btn-main-two hover-style-two button--stroke d-inline-flex align-items-center justify-content-center tw-gap-3 group active--translate-y-2 tw-px-9 rounded-pill tw-py-4 fw-semibold">
                                    <span class="button__flair"></span>
                                    <i class="ph ph-phone-call tw-text-xl tw-text-white group-hover-text-white"></i>
                                    <span class="button__label">Book Your Free Consultation</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800">
                        <div class="service-hero__image">
                            <img src="/assets/images/thumbs/services/1.png" alt="Web Design Example" style="width: 100%; height: auto;">
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

        <!-- ========================== Why Web Section ============================= -->
        <section class="value-section">
            <div class="container">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">

                        <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-black fw-medium tw-text-sm tw-mb-4"
                              style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                                  Why Web Design Matters
                                </span>
                        <h2 class="section-title">
                            Your website isn't a billboard, it's a <span style="font-style: italic; color: #74b812;">growth engine</span>
                        </h2>
                        <p class="section-subtitle mb-4">
                            In a digital-first world, your website is your most important sales and marketing asset. It's where prospects become customers, where trust is built, and where your brand comes to life 24/7.
                        </p>
                        <div class="d-flex align-items-start tw-gap-3 mb-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0">First impressions happen in <strong>0.05 seconds</strong> - your design matters</p>
                        </div>
                        <div class="d-flex align-items-start tw-gap-3 mb-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0"><strong>75% of users</strong> judge your credibility based on your website</p>
                        </div>
                        <div class="d-flex align-items-start tw-gap-3">
                            <i class="ph-bold ph-check-circle tw-text-2xl" style="color: #74b812;"></i>
                            <p class="section-subtitle mb-0">Too many teams are stuck with outdated, unresponsive websites that leak conversions</p>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800">
                        <div class="value-section__image">
                            <img src="/assets/images/thumbs/services/5.png" alt="Web Design Strategy" class="w-100 h-100 object-fit-cover">
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
                        A <span style="font-style: italic; color: #74b812;">creative web design partner</span> you can trust
                    </h2>
                </div>

                <div class="row g-5 justify-content-center text-center">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600">
                        <div class="metric-item">
                            <div class="metric-item__number">40%+</div>
                            <p class="metric-item__description">Average conversion increase after UX audit & optimization</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                        <div class="metric-item">
                            <div class="metric-item__number">60%</div>
                            <p class="metric-item__description">Cost savings vs US/EU agencies with modular design systems</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                        <div class="metric-item">
                            <div class="metric-item__number">98%</div>
                            <p class="metric-item__description">Of web projects delivered on or before deadline</p>
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
                                 ShiftTech Web Solutions
                                </span>
                        <h2 class="section-title">
                            Launch faster, scale smarter, <span style="font-style: italic; color: #74b812;">convert more</span>
                        </h2>
                        <p class="section-subtitle mb-4">
                            We bring together multidisciplinary teams including strategy, UX, design, development, copy, and optimization—all working in sync to deliver web experiences that perform.
                        </p>
                        <p class="section-subtitle mb-5">
                            From discovery to deployment and beyond, we handle the entire web design lifecycle so you can focus on growing your business.
                        </p>
                        <a href="{{ url('/contact') }}" class="btn btn-lg fw-bold px-5 py-3 hover--translate-y-1" style="background: #74b812; color: white; border-radius: 50px; border: none;">
                            Book Your Free Discovery Call <i class="ph-bold ph-arrow-right ms-2"></i>
                        </a>
                    </div>

                    <div class="col-lg-6 order-lg-1" data-aos="fade-right" data-aos-duration="800">
                        <div class="integrated-section__image">
                            <img src="/assets/images/thumbs/services/2.png" alt="Integrated Web Solutions" class="w-100 h-100 object-fit-cover">
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
                        Creative web design, ready to <span style="font-style: italic; color: #74b812;">scale and convert</span>
                    </h2>
                </div>

                <div class="row g-4">
                    <!-- Website Design -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #74b812 0%, #5a9a0a 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Browser window with responsive design -->
                                    <rect x="40" y="50" width="120" height="100" rx="6" fill="white" stroke="rgba(255,255,255,0.5)" stroke-width="2"/>
                                    <!-- Browser toolbar -->
                                    <rect x="40" y="50" width="120" height="12" rx="6" fill="rgba(255,255,255,0.9)"/>
                                    <circle cx="48" cy="56" r="2" fill="#74b812"/>
                                    <circle cx="54" cy="56" r="2" fill="#5a9a0a"/>
                                    <circle cx="60" cy="56" r="2" fill="rgba(116,184,18,0.5)"/>

                                    <!-- Webpage content grid -->
                                    <g opacity="0.9">
                                        <!-- Hero section -->
                                        <rect x="45" y="67" width="110" height="20" rx="2" fill="rgba(116,184,18,0.3)"/>
                                        <rect x="50" y="72" width="40" height="4" rx="1" fill="white"/>
                                        <rect x="50" y="78" width="60" height="3" rx="1" fill="rgba(255,255,255,0.7)"/>

                                        <!-- Content cards -->
                                        <rect x="45" y="92" width="33" height="25" rx="2" fill="rgba(255,255,255,0.4)"/>
                                        <rect x="82" y="92" width="33" height="25" rx="2" fill="rgba(255,255,255,0.4)"/>
                                        <rect x="119" y="92" width="33" height="25" rx="2" fill="rgba(255,255,255,0.4)"/>

                                        <!-- Footer -->
                                        <rect x="45" y="122" width="110" height="8" rx="1" fill="rgba(255,255,255,0.3)"/>
                                    </g>

                                    <!-- Responsive device icons -->
                                    <!-- Desktop -->
                                    <g transform="translate(170, 70)">
                                        <rect x="-10" y="-6" width="20" height="12" rx="1" fill="white" opacity="0.8"/>
                                        <rect x="-6" y="7" width="12" height="2" rx="1" fill="white" opacity="0.8"/>
                                    </g>

                                    <!-- Tablet -->
                                    <g transform="translate(170, 100)">
                                        <rect x="-6" y="-8" width="12" height="16" rx="1" fill="white" opacity="0.8"/>
                                        <circle cx="0" cy="6" r="1" fill="#74b812"/>
                                    </g>

                                    <!-- Mobile -->
                                    <g transform="translate(170, 130)">
                                        <rect x="-4" y="-7" width="8" height="14" rx="1" fill="white" opacity="0.8"/>
                                        <circle cx="0" cy="5" r="0.8" fill="#74b812"/>
                                    </g>

                                    <!-- Design tool cursor -->
                                    <g transform="translate(100, 100)">
                                        <path d="M0 0 L0 12 L4 9 L6 13 L8 12 L6 8 L10 8 Z" fill="white" opacity="0.9"/>
                                    </g>

                                    <!-- Color palette -->
                                    <g transform="translate(25, 100)">
                                        <circle cx="0" cy="0" r="5" fill="rgba(255,255,255,0.3)"/>
                                        <circle cx="0" cy="-2" r="2" fill="#74b812"/>
                                        <circle cx="-2" cy="1" r="2" fill="white"/>
                                        <circle cx="2" cy="1" r="2" fill="#5a9a0a"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Website Design</h4>
                                <p class="service-card__description">
                                    Website UX research, wireframes, responsive design, and high-fidelity UI, tailored to your business goals and target audience.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Web Development -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #0a3622 0%, #002b22 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Code editor window -->
                                    <rect x="45" y="45" width="110" height="110" rx="6" fill="rgba(255,255,255,0.95)"/>

                                    <!-- Editor header -->
                                    <rect x="45" y="45" width="110" height="15" rx="6" fill="#0a3622"/>
                                    <circle cx="53" cy="52.5" r="2.5" fill="#ff5f56"/>
                                    <circle cx="61" cy="52.5" r="2.5" fill="#ffbd2e"/>
                                    <circle cx="69" cy="52.5" r="2.5" fill="#27c93f"/>

                                    <!-- Code lines with syntax highlighting -->
                                    <g opacity="0.9" font-family="monospace" font-size="6">
                                        <!-- HTML tags -->
                                        <text x="50" y="72" fill="#0a3622">&lt;div</text>
                                        <text x="68" y="72" fill="#74b812">class=</text>
                                        <text x="84" y="72" fill="#d97706">"container"</text>
                                        <text x="108" y="72" fill="#0a3622">&gt;</text>

                                        <!-- Nested element -->
                                        <text x="55" y="82" fill="#0a3622">&lt;h1&gt;</text>
                                        <text x="70" y="82" fill="#002b22">Welcome</text>
                                        <text x="92" y="82" fill="#0a3622">&lt;/h1&gt;</text>

                                        <!-- Function -->
                                        <text x="55" y="92" fill="#8b5cf6">function</text>
                                        <text x="80" y="92" fill="#002b22">init()</text>
                                        <text x="95" y="92" fill="#0a3622">{</text>

                                        <!-- Console log -->
                                        <text x="60" y="102" fill="#002b22">console.</text>
                                        <text x="83" y="102" fill="#74b812">log</text>
                                        <text x="93" y="102" fill="#0a3622">(</text>
                                        <text x="95" y="102" fill="#d97706">'Ready'</text>
                                        <text x="110" y="102" fill="#0a3622">)</text>

                                        <!-- Closing braces -->
                                        <text x="55" y="112" fill="#0a3622">}</text>
                                        <text x="50" y="122" fill="#0a3622">&lt;/div&gt;</text>
                                    </g>

                                    <!-- Code brackets icon -->
                                    <g transform="translate(165, 100)">
                                        <circle cx="0" cy="0" r="15" fill="rgba(116,184,18,0.2)"/>
                                        <text x="0" y="6" text-anchor="middle" fill="white" font-size="18" font-weight="bold" font-family="monospace">&lt;/&gt;</text>
                                    </g>

                                    <!-- Git branch indicator -->
                                    <g transform="translate(30, 80)">
                                        <circle cx="0" cy="0" r="3" fill="white"/>
                                        <line x1="0" y1="0" x2="0" y2="15" stroke="white" stroke-width="1.5"/>
                                        <circle cx="0" cy="15" r="3" fill="white"/>
                                        <line x1="0" y1="7.5" x2="6" y2="7.5" stroke="white" stroke-width="1.5"/>
                                        <circle cx="6" cy="7.5" r="2.5" fill="#74b812"/>
                                    </g>

                                    <!-- Speed indicator -->
                                    <g transform="translate(165, 60)">
                                        <path d="M0 0 L5 3 L0 6" fill="#74b812"/>
                                        <path d="M-8 3 L0 3" stroke="#74b812" stroke-width="2"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Web Development</h4>
                                <p class="service-card__description">
                                    Custom web development with modern frameworks, CMS integration, and scalable architecture built for performance.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Landing Pages -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Landing page with conversion funnel -->
                                    <rect x="50" y="40" width="100" height="120" rx="6" fill="white" opacity="0.95"/>

                                    <!-- Hero section -->
                                    <rect x="55" y="48" width="90" height="25" rx="3" fill="rgba(245,158,11,0.3)"/>
                                    <rect x="62" y="53" width="50" height="5" rx="2" fill="white"/>
                                    <rect x="62" y="61" width="70" height="3" rx="1" fill="rgba(255,255,255,0.7)"/>

                                    <!-- CTA Button (prominent) -->
                                    <rect x="70" y="68" width="60" height="10" rx="5" fill="#74b812"/>
                                    <text x="100" y="75" text-anchor="middle" fill="white" font-size="6" font-weight="bold">GET STARTED</text>

                                    <!-- Feature sections -->
                                    <g opacity="0.8">
                                        <rect x="58" y="83" width="20" height="15" rx="2" fill="rgba(245,158,11,0.2)"/>
                                        <rect x="82" y="83" width="20" height="15" rx="2" fill="rgba(245,158,11,0.2)"/>
                                        <rect x="106" y="83" width="20" height="15" rx="2" fill="rgba(245,158,11,0.2)"/>
                                        <rect x="130" y="83" width="8" height="15" rx="2" fill="rgba(245,158,11,0.2)"/>
                                    </g>

                                    <!-- Social proof section -->
                                    <rect x="58" y="103" width="84" height="12" rx="2" fill="rgba(245,158,11,0.15)"/>
                                    <text x="100" y="110.5" text-anchor="middle" fill="#f59e0b" font-size="5">★ ★ ★ ★ ★</text>

                                    <!-- Final CTA -->
                                    <rect x="65" y="120" width="70" height="10" rx="5" fill="#f59e0b"/>
                                    <text x="100" y="127" text-anchor="middle" fill="white" font-size="6" font-weight="bold">START FREE TRIAL</text>

                                    <!-- Form fields -->
                                    <rect x="65" y="135" width="70" height="6" rx="2" fill="rgba(245,158,11,0.2)"/>
                                    <rect x="65" y="144" width="70" height="6" rx="2" fill="rgba(245,158,11,0.2)"/>

                                    <!-- Conversion funnel on side -->
                                    <g transform="translate(165, 80)">
                                        <!-- Wide top -->
                                        <path d="M-10 0 L10 0 L8 15 L-8 15 Z" fill="white" opacity="0.9"/>
                                        <path d="M-8 15 L8 15 L6 30 L-6 30 Z" fill="white" opacity="0.9"/>
                                        <path d="M-6 30 L6 30 L4 45 L-4 45 Z" fill="white" opacity="0.9"/>

                                        <!-- Checkmark at bottom -->
                                        <circle cx="0" cy="52" r="6" fill="#74b812"/>
                                        <path d="M-2 52 L0 54 L3 50" stroke="white" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                                    </g>

                                    <!-- Analytics/conversion icon -->
                                    <g transform="translate(30, 100)">
                                        <circle cx="0" cy="0" r="12" fill="rgba(255,255,255,0.3)"/>
                                        <!-- Upward trending arrow -->
                                        <path d="M-5 3 L-2 -3 L2 0 L5 -5" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                                        <path d="M5 -5 L5 -1 M5 -5 L1 -5" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    </g>

                                    <!-- User icon -->
                                    <g transform="translate(30, 60)">
                                        <circle cx="0" cy="0" r="10" fill="rgba(255,255,255,0.3)"/>
                                        <circle cx="0" cy="-1" r="3" fill="white"/>
                                        <path d="M-5 5 Q-5 2 0 2 Q5 2 5 5" fill="white"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Landing Pages</h4>
                                <p class="service-card__description">
                                    Funnel-stage pages that launch fast—fully optimized, mobile first, and on brand. Built to convert visitors into customers.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Design Systems -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Component library / Atomic design -->

                                    <!-- Main frame representing design system -->
                                    <rect x="50" y="50" width="100" height="100" rx="6" fill="white" opacity="0.95"/>

                                    <!-- Grid layout showing components -->
                                    <g opacity="0.9">
                                        <!-- Atoms (smallest elements) -->
                                        <text x="58" y="62" fill="#3b82f6" font-size="6" font-weight="bold">ATOMS</text>
                                        <circle cx="65" cy="72" r="4" fill="#3b82f6"/>
                                        <rect x="75" y="68" width="20" height="8" rx="4" fill="#3b82f6"/>
                                        <rect x="100" y="70" width="15" height="4" rx="1" fill="#3b82f6"/>

                                        <!-- Molecules -->
                                        <text x="58" y="88" fill="#2563eb" font-size="6" font-weight="bold">MOLECULES</text>
                                        <rect x="58" y="93" width="35" height="15" rx="2" fill="rgba(59,130,246,0.3)" stroke="#3b82f6" stroke-width="1"/>
                                        <circle cx="67" cy="100" r="3" fill="#3b82f6"/>
                                        <rect x="73" y="98" width="15" height="4" rx="1" fill="#3b82f6"/>

                                        <rect x="98" y="93" width="35" height="15" rx="2" fill="rgba(59,130,246,0.3)" stroke="#3b82f6" stroke-width="1"/>
                                        <rect x="102" y="97" width="8" height="8" rx="1" fill="#3b82f6"/>
                                        <rect x="113" y="99" width="15" height="4" rx="1" fill="#3b82f6"/>

                                        <!-- Organisms -->
                                        <text x="58" y="118" fill="#2563eb" font-size="6" font-weight="bold">ORGANISMS</text>
                                        <rect x="58" y="123" width="75" height="20" rx="2" fill="rgba(59,130,246,0.2)" stroke="#3b82f6" stroke-width="1.5"/>
                                        <rect x="62" y="127" width="67" height="4" rx="1" fill="#3b82f6"/>
                                        <rect x="62" y="133" width="20" height="6" rx="1" fill="rgba(59,130,246,0.5)"/>
                                        <rect x="85" y="133" width="20" height="6" rx="1" fill="rgba(59,130,246,0.5)"/>
                                        <rect x="108" y="133" width="20" height="6" rx="1" fill="rgba(59,130,246,0.5)"/>
                                    </g>

                                    <!-- Component connection lines -->
                                    <line x1="65" y1="76" x2="75" y2="98" stroke="#74b812" stroke-width="1" stroke-dasharray="2,2" opacity="0.5"/>
                                    <line x1="85" y1="76" x2="108" y2="100" stroke="#74b812" stroke-width="1" stroke-dasharray="2,2" opacity="0.5"/>
                                    <line x1="75" y1="108" x2="95" y2="127" stroke="#74b812" stroke-width="1" stroke-dasharray="2,2" opacity="0.5"/>

                                    <!-- Reusable components badge -->
                                    <g transform="translate(165, 85)">
                                        <circle cx="0" cy="0" r="15" fill="rgba(255,255,255,0.3)"/>
                                        <path d="M-6 -3 L0 -8 L6 -3 L6 5 L0 10 L-6 5 Z" fill="white" stroke="white" stroke-width="1.5"/>
                                        <path d="M-3 0 L0 -2 L3 0 L3 4 L0 6 L-3 4 Z" fill="#74b812"/>
                                    </g>

                                    <!-- Consistency icon -->
                                    <g transform="translate(30, 100)">
                                        <circle cx="0" cy="0" r="12" fill="rgba(255,255,255,0.3)"/>
                                        <rect x="-6" y="-6" width="5" height="5" rx="1" fill="white"/>
                                        <rect x="1" y="-6" width="5" height="5" rx="1" fill="white"/>
                                        <rect x="-6" y="1" width="5" height="5" rx="1" fill="white"/>
                                        <rect x="1" y="1" width="5" height="5" rx="1" fill="white"/>
                                    </g>

                                    <!-- Speed/efficiency indicator -->
                                    <g transform="translate(165, 130)">
                                        <circle cx="0" cy="0" r="8" fill="#74b812"/>
                                        <path d="M-2 0 L2 0 M0 -2 L0 2" stroke="white" stroke-width="2"/>
                                        <path d="M0 -5 L3 0" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Design Systems & UI Kits</h4>
                                <p class="service-card__description">
                                    Reusable component libraries built following Atomic design methodology—ensuring consistency and faster iteration.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- UX/UI Audits -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- UX Audit with magnifying glass and analytics -->

                                    <!-- Website being analyzed -->
                                    <rect x="55" y="55" width="90" height="90" rx="4" fill="white" opacity="0.95"/>

                                    <!-- Page elements with issues highlighted -->
                                    <g opacity="0.8">
                                        <rect x="60" y="62" width="80" height="12" rx="2" fill="rgba(139,92,246,0.2)"/>
                                        <rect x="60" y="78" width="35" height="25" rx="2" fill="rgba(139,92,246,0.15)"/>
                                        <rect x="100" y="78" width="40" height="10" rx="1" fill="rgba(139,92,246,0.15)"/>
                                        <rect x="100" y="92" width="40" height="11" rx="1" fill="rgba(139,92,246,0.15)"/>

                                        <!-- Issue markers -->
                                        <circle cx="90" cy="70" r="4" fill="#ec4899" opacity="0.8"/>
                                        <text x="90" y="72" text-anchor="middle" fill="white" font-size="6" font-weight="bold">!</text>

                                        <circle cx="138" cy="85" r="4" fill="#ec4899" opacity="0.8"/>
                                        <text x="138" y="87" text-anchor="middle" fill="white" font-size="6" font-weight="bold">!</text>

                                        <circle cx="118" cy="98" r="4" fill="#f59e0b" opacity="0.8"/>
                                        <text x="118" y="100" text-anchor="middle" fill="white" font-size="6" font-weight="bold">?</text>
                                    </g>

                                    <!-- Bottom metrics/fixes -->
                                    <rect x="60" y="108" width="80" height="32" rx="2" fill="rgba(139,92,246,0.1)"/>

                                    <!-- Before/After indicators -->
                                    <g>
                                        <text x="65" y="117" fill="#8b5cf6" font-size="5" font-weight="bold">ISSUES FOUND</text>
                                        <rect x="65" y="120" width="32" height="3" fill="#ec4899" rx="1"/>
                                        <text x="100" y="123" fill="#ec4899" font-size="5" font-weight="bold">12</text>

                                        <text x="65" y="132" fill="#74b812" font-size="5" font-weight="bold">IMPROVEMENTS</text>
                                        <rect x="65" y="135" width="32" height="3" fill="#74b812" rx="1"/>
                                        <text x="100" y="138" fill="#74b812" font-size="5" font-weight="bold">+45%</text>
                                    </g>

                                    <!-- Magnifying glass -->
                                    <g transform="translate(160, 75)">
                                        <circle cx="0" cy="0" r="15" fill="rgba(255,255,255,0.4)"/>
                                        <circle cx="-2" cy="-2" r="8" fill="none" stroke="white" stroke-width="2.5"/>
                                        <line x1="4" y1="4" x2="10" y2="10" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                                        <!-- Checkmark inside -->
                                        <path d="M-5 -2 L-3 0 L0 -4" stroke="#74b812" stroke-width="2" fill="none" stroke-linecap="round"/>
                                    </g>

                                    <!-- Analytics chart -->
                                    <g transform="translate(30, 90)">
                                        <circle cx="0" cy="0" r="12" fill="rgba(255,255,255,0.3)"/>
                                        <!-- Bar chart -->
                                        <rect x="-6" y="2" width="3" height="6" fill="white" opacity="0.6"/>
                                        <rect x="-2" y="-1" width="3" height="9" fill="white" opacity="0.8"/>
                                        <rect x="2" y="-4" width="3" height="12" fill="#74b812"/>
                                    </g>

                                    <!-- User testing icon -->
                                    <g transform="translate(30, 120)">
                                        <circle cx="0" cy="0" r="10" fill="rgba(255,255,255,0.3)"/>
                                        <circle cx="0" cy="-2" r="3" fill="white"/>
                                        <path d="M-5 4 Q-5 1 0 1 Q5 1 5 4" fill="white"/>
                                        <circle cx="0" cy="8" r="1.5" fill="#74b812"/>
                                    </g>

                                    <!-- Heatmap indicator -->
                                    <g transform="translate(160, 125)">
                                        <rect x="-8" y="-8" width="16" height="16" rx="2" fill="rgba(255,255,255,0.3)"/>
                                        <circle cx="-3" cy="-3" r="2" fill="#ec4899" opacity="0.8"/>
                                        <circle cx="3" cy="0" r="3" fill="#f59e0b" opacity="0.7"/>
                                        <circle cx="0" cy="4" r="2.5" fill="#74b812" opacity="0.6"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">UX/UI Audits</h4>
                                <p class="service-card__description">
                                    Deep research into conversion leaks and usability gaps, plus expert recommendations to boost performance and user satisfaction.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Copy & Motion Support -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                        <div class="service-card">
                            <div class="service-card__image" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Copy writing and animation -->

                                    <!-- Document/page -->
                                    <rect x="60" y="45" width="80" height="110" rx="4" fill="white" opacity="0.95"/>

                                    <!-- Headline with emphasis -->
                                    <g opacity="0.9">
                                        <rect x="68" y="55" width="50" height="8" rx="2" fill="#ec4899"/>
                                        <text x="93" y="61" text-anchor="middle" fill="white" font-size="5" font-weight="bold">HEADLINE</text>

                                        <!-- Body copy lines -->
                                        <rect x="68" y="68" width="64" height="2" rx="1" fill="rgba(236,72,153,0.3)"/>
                                        <rect x="68" y="73" width="60" height="2" rx="1" fill="rgba(236,72,153,0.3)"/>
                                        <rect x="68" y="78" width="55" height="2" rx="1" fill="rgba(236,72,153,0.3)"/>

                                        <!-- Quote/testimonial -->
                                        <rect x="68" y="85" width="64" height="18" rx="2" fill="rgba(236,72,153,0.15)"/>
                                        <text x="72" y="92" fill="#ec4899" font-size="12" opacity="0.3">"</text>
                                        <rect x="72" y="93" width="56" height="1.5" rx="0.5" fill="rgba(236,72,153,0.4)"/>
                                        <rect x="72" y="97" width="50" height="1.5" rx="0.5" fill="rgba(236,72,153,0.4)"/>

                                        <!-- CTA with emphasis -->
                                        <rect x="75" y="110" width="50" height="12" rx="6" fill="#74b812"/>
                                        <text x="100" y="118" text-anchor="middle" fill="white" font-size="6" font-weight="bold">TAKE ACTION</text>

                                        <!-- Microcopy -->
                                        <rect x="75" y="126" width="42" height="1.5" rx="0.5" fill="rgba(236,72,153,0.2)"/>
                                        <rect x="75" y="130" width="38" height="1.5" rx="0.5" fill="rgba(236,72,153,0.2)"/>
                                    </g>

                                    <!-- Animated elements indicator -->
                                    <g transform="translate(155, 70)">
                                        <circle cx="0" cy="0" r="12" fill="rgba(255,255,255,0.3)"/>
                                        <!-- Play button -->
                                        <path d="M-3 -5 L-3 5 L5 0 Z" fill="white">
                                            <animateTransform
                                                attributeName="transform"
                                                type="scale"
                                                values="1;1.1;1"
                                                dur="2s"
                                                repeatCount="indefinite"/>
                                        </path>
                                    </g>

                                    <!-- Motion path -->
                                    <g>
                                        <path d="M145 90 Q155 100 145 110" stroke="white" stroke-width="2" fill="none" stroke-dasharray="3,3" opacity="0.6">
                                            <animate attributeName="stroke-dashoffset" from="0" to="12" dur="1.5s" repeatCount="indefinite"/>
                                        </path>
                                        <circle cx="145" cy="110" r="3" fill="#74b812">
                                            <animateTransform
                                                attributeName="transform"
                                                type="translate"
                                                values="0,0; 10,-20; 0,0"
                                                dur="3s"
                                                repeatCount="indefinite"/>
                                        </circle>
                                    </g>

                                    <!-- Pen/writing icon -->
                                    <g transform="translate(45, 80)">
                                        <circle cx="0" cy="0" r="10" fill="rgba(255,255,255,0.3)"/>
                                        <path d="M-3 -4 L-1 -2 L-4 1 L-5 0 Z" fill="white"/>
                                        <line x1="-1" y1="-2" x2="3" y2="-6" stroke="white" stroke-width="1.5"/>
                                        <line x1="3" y1="-6" x2="4" y2="-5" stroke="white" stroke-width="1"/>
                                        <line x1="-5" y1="3" x2="-3" y2="5" stroke="#ec4899" stroke-width="1.5" stroke-linecap="round"/>
                                    </g>

                                    <!-- Typography A icon -->
                                    <g transform="translate(45, 110)">
                                        <circle cx="0" cy="0" r="10" fill="rgba(255,255,255,0.3)"/>
                                        <text x="0" y="4" text-anchor="middle" fill="white" font-size="12" font-weight="bold" font-family="serif">A</text>
                                    </g>

                                    <!-- Sparkle/emphasis marks -->
                                    <g opacity="0.7">
                                        <path d="M120 58 L121 60 L123 61 L121 62 L120 64 L119 62 L117 61 L119 60 Z" fill="white"/>
                                        <path d="M128 68 L129 70 L131 71 L129 72 L128 74 L127 72 L125 71 L127 70 Z" fill="white"/>
                                        <path d="M72 115 L73 117 L75 118 L73 119 L72 121 L71 119 L69 118 L71 117 Z" fill="white"/>
                                    </g>

                                    <!-- Animated highlight -->
                                    <rect x="68" y="55" width="50" height="8" rx="2" fill="none" stroke="#74b812" stroke-width="1" opacity="0.5">
                                        <animate attributeName="opacity" values="0.3;0.7;0.3" dur="2s" repeatCount="indefinite"/>
                                    </rect>
                                </svg>
                            </div>
                            <div class="service-card__content">
                                <h4 class="service-card__title">Copy & Motion Support</h4>
                                <p class="service-card__description">
                                    Full-stack creative including headlines, content hierarchy, microcopy, and animation to bring your website to life.
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
                                Website workflows, <span style="font-style: italic; color: #74b812;">minus the friction</span>
                            </h2>
                            <p class="text-white mb-5" style="opacity: 0.8; font-size: 1.125rem; line-height: 1.7;">
                                No handoffs, holdups, or creative guesswork. Just a proven system for scalable, brand-aligned web design.
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
                                <h4 class="process-step__title">Discovery and onboarding</h4>
                                <p class="process-step__description">
                                    Together, we align on your brand, tech stack, audience, and site goals.
                                </p>
                            </div>

                            <!-- Step 2 -->
                            <div class="process-step" data-step="2">
                                <div class="process-step__number">2</div>
                                <h4 class="process-step__title">Team assignment</h4>
                                <p class="process-step__description">
                                    Get your own plug-in creative team: strategists, designers, developers, writers, and animators.
                                </p>
                            </div>

                            <!-- Step 3 -->
                            <div class="process-step" data-step="3">
                                <div class="process-step__number">3</div>
                                <h4 class="process-step__title">UX and UI design</h4>
                                <p class="process-step__description">
                                    Structured process from wireframes to polished UI, always built for outcomes.
                                </p>
                            </div>

                            <!-- Step 4 -->
                            <div class="process-step" data-step="4">
                                <div class="process-step__number">4</div>
                                <h4 class="process-step__title">Development</h4>
                                <p class="process-step__description">
                                    Built in Webflow with CMS, SEO, and speed in mind—modular or fully custom.
                                </p>
                            </div>

                            <!-- Step 5 -->
                            <div class="process-step" data-step="5">
                                <div class="process-step__number">5</div>
                                <h4 class="process-step__title">QA and launch</h4>
                                <p class="process-step__description">
                                    We test and fine-tune across breakpoints, devices, and integrations.
                                </p>
                            </div>

                            <!-- Step 6 -->
                            <div class="process-step" data-step="6">
                                <div class="process-step__number">6</div>
                                <h4 class="process-step__title">Continuous optimization</h4>
                                <p class="process-step__description">
                                    Post-launch support, performance tracking, and ongoing improvements as your needs grow.
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
                                <span>How long does it take to design and build a website?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Most websites take 2-4 weeks from start to finish. Landing pages can be ready in 1-2 weeks. Complex web applications with custom features may take 6-8 weeks. We'll give you an exact timeline during our discovery call.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>What's included in your web design service?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Everything: UX research, wireframes, UI design, development, mobile responsiveness, SEO optimization, speed optimization, security setup, analytics integration, and 3 months of free maintenance. You get a complete, ready-to-launch website.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Do you redesign existing websites?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Absolutely! We specialize in modernizing outdated websites. We'll audit your current site, preserve what works, improve what doesn't, and migrate everything with zero downtime. Your SEO rankings stay intact.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Will my website be mobile-friendly?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Yes, 100%. We design mobile-first, meaning we start with mobile devices and scale up. Your site will look perfect on phones, tablets, and desktops. We test on 20+ different devices before launch.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Can I update the website myself after it's built?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                Yes! We build websites with easy-to-use content management systems (CMS). We'll train you on how to update text, images, and pages. No coding required. We also provide video tutorials and documentation.
                            </div>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>What if I need changes after the website is live?</span>
                                <i class="ph-bold ph-caret-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                You get 3 months of free maintenance included. After that, we offer affordable monthly maintenance packages starting from $99/month. We're here to support you long-term.
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
