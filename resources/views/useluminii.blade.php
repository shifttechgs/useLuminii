@extends("layouts.useluminii_master")

{{-- ========== Page-Specific SEO Meta Tags ========== --}}
@section('title', 'useLuminii - Automate Your Service Business | Lead Generation, Job Management & Invoicing')

@section('description', 'Attract, Simplify, Automate & Grow with useLuminii. All-in-one platform for contractors, cleaners, landscapers and service providers. Manage leads, quotes, jobs, and invoices seamlessly. Get 50% off your first month!')

@section('keywords', 'business management software, CRM for contractors, job scheduling software, automated invoicing, lead generation platform, service business automation, field service management, contractor software, quote management, payment processing, small business CRM')

{{-- Open Graph Tags --}}
@section('og_title', 'useLuminii - All In One Business Management System')
@section('og_description', 'Streamline your service business with automated lead generation, quotes, job scheduling, and invoicing. Perfect for contractors, cleaners, plumbers, and landscapers.')

{{-- Twitter Card Tags --}}
@section('twitter_title', 'useLuminii - Business Management Platform for Service Providers')
@section('twitter_description', 'Automate your workflows and grow your business. Manage leads, quotes, jobs, and invoices in one powerful platform.')

{{-- Additional Structured Data for Homepage --}}
@section('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "useLuminii - Business Management System",
  "description": "All-in-one business management platform for service providers",
  "url": "{{ url('/') }}",
  "mainEntity": {
    "@type": "Service",
    "serviceType": "Business Management Software",
    "provider": {
      "@type": "Organization",
      "name": "useLuminii"
    },
    "areaServed": "ZA",
    "hasOfferCatalog": {
      "@type": "OfferCatalog",
      "name": "Business Management Services",
      "itemListElement": [
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Lead Generation & Management"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Automated Quote Generation"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Job Scheduling & Tracking"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Invoice Automation"
          }
        }
      ]
    }
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What do I get in my 30-days free trial of Luminii?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "During your 30-days trial, you'll get full access to all Luminii features—everything you need to streamline your job management, track tasks, and collaborate with your team. From task assignment to project timelines and client management, experience the full power of Luminii to optimize your operations."
      }
    },
    {
      "@type": "Question",
      "name": "Does Luminii offer customer support when setting up?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Absolutely! Luminii provides comprehensive customer support via email, chat, and phone. Our team is here to assist you with any questions or technical issues you may have."
      }
    },
    {
      "@type": "Question",
      "name": "Can I upgrade to a different plan at a later time?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Absolutely! You can upgrade your Luminii plan at any time to unlock more features and scale with your business needs — no hassle, no downtime."
      }
    }
  ]
}
</script>
@endsection

@section("content")
    <div >


        <section class="banner-five">
            <div class="tw-pt-100-px tw-mx-48-px position-relative gradient-bg-luminii rounded-top-30-px z-1">

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xxl-12">
                            <div class="text-center">
                                <div class="text-center mx-auto">

                                    <h1 class=" text-heading  tw-leading-none" style="color: white">
                                        Attract, Simplify, Automate & Grow <BR>with <span class="text-yellow text-stroke-yellow">useluminii</span>.
                                    </h1>

                                    <p
                                        class=" tw-text-xl tw-mt-605  max-w-5 mx-auto fw-medium tw-leading-145 " style="color: white"
                                    >
                                        Streamline your workflows, manage leads, quotes, jobs and invoices. All in one connected platform.
                                    </p>

                                    <div
                                        class="d-flex align-items-center justify-content-center tw-gap-405 tw-mt-10"
                                    >
                                        <a
                                            href="{{ url('/contact') }}"
                                            class="  hover--translate-y-1 active--translate-y-scale-9 btn  hover-style-one button--stroke d-sm-inline-flex d-none align-items-center justify-content-center tw-gap-5 group active--translate-y-2 tw-px-9 rounded-pill tw-py-4 fw-semibold common-shadow-inset-one"
                                            data-block="button"
                                        >
                                            <span class="button__flair"></span>
                                            <span class="button__label">Partner with Us Today</span>
                                        </a>
                                    </div>

                                    <!-- Centered "Free Trial" and "No Credit Card" -->
                                    <div
                                        class="d-flex align-items-center justify-content-center tw-gap-7 tw-mt-10"
                                    >

                                        </div>

                                        <div
                                            class="bg-white tw-py-2 tw-px-7 rounded-pill text-main-600 fw-bold text-capitalize tw-leading-none d-inline-flex align-items-center tw-gap-2 tw-mb-405 min-w-max common-shadow-twentyEight"
                                            data-aos="fade-up"
                                            data-aos-anchor-placement="top-bottom"
                                            data-aos-duration="600"
                                        >
                                            #Fully Customizable for Your Business
                                        </div>



                                        <div
                                            class="bg-white tw-py-2 tw-px-7 rounded-pill text-main-600 fw-bold text-capitalize tw-leading-none d-inline-flex align-items-center tw-gap-2 tw-mb-405 min-w-max common-shadow-twentyEight"
                                            data-aos="fade-up"
                                            data-aos-anchor-placement="top-bottom"
                                            data-aos-duration="600"
                                        >
                                            #On-Site Consultations & Assessments
                                        </div>

                                    <div
                                        class="tw-mt-14 d-inline-flex"
                                        id="v-pills-profile"
                                        role="tabpanel"
                                        aria-labelledby="v-pills-profile-tab"
                                        tabindex="0"
                                        data-aos="zoom-in"
                                        data-aos-anchor-placement="top-bottom"
                                        data-aos-duration="1200"
                                    >
                                        <div class="tw-rounded-2xl">
                                            <img
                                                src="useluminii/assets/images/thumbs/hero.png"
                                                alt="Thumbs"
                                                class="w-100 h-100"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- =================================== Banner Five section End =================================== -->

        <!-- ============================ Brand Five section start =========================== -->
        <div class="brand-three pt-100">
            <div class="container">

                <div class="tw-py-13 position-relative">
                    <span class="gradient-line w-100 tw-h-px position-absolute top-0 tw-start-0"></span>
                    <span class="gradient-line w-100 tw-h-px position-absolute bottom-0 tw-start-0"></span>

                    <div class="text-center tw-mb-16">
                        <h5 class="mb-0 line-clamp-1">Trusted By <span class="text-gradient-teal">Service Providers and Growing Businesses</span> Worldwide.</h5>
                    </div>
                    <div class="brand-three-slider swiper left-right-gradient gradient-width-200">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide d-flex align-items-center justify-content-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                                <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
                                Contractors
                              </span>
                            </div>
                            <div class="swiper-slide d-flex align-items-center justify-content-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="800">
                                                             <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
                                Cleaners
                              </span>
                            </div>
                            <div class="swiper-slide d-flex align-items-center justify-content-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="700">

                                <span class="fw-semibold text-white px-4 py-2 rounded-pill  gradient-bg-six shadow-sm">
                                Landscapers
                              </span>
                            </div>

                            <div class="swiper-slide d-flex align-items-center justify-content-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                                  <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
                                Plumbers
                              </span>
                            </div>
                            <div class="swiper-slide d-flex align-items-center justify-content-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="700">
                                   <span class="fw-semibold text-white px-4 py-2 rounded-pill  gradient-bg-six shadow-sm">
                                Painters
                              </span>
                            </div>

                            <div class="swiper-slide d-flex align-items-center justify-content-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                                  <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
                                Freelancers
                              </span>
                            </div>

                            <div class="swiper-slide d-flex align-items-center justify-content-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                                  <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
                                Construction
                              </span>
                            </div>

                            <div class="swiper-slide d-flex align-items-center justify-content-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                                  <span class="fw-semibold text-white px-4 py-2 rounded-pill  bg-yellow shadow-sm">
                                Auto Detailing
                              </span>
                            </div>

                            <div class="swiper-slide d-flex align-items-center justify-content-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                                  <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
                               Handyman
                              </span>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- ============================ Brand Five section end =========================== -->

        <!-- ============================ Features Three section start ============================ -->
        <section id="solution" class="features-three py-120 position-relative z-1">
                       <div class="container">
                <div class="d-flex align-items-center justify-content-between tw-gap-6 tw-mb-12">
                    <div class="max-w-620-px">
                        <h4 class=" text-heading text-capitalize">Do Less. Gain More. Let
                            <span class="font-dm-serif fst-italic fw-normal text-gradient-teal"> Automation </span>
                            Power Your Business.
                        </h4>
                    </div>
{{--                    <div class="" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="800" >--}}
{{--                        <p class=" text-neutral-500 tw-mt-8 max-w-490-px fw-medium">Luminii in the past allowing you to focus more on your business simply enjoy your newfound legal time to reflect leaving pen</p>--}}
{{--                    </div>--}}
                </div>

                <div class="row gy-4">
                    <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                        <div class="tw-rounded-xl bg-goldenrod tw-p-7 h-100">
                            <div class="tw-pt-8 tw-pb-10 tw-ps-4">
                                <div class="position-relative h-100 d-flex flex-column">
                                    <span class="z-3 position-relative tw-px-11 tw-py-205 fw-bold text-white gradient-bg-six rounded-pill transform-rotate--14-deg">Plumbing, HVAC, Landscaping</span>
                                    <span class="z-2 position-relative tw-px-11 tw-py-205 fw-bold text-heading bg-yellow rounded-pill">Construction & Contractors </span>
                                    <span class="z-1 position-relative tw-px-6 tw-py-205 fw-bold text-white gradient-bg-five rounded-pill transform-rotate-8-deg">Handyman, Painting, Cleaning, Roofing</span>
                                </div>
                            </div>

                            <div class="bg-white tw-rounded-lg common-shadow-twelve tw-py-5 tw-px-6">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fw-bold tw-text-sm">Workflow</span>
                                    <div class="dropdown">
                                        <button type="button" class="text-neutral-400" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ph-fill ph-dots-three-outline"></i>
                                        </button>
                                        <ul class="dropdown-menu border-0 min-w-max tw-p-4 common-shadow-eight">
                                            <li class="p-0">
                                                <a href="javascript:void(0)" class="nav-submenu__link hover-bg-neutral-200 text-heading fw-semibold w-100 d-block tw-py-2 tw-px-305 tw-rounded">Action</a>
                                            </li>
                                            <li class="p-0">
                                                <a href="javascript:void(0)" class="nav-submenu__link hover-bg-neutral-200 text-heading fw-semibold w-100 d-block tw-py-2 tw-px-305 tw-rounded">Another action</a>
                                            </li>
                                            <li class="p-0">
                                                <a href="javascript:void(0)" class="nav-submenu__link hover-bg-neutral-200 text-heading fw-semibold w-100 d-block tw-py-2 tw-px-305 tw-rounded">Something else here</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="tw-mt-7">
                                    <div class="d-flex align-items-center justify-content-between tw-pb-3 tw-mb-3 border-bottom border-neutral-100">
                                        <label for="Copywriting" class="d-flex align-items-center tw-gap-405">
                                            <span class="text-neutral-400 d-flex"><i class="ph-fill ph-tag"></i></span>
                                            <span class="text-heading fw-medium tw-text-sm">Requests</span>
                                        </label>
                                        <div class="form-check common-check-two">
                                            <input class="form-check-input me-0 float-none tw-w-6 tw-h-6 tw-rounded shadow-none bg-main-50" type="checkbox" id="Copywriting">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between tw-pb-3 tw-mb-3 border-bottom border-neutral-100">
                                        <label for="UIDesign" class="d-flex align-items-center tw-gap-405">
                                            <span class="text-neutral-400 d-flex"><i class="ph-fill ph-tag"></i></span>
                                            <span class="text-heading fw-medium tw-text-sm">Quotes</span>
                                        </label>
                                        <div class="form-check common-check-two">
                                            <input class="form-check-input me-0 float-none tw-w-6 tw-h-6 tw-rounded shadow-none bg-main-50" type="checkbox" id="UIDesign">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between tw-pb-3 tw-mb-3 border-bottom border-neutral-100">
                                        <label for="UIDesign" class="d-flex align-items-center tw-gap-405">
                                            <span class="text-neutral-400 d-flex"><i class="ph-fill ph-tag"></i></span>
                                            <span class="text-heading fw-medium tw-text-sm">Jobs</span>
                                        </label>
                                        <div class="form-check common-check-two">
                                            <input class="form-check-input me-0 float-none tw-w-6 tw-h-6 tw-rounded shadow-none bg-main-50" type="checkbox" id="UIDesign">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <label for="Illustrations" class="d-flex align-items-center tw-gap-405">
                                            <span class="text-neutral-400 d-flex"><i class="ph-fill ph-tag"></i></span>
                                            <span class="text-heading fw-medium tw-text-sm">Invoices</span>
                                        </label>
                                        <div class="form-check common-check-two">
                                            <input class="form-check-input me-0 float-none tw-w-6 tw-h-6 tw-rounded shadow-none bg-main-50" type="checkbox" id="Illustrations">
                                        </div>
                                    </div>




                                </div>
                            </div>



                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="700">
                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div class="group-item tw-rounded-xl border border-neutral-200 tw-pt-12 tw-pb-15 tw-px-9 bg-neutral-50 hover-gradient-bg-five group animation-item tw-duration-300 position-relative z-1">
                                    <div class="d-flex align-items-center justify-content-between tw-gap-2">
                                        <h5 class="group-hover-text-white tw-duration-300  ">Get Noticed by clients</h5>
                                        <span class="group-hover-item-text-invert tw-duration-300 animate__heartBeat">
                                    <img src="useluminii/assets/images/icons/magnet.png" alt="Icon" width="50" height="50">
                                </span>
                                    </div>
                                    <p class="text-neutral-500  tw-mt-10 group-hover-text-white tw-duration-300">High-converting websites and automated marketing tools help you stand out, attract quality leads, and grow your business effortlessly.</p>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <div class="group-item tw-rounded-xl border border-neutral-200 tw-pt-12 tw-pb-15 tw-px-9 bg-neutral-50 hover-gradient-bg-five group animation-item tw-duration-300 position-relative z-1">
                                    <div class="d-flex align-items-center justify-content-between tw-gap-2">
                                        <h5 class="group-hover-text-white tw-duration-300  ">Work Smarter & Deliver</h5>
                                        <span class="group-hover-item-text-invert tw-duration-300 animate__heartBeat">
                                    <img src="useluminii/assets/images/icons/innovation.png" alt="Icon" alt="Icon" width="50" height="50">
                                </span>
                                    </div>
                                    <p class="text-neutral-500  tw-mt-10 group-hover-text-white tw-duration-300">Save hours every week with automated job scheduling, invoicing, and payments. Reducing manual work while boosting productivity.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="800">
                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div class="group-item tw-rounded-xl border border-neutral-200 tw-pt-12 tw-pb-15 tw-px-9 bg-neutral-50 hover-gradient-bg-five group animation-item tw-duration-300 position-relative z-1">
                                    <div class="d-flex align-items-center justify-content-between tw-gap-2">
                                        <h5 class="group-hover-text-white tw-duration-300  ">Win More Jobs, Effortlessly</h5>
                                        <span class="group-hover-item-text-invert tw-duration-300 animate__heartBeat">
                                    <img src="useluminii/assets/images/icons/promotion.png" alt="Icon" alt="Icon" width="50" height="50">
                                </span>
                                    </div>
                                    <p class="text-neutral-500  tw-mt-10 group-hover-text-white tw-duration-300">Turn leads into confirmed jobs through smart follow-ups, instant notifications, and automated reminders that keep customers engaged.</p>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <div class="group-item tw-rounded-xl border border-neutral-200 tw-pt-12 tw-pb-15 tw-px-9 bg-neutral-50 hover-gradient-bg-five group animation-item tw-duration-300 position-relative z-1">
                                    <div class="d-flex align-items-center justify-content-between tw-gap-2">
                                        <h5 class="group-hover-text-white tw-duration-300  ">Boost Profits with Intelligent Insights</h5>
                                        <span class="group-hover-item-text-invert tw-duration-300 animate__heartBeat">
                                    <img src="useluminii/assets/images/icons/profit.png" alt="Icon" alt="Icon" width="50" height="50">
                                </span>
                                    </div>
                                    <p class="text-neutral-500  tw-mt-10 group-hover-text-white tw-duration-300">Track expenses, monitor income, and get automated reports that reveal where your money’s going, empowering smarter financial decisions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ============================ Features Three section End ============================ -->


        <!-- ============================ CTA Businesses ============================ -->
        <section class="workplace-team py-60 gradient-bg-five position-relative z-1">
            <div class="container">
                <!-- Header -->
                <div class="mb-5 text-center max-w-[570px] mx-auto">
                    <div
                        class="bg-white py-2 px-3 rounded-pill fw-medium text-capitalize leading-none d-inline-flex align-items-center gap-2 mb-3 min-w-max border border-spring-green shadow-sm"
                        data-aos="fade-up"
                        data-aos-anchor-placement="top-bottom"
                        data-aos-duration="600"
                    >
                        <div class="text-gradient-teal">
                            Up to <span class="text-yellow text-stroke-yellow">50%</span> Off First Month for Waitlist Members
                        </div>
                    </div>

                    <h4 class=" text-white text-2xl sm:text-3xl fw-semibold">
                        Powering modern
                        <span class="font-dm-serif fst-italic fw-normal">Service Providers </span>
                        and Growing Businesses Worldwide
                    </h4>
                </div>

                <!-- ============================ Industries Section Start ============================ -->
                <div
                    class="p-4 sm:p-6"
                    data-aos="fade-up"
                    data-aos-anchor-placement="top-bottom"
                    data-aos-duration="900"
                >
                    <div class="text-center pb-8 pt-2">
                        <div
                            class="d-flex flex-wrap justify-content-center align-items-center gap-3 sm:gap-4 px-3 w-100"
                        >
      <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
        Construction & Contractors
      </span>
                            <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
        Electrical Contractors
      </span>
                            <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
        Handyman
      </span>
                            <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
        Landscaping
      </span>
                            <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
        Residential Cleaning
      </span>
                            <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
        Roofing
      </span>
                            <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
        Plumbing
      </span>
                            <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
        Painting
      </span>
                            <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
        HVAC
      </span>
                            <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
        Commercial Cleaning
      </span>
                        </div>
                    </div>
                </div>
                <!-- ============================ Industries Section End ============================ -->

            </div>
        </section>
        <!-- ============================ CTA Businesses ============================ -->


        <!-- Features -->
        <section id="features" class="task-manager pt-120 pb-10">
            <div class="container">
                <div class="row gy-4 align-items-center">
                    <!-- Content column: full width on xs, 7/12 on lg -->
                    <!-- Image column: full width on xs, 5/12 on lg -->
                    <div
                        class="col-12 col-lg-5 text-center text-lg-end"
                        data-aos="fade-up"
                        data-aos-duration="800"
                    >
                        <div class="task-manager__thumb mx-auto mx-lg-0">
                            <img
                                src="useluminii/assets/images/thumbs/webb.svg"
                                alt="Dashboard Preview"
                                class="img-fluid rounded-3 shadow-sm"
                            />
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="task-manager__content">
                            <div
                                class="bg-white tw-py-3 tw-px-305 rounded-pill fw-medium text-capitalize tw-leading-none d-inline-flex align-items-center tw-gap-2 tw-mb-405 min-w-max border border-spring-green"
                                data-aos="fade-up"
                                data-aos-anchor-placement="top-bottom"
                                data-aos-duration="600"
                            >
                                <div class="text-gradient-teal">
                                    Up to <span class="text-yellow text-stroke-yellow">50%</span> Off First Month for Waitlist Members
                                </div>
                            </div>

                            <h4 class="h4 text-heading mb-3">
                                Build a
                                <span class="font-dm-serif fst-italic fw-bold text-gradient-teal">High-Converting Website</span>
                                for Your Business
                            </h4>

                            <!-- Description -->
                            <p class="lead text-neutral-500 mb-4">
                                Turn visitors into customers with a website designed to capture leads, showcase your services, and drive sales all in one seamless, modern platform.
                            </p>

                            <!-- Features -->
                            <div class="features d-flex flex-column gap-4">
                                <div class="d-flex align-items-start gap-3" data-aos="fade-up" data-aos-duration="600">
                                    <div class="icon-wrap flex-shrink-0">
                                        <img src="useluminii/assets/images/icons/magnet.png" alt="Lead Capture Icon" width="48" height="48">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Capture Leads Effortlessly</h6>
                                        <p class="text-neutral-500 mb-0">
                                            Convert visitors into potential customers with smart lead capture forms, pop-ups, and chatbots that work 24/7.
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3" data-aos="fade-up" data-aos-duration="1400">
                                    <div class="icon-wrap flex-shrink-0">
                                        <img src="useluminii/assets/images/icons/responsive.png" alt="Responsive Design Icon" width="48" height="48">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Fully Responsive, Fast & Secure</h6>
                                        <p class="text-neutral-500 mb-0">
                                            Provide a seamless experience across devices with secure fast-loading, mobile-friendly pages that keep visitors engaged.
                                        </p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="task-manager pt-5 pb-5">
            <div class="container">
                <div class="row gy-4 align-items-center">
                    <!-- Content column: full width on xs, 7/12 on lg -->
                    <div class="col-12 col-lg-7">
                        <div class="task-manager__content">
                            <div
                                class="bg-white tw-py-3 tw-px-305 rounded-pill fw-medium text-capitalize tw-leading-none d-inline-flex align-items-center tw-gap-2 tw-mb-405 min-w-max border border-spring-green"
                                data-aos="fade-up"
                                data-aos-anchor-placement="top-bottom"
                                data-aos-duration="600"
                            >
                                <div class="text-gradient-teal">
                                    Up to <span class="text-yellow text-stroke-yellow">50%</span> Off First Month for Waitlist Members
                                </div>
                            </div>

                            <!-- Title -->
                            <h4 class="h4 text-heading mb-3">
                                Leads, Quotes, Jobs & Invoice
                                <span class="font-dm-serif fst-italic fw-normal text-gradient-teal">Management</span>
                            </h4>

                            <!-- Description -->
                            <p class="lead text-neutral-500 mb-4">
                                Streamline and automate your entire workflow, from capturing leads to scheduling jobs and sending invoices.
                                All in one connected platform.
                            </p>

                            <!-- Features -->
                            <div class="features d-flex flex-column gap-4">
                                <div
                                    class="d-flex align-items-start gap-3"
                                    data-aos="fade-up"
                                    data-aos-duration="600"
                                >
                                    <div class="icon-wrap flex-shrink-0">
                                        <img src="useluminii/assets/images/icons/automation.png" alt="Lead Capture Icon" width="48" height="48">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Automate Quotes, Jobs, and Invoices.</h6>
                                        <p class="text-neutral-500 mb-0">
                                            Streamline your entire workflow from lead capture to invoicing. Create professional, easy-to-approve quotes and close deals faster.
                                        </p>
                                    </div>
                                </div>

                                <div
                                    class="d-flex align-items-start gap-3"
                                    data-aos="fade-up"
                                    data-aos-duration="800"
                                >
                                    <div class="icon-wrap flex-shrink-0">
                                        <img src="useluminii/assets/images/icons/calendar.png" alt="Workflow Automation Icon" width="48" height="48">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Smart Job Scheduling.</h6>
                                        <p class="text-neutral-500 mb-0">
                                            Assign and schedule jobs effortlessly with real-time updates, ensuring your team stays productive and on track.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image column: full width on xs, 5/12 on lg -->
                    <div
                        class="col-12 col-lg-5 text-center text-lg-end"
                        data-aos="fade-up"
                        data-aos-duration="800"
                    >
                        <div class="task-manager__thumb mx-auto mx-lg-0">
                            <img
                                src="useluminii/assets/images/thumbs/dash.svg"
                                alt="Dashboard Preview"
                                class="img-fluid rounded-3 shadow-sm"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="position-relative gradient-bg-80-percent z-1">
            <!-- ============================ More Powerfull features ============================== -->
            <section class="plan-execute py-100">
                <div class="container max-w-1570-px">

                    <div class="max-w-602-px text-center mx-auto tw-mb-13">
                        <div class="bg-white tw-py-3 tw-px-305 rounded-pill fw-medium text-capitalize tw-leading-none d-inline-flex align-items-center tw-gap-2 tw-mb-405 min-w-max border border-spring-green" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600" >
                            <div class="text-gradient-teal">
                                Up to <span class="text-yellow text-stroke-yellow">50%</span> Off First Month for Waitlist Members
                            </div>
                        </div>
                        <h4 class=" text-heading ">
                            Unlock More Powerful Features to
                            <span class="font-dm-serif fst-italic fw-normal text-gradient-teal"> Grow Your Business</span>
                            with useLuminii.
                        </h4>
                    </div>

                    <div class="plan-execute-slider swiper">
                        <div class="swiper-wrapper">

                            <!-- Reporting -->
                            <div class="swiper-slide" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                                <div class="plan-execute-item">
                                    <div class="tw-rounded-2xl overflow-hidden">
                                        <img src="useluminii/assets/images/thumbs/plan-execute-img1.png" alt="thumbnail" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <div class="tw-mt-8 text-center">
                                        <h6 class="tw-mb-205">Reporting</h6>
                                        <p class="text-neutral-500 max-w-278-px mx-auto">Gain real-time insights into your business performance with intuitive dashboards and detailed reports.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Expense Tracking -->
                            <div class="swiper-slide" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="700">
                                <div class="plan-execute-item">
                                    <div class="tw-rounded-2xl overflow-hidden">
                                        <img src="useluminii/assets/images/thumbs/plan-execute-img3.png" alt="thumbnail" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <div class="tw-mt-8 text-center">
                                        <h6 class="tw-mb-205">Expense Tracking</h6>
                                        <p class="text-neutral-500 max-w-278-px mx-auto">Easily record, categorize, and monitor all your expenses to keep your business finances on track.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- VAT & Payroll Management -->
                            <div class="swiper-slide" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="800">
                                <div class="plan-execute-item">
                                    <div class="tw-rounded-2xl overflow-hidden">
                                        <img src="useluminii/assets/images/thumbs/plan-execute-img2.png" alt="thumbnail" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <div class="tw-mt-8 text-center">
                                        <h6 class="tw-mb-205">VAT & Payroll Management</h6>
                                        <p class="text-neutral-500 max-w-278-px mx-auto">Simplify tax and payroll processing with automated calculations and compliance tracking.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- AI Integrations -->
                            <div class="swiper-slide" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="900">
                                <div class="plan-execute-item">
                                    <div class="tw-rounded-2xl overflow-hidden">
                                        <img src="useluminii/assets/images/thumbs/plan-execute-img4.png" alt="thumbnail" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <div class="tw-mt-8 text-center">
                                        <h6 class="tw-mb-205">AI Integrations</h6>
                                        <p class="text-neutral-500 max-w-278-px mx-auto">Boost productivity with AI-driven insights, automation, and intelligent task recommendations.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Inventory Management -->
                            <div class="swiper-slide" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="700">
                                <div class="plan-execute-item">
                                    <div class="tw-rounded-2xl overflow-hidden">
                                        <img src="useluminii/assets/images/thumbs/plan-execute-img3.png" alt="thumbnail" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <div class="tw-mt-8 text-center">
                                        <h6 class="tw-mb-205">Inventory Management</h6>
                                        <p class="text-neutral-500 max-w-278-px mx-auto">Track stock levels, manage suppliers, and ensure timely replenishment all from one dashboard.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="plan-execute-pagination pagination-style-three pb-1 d-flex align-items-center justify-content-center tw-mt-15"></div>
                    </div>
                </div>
            </section><br>





        <!-- ================================ Testimonials Three section start ===================================== -->
        <section class="testimonials-three">
            <div class="container max-w-1290-px">
                <div class="bg-main-three tw-rounded-2xl overflow-hidden tw-py-16 tw-px-11 d-flex align-items-center flex-md-row flex-column tw-gap-74-px">
                    <div class="max-w-400-px w-100">
                        <img src="useluminii/assets/images/thumbs/model-img.png" alt="Testimonials Thumb"  data-aos="zoom-in" data-aos-duration="800">
                    </div>


                    <div class="testimonials-three-slider swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                                <div class="">
                            <span class="tw-mb-705">
                                <img src="useluminii/assets/images/icons/ratings.svg" alt="" class="">
                            </span>
                                    <p class="text-30-px fw-normal text-white max-w-672-px tw-leading-145">"useluminii made managing my business effortless. Leads, invoices, and follow-ups are all automated saving me hours every day."</p>
                                    <span class="d-block w-100 tw-h-px tw-mt-12 tw-mb-4 bg-white-08"></span>
                                    <div class="tw-px-705 tw-py-2 bg-white-06 d-inline-flex align-items-center tw-gap-6" style="border-radius: 10px">
{{--                                        <div class="tw-w-17 tw-h-17 rounded-circle overflow-hidden" >--}}
{{--                                            <img src="useluminii/assets/images/thumbs/client-img.png" alt="Client Thumb">--}}
{{--                                        </div>--}}
                                        <div class="">
                                            <h6 class="text-white fw-medium tw-mb-1">Charity  </h6>
                                            <div class="text-white fw-medium tw-text-base">
                                                Spring Kleaners
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                                <div class="">
                            <span class="tw-mb-705">
                                <img src="useluminii/assets/images/icons/ratings.svg" alt="" class="">
                            </span>
                                    <p class="text-30-px fw-normal text-white max-w-672-px tw-leading-145">"Super easy to use, useluminii helped me respond faster to clients and close more deals. Definitely recommend it to others!"</p>
                                    <span class="d-block w-100 tw-h-px tw-mt-12 tw-mb-4 bg-white-08"></span>
                                    <div class="tw-px-705 tw-py-2 bg-white-06 d-inline-flex align-items-center tw-gap-6" style="border-radius: 10px">
{{--                                        <div class="tw-w-17 tw-h-17 rounded-circle overflow-hidden">--}}
{{--                                            <img src="useluminii/assets/images/thumbs/client-img2.png" alt="Client Thumb">--}}
{{--                                        </div>--}}
                                        <div class="">
                                            <h6 class="text-white fw-medium tw-mb-1">Audrey  </h6>
                                            <div class="text-white fw-medium tw-text-base">
                                                 Lifestyle Laundry
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- ================================ Testimonials Three section End ===================================== -->

        </div>
        <!-- ====================================== Pricing Plan three start ==================================== -->
        <section id="pricing" class="pricing-plan-three pt-120">
            <div class="container">
                <div class="max-w-602-px text-center mx-auto tw-mb-13">
                    <div class="bg-white tw-py-3 tw-px-305 rounded-pill fw-medium text-capitalize tw-leading-none d-inline-flex align-items-center tw-gap-2 tw-mb-405 min-w-max border border-spring-green" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600" >
                        <div class="text-gradient-teal">
                            Up to <span class="text-yellow text-stroke-yellow">50%</span> Off First Month for Waitlist Members
                        </div>
                    </div>
                    <h4 class=" text-heading text-capitalize text-capitalize">
                        Flexible Pricing Plans
                        <span class="font-dm-serif fst-italic fw-normal text-gradient-teal">Designed</span>
                        for Any Business
                    </h4>
                </div>

                <div class="row gy-4">
                    <div class="col-xl-4 col-sm-6" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600" >
                        <div class="position-relative bg-neutral-100 tw-px-7 tw-py-16 bg-white hover-border-main-600" style="border-radius: 10px">
                            <div class="">
                                <div class="tw-ps-205">
                                    <h5 class="tw-mb-1">Luminii Spark</h5>
                                    <p class="text-neutral-500">High-converting website. Built for growth.</p>

                                    <span class="d-block tw-h-px bg-neutral-200 tw-my-6"></span>
                                    <div class="d-flex align-items-center justify-content-between tw-gap-1 tw-mb-10">
                                        <h4 class="mb-0"><span class="tw-text-xl fw-medium">from</span> R8000.00<span class="tw-text-xl fw-medium">/Once-off</span> </h4>
                                    </div>
                                </div>
                                <a href="https://wa.me/27814303023?text=Hi%20ShiftTech%20team%2C%20I%E2%80%99m%20interested%20in%20getting%20a%20quote%20for%20Luminii%20Spark%20(Website)."
                                   target="_blank"
                                   class="hover--translate-y-1 active--translate-y-scale-9 btn btn-main hover-style-one button--stroke d-flex align-items-center justify-content-center tw-gap-5 group active--translate-y-2 tw-px-9 rounded-pill tw-py-4 fw-semibold common-shadow-inset-one"
                                   data-block="button">
                                    <span class="button__flair"></span>
                                    <span class="button__label">
        <i class="fa fa-whatsapp me-2"></i> Get A Quote
    </span>
                                </a>


                                <div class="tw-ps-205">
                                    <div class="d-flex flex-column tw-gap-5 tw-mt-10">
                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">A responsive & high-converting website</span>
                                        </div>
                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="620" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Customized design to match your brand.</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="660" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Mobile and SEO optimization</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="660" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">One month free hosting</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="680" >
                                          <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                                <i class="text-gradient-teal ph-bold ph-check"></i>
                                               </span>
                                            <span class="text-heading fw-semibold tw-text-base">One month FREE on useLuminii CRM</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="680" >
                                          <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                                <i class="text-gradient-teal ph-bold ph-check"></i>
                                               </span>
                                            <span class="text-heading fw-semibold tw-text-base">Free onboarding & setup support</span>
                                        </div>
                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="680" >
                                          <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                                <i class="text-gradient-teal ph-bold ph-check"></i>
                                               </span>
                                            <span class="text-heading fw-semibold tw-text-base">Dedicated Design Team</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="800" >
                        <div class="position-relative bg-neutral-100 tw-px-7 tw-py-16 bg-white hover-border-main-600" style="border-radius: 10px">
                            <div class="">
                                <div class="tw-ps-205">
                                    <h5 class="tw-mb-1">Luminii Blaze</h5>
                                    <p class="text-neutral-500">For growing business.</p>
                                    <span class="d-block tw-h-px bg-neutral-200 tw-my-6"></span>
                                    <div class="d-flex align-items-center justify-content-between tw-gap-1 tw-mb-10">
                                        <h4 class="mb-0"><span class="tw-text-xl fw-medium">from</span> R450.00<span class="tw-text-xl fw-medium">/Month</span> </h4>
                                    </div>
                                </div>

                                <a href="https://wa.me/27814303023?text=Hi%20ShiftTech%20team%2C%20I%E2%80%99m%20interested%20in%20getting%20a%20quote%20for%20Luminii%20Blaze%20(Website)."
                                   target="_blank"
                                   class="hover--translate-y-1 active--translate-y-scale-9 btn btn-main hover-style-one button--stroke d-flex align-items-center justify-content-center tw-gap-5 group active--translate-y-2 tw-px-9 rounded-pill tw-py-4 fw-semibold common-shadow-inset-one"
                                   data-block="button">
                                    <span class="button__flair"></span>
                                    <span class="button__label">
        <i class="fa fa-whatsapp me-2"></i> Get A Quote
    </span>
                                </a>

                                <div class="tw-ps-205">
                                    <div class="d-flex flex-column tw-gap-5 tw-mt-10">
                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Website Integrated (optional)</span>
                                        </div>
                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="620" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Unlimited Quotes</span>
                                        </div>
                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="640" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Team Job Scheduling</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="660" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Unlimited Invoices</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="680" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Unlimited Reports & Statistics
</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="680" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Automated Reminders</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="680" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Dedicated Account Manager</span>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6" data-aos="fade-up" data-aos-anchor-placement="top-bottom"  data-aos-duration="900" >
                        <div class="position-relative bg-neutral-100 tw-px-7 tw-py-16 bg-white hover-border-main-600" style="border-radius: 10px">
                            <div class="">
                                <div class="tw-ps-205">
                                    <h5 class="tw-mb-1">Luminii Radiance</h5>
                                    <p class="text-neutral-500">For enterprise-grade custom solutions.</p>
                                    <span class="d-block tw-h-px bg-neutral-200 tw-my-6"></span>
                                    <div class="d-flex align-items-center justify-content-between tw-gap-1 tw-mb-10">
                                        <h4 class="mb-0">Spec-Driven <span class="tw-text-xl fw-medium">/any business</span>  </h4>
                                    </div>
                                </div>
                                <a href="https://wa.me/27814303023?text=Hi%20ShiftTech%20team%2C%20I%E2%80%99m%20interested%20in%20partnering%20with%20you%20on%20Luminii%20Radiance%20(Custom software)."
                                   target="_blank"
                                   class="hover--translate-y-1 active--translate-y-scale-9 btn btn-main hover-style-one button--stroke d-flex align-items-center justify-content-center tw-gap-5 group active--translate-y-2 tw-px-9 rounded-pill tw-py-4 fw-semibold common-shadow-inset-one"
                                   data-block="button">
                                    <span class="button__flair"></span>
                                    <span class="button__label">
        <i class="fa fa-whatsapp me-2"></i> Partner With Us Today
    </span>
                                </a>


                                <div class="tw-ps-205">
                                    <div class="d-flex flex-column tw-gap-5 tw-mt-10">
                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Website Integrated (optional)</span>
                                        </div>
                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="620" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Unlimited Quotes</span>
                                        </div>
                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="640" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Team Job Scheduling</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="660" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Unlimited Invoices</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="680" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Unlimited Reports & Statistics
</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="680" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Custom API integration</span>
                                        </div>

                                        <div class="d-flex align-items-center tw-gap-305" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="680" >
                                    <span class="tw-w-7 tw-h-7 bg-main-50 rounded-circle d-flex justify-content-center align-items-center tw-text-sm">
                                        <i class="text-gradient-teal ph-bold ph-check"></i>
                                    </span>
                                            <span class="text-heading fw-semibold tw-text-base">Dedicated Account Manager</span>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====================================== Pricing Plan three End ==================================== -->



        <!-- ============================== Faq Two Section Start ============================== -->
        <section id="faq" class="faq-two pt-120">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-5">
                        <div class="">
                            <div class="bg-neutral-100 tw-py-3 tw-px-305 rounded-pill text-heading fw-medium text-capitalize tw-leading-none d-inline-flex align-items-center tw-gap-2 tw-mb-405 min-w-max" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600" >
                                <span class="tw-w-205 tw-h-205 bg-yellow rounded-circle"></span>
                                Up to <span class="text-yellow">50%</span> Off First Month for Waitlist Members
                            </div>
                            <h4 class=" text-heading text-capitalize">
                                Frequently ask
                                <span class="font-dm-serif fst-italic fw-normal">Questions</span>
                            </h4>
                            <p class=" text-neutral-500 tw-mt-8 max-w-450-px fw-medium">Unlock reliable solutions and streamline your processes with ease. Have more questions? We're here to help, feel free to contact us!</p>

                            <div class="tw-mt-9" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="900" >
                                <a href="{{ url('/contact') }}" class="hover--translate-y-1 active--translate-y-scale-9 btn btn-main hover-style-one button--stroke d-sm-inline-flex d-none align-items-center justify-content-center tw-gap-5 group active--translate-y-2 tw-px-9 rounded-pill tw-py-4 fw-semibold common-shadow-inset-one" data-block="button">
                                    <span class="button__flair"></span>
                                    <span class="button__label">Partner With Us Today</span>
                                </a>
                                <button type="button" class="toggle-mobileMenu leading-none d-lg-none text-neutral-800 tw-text-9">
                                    <i class="ph ph-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="ps-xl-5">
                            <div class="accordion common-accordion style-two arrow-bg-orange" id="accordionExample">

                                <!-- Question 1: Open by default -->
                                <div class="accordion-item tw-py-8 tw-px-40-px tw-rounded-xl bg-transparent border-0 mb-0" data-aos="fade-up" data-aos-duration="800">
                                    <h5 class="accordion-header d-flex align-items-center justify-content-between tw-gap-3">
                                        <button class="accordion-button shadow-none p-0 line-clamp-3 bg-transparent h5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            What do I get in my 30-days free trial of Luminii?
                                        </button>
                                    </h5>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                        <div class="accordion-body p-0 tw-mt-605 max-w-620-px">
                                            <p class="text-neutral-500">
                                                During your 30-days trial, you’ll get full access to all Luminii features—everything you need to streamline your job management, track tasks, and collaborate with your team. From task assignment to project timelines and client management, experience the full power of Luminii to optimize your operations. After the trial, you’ll have the option to choose the plan that best fits your business needs.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: Closed by default -->
                                <div class="accordion-item tw-py-8 tw-px-40-px tw-rounded-xl bg-transparent border-0 mb-0" data-aos="fade-up" data-aos-duration="800">
                                    <h5 class="accordion-header d-flex align-items-center justify-content-between tw-gap-3">
                                        <button class="accordion-button shadow-none p-0 line-clamp-3 bg-transparent h5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Does Luminii offer customer support when setting up?
                                        </button>
                                    </h5>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body p-0 tw-mt-605 max-w-620-px">
                                            <p class="text-neutral-500">
                                                Absolutely! Luminii provides comprehensive customer support via email, chat, and phone. Our team is here to assist you with any questions or technical issues you may have.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3 -->
                                <div class="accordion-item tw-py-8 tw-px-40-px tw-rounded-xl bg-transparent border-0 mb-0" data-aos="fade-up" data-aos-duration="800">
                                    <h5 class="accordion-header d-flex align-items-center justify-content-between tw-gap-3">
                                        <button class="accordion-button shadow-none p-0 line-clamp-3 bg-transparent h5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Can I upgrade to a different plan at a later time?
                                        </button>
                                    </h5>
                                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body p-0 tw-mt-605 max-w-620-px">
                                            <p class="text-neutral-500">
                                                Absolutely! You can upgrade your Luminii plan at any time to unlock more features and scale with your business needs — no hassle, no downtime.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 4 -->
                                <div class="accordion-item tw-py-8 tw-px-40-px tw-rounded-xl bg-transparent border-0 mb-0" data-aos="fade-up" data-aos-duration="800">
                                    <h5 class="accordion-header d-flex align-items-center justify-content-between tw-gap-3">
                                        <button class="accordion-button shadow-none p-0 line-clamp-3 bg-transparent h5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            How do I collaborate with my team using Luminii?
                                        </button>
                                    </h5>
                                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body p-0 tw-mt-605 max-w-620-px">
                                            <p class="text-neutral-500">
                                                Luminii makes team collaboration easy with its intuitive interface. You can assign tasks, set deadlines, track progress, and share updates—all in real time.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 5 -->
                                <div class="accordion-item tw-py-8 tw-px-40-px tw-rounded-xl bg-transparent border-0 mb-0" data-aos="fade-up" data-aos-duration="800">
                                    <h5 class="accordion-header d-flex align-items-center justify-content-between tw-gap-3">
                                        <button class="accordion-button shadow-none p-0 line-clamp-3 bg-transparent h5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            Can Luminii help me transfer my data?
                                        </button>
                                    </h5>
                                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body p-0 tw-mt-605 max-w-620-px">
                                            <p class="text-neutral-500">
                                                Yes, we offer data migration support to help you seamlessly transition from your current system to Luminii.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- ============================== Faq Two Section End ============================== -->


        <!-- ================================= Final CTA ============================== -->
        <section class="pt-120 task-management bg-pink-more-light-half drag-rotate-element-section bg-pink-more-light-half">
            <div class="container">


                <div class="bg-green-deep tw-rounded-3xl bg-green-deep tw-pt-100-px position-relative z-1">
{{--                    <img src="useluminii/assets/images/shapes/hill-shape.png" alt="Hill Shape" class="position-absolute w-100 h-100 top-0 tw-start-0 z-n1">--}}
{{--                    <img src="useluminii/assets/images/thumbs/task-management-img.png" alt="Image" class="position-absolute tw-end-0 top-0 tw-me-5 tw-mt-5 d-lg-block d-none">--}}

                    <div class="tw-mb-8 text-center max-w-620-px mx-auto">
                        <!-- Offer Badge -->
                        <div class="tw-py-3 tw-px-305 rounded-pill fw-medium text-capitalize tw-leading-none d-inline-flex align-items-center tw-gap-2 tw-mb-405 min-w-max text-white bg-white-13"
                             data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="600">
                            <div>
                                Up to <span class="text-yellow text-stroke-yellow">50%</span> Off First Month for Waitlist Members
                            </div>
                        </div>

                        <!-- Headline -->
                        <h3 class=" text-white">
                            Automate. Simplify. Grow with uselumini<span class="text-yellow text-stroke-yellow">i</span>.
                        </h3>

                        <!-- Centered Form -->
                        <div class="d-flex justify-content-center tw-mt-11" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="800">
                            <a href="{{ url('/contact') }}" class="hover--translate-y-1 active--translate-y-scale-9 btn btn-main hover-style-one button--stroke d-sm-inline-flex d-none align-items-center justify-content-center tw-gap-5 group active--translate-y-2 tw-px-9 rounded-pill tw-py-4 fw-semibold common-shadow-inset-one" data-block="button">
                                <span class="button__flair"></span>
                                <span class="button__label">Partner With Us Today</span>
                            </a>
                            <button type="button" class="toggle-mobileMenu leading-none d-lg-none text-neutral-800 tw-text-9">
                                <i class="ph ph-list"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ============================ Industries Section Start ============================ -->
                    <div
                        class="p-4 sm:p-6"
                        data-aos="fade-up"
                        data-aos-anchor-placement="top-bottom"
                        data-aos-duration="900"
                    >
                        <div class="text-center pb-8 pt-2">
                            <div
                                class="d-flex flex-wrap justify-content-center align-items-center gap-3 sm:gap-4 px-3 w-100"
                            >
      <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
        Construction & Contractors
      </span>
                                <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
        Electrical Contractors
      </span>
                                <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
        Handyman
      </span>
                                <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
        Landscaping
      </span>
                                <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
        Residential Cleaning
      </span>
                                <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
        Roofing
      </span>
                                <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
        Plumbing
      </span>
                                <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
        Painting
      </span>
                                <span class="fw-semibold text-white px-4 py-2 rounded-pill gradient-bg-six shadow-sm">
        HVAC
      </span>
                                <span class="fw-semibold text-white px-4 py-2 rounded-pill bg-yellow shadow-sm">
        Commercial Cleaning
      </span>
                            </div>
                        </div>
                    </div>
                    <!-- ============================ Industries Section End ============================ -->

                </div>
            </div>
        </section>
        <!-- ================================= Final CTA ============================== -->
    </div>
@endsection
