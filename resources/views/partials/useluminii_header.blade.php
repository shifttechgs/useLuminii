<!--==================== Overlay Start ====================-->
<div class="overlay"></div>
<!--==================== Overlay End ====================-->

<!--==================== Sidebar Overlay End ====================-->
<div class="side-overlay"></div>
<!--==================== Sidebar Overlay End ====================-->

<!-- Custom Toast Message start -->
<div id="toast-container"></div>
<!-- Custom Toast Message End -->

<!-- ==================== Scroll to Top End Here ==================== -->
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
<!-- ==================== Scroll to Top End Here ==================== -->

<!-- Custom Cursor Start -->
<div class="cursor"></div>
<span class="dot"></span>
<!-- Custom Cursor End -->

<!-- ==================== Mobile Menu Start Here ==================== -->
<div class="mobile-menu d-lg-none d-block scroll-sm position-fixed bg-white tw-w-300-px tw-h-screen overflow-y-auto tw-p-6 tw-z-999 tw--translate-x-full tw-pb-68 ">

    <button type="button" class="close-button position-absolute tw-end-0 top-0 tw-me-2 tw-mt-2 tw-w-605 tw-h-605 rounded-circle d-flex justify-content-center align-items-center text-neutral-900 bg-neutral-200 hover-bg-neutral-900 hover-text-white">
        <i class="ph ph-x"></i>
    </button>

    <div class="mobile-menu__inner">
        <a href="index.html" class="mobile-menu__logo">
            <img src="useluminii/assets/images/logo/useluminii_logo.png" alt="Logo">
        </a>
        <div class="mobile-menu__menu">
            <!-- Nav menu Start -->
            <ul class="nav-menu d-lg-flex align-items-center nav-menu--mobile d-block tw-mt-8">

                <li class="nav-menu__item  position-relative activePage">
                    <a href="{{ url('/') }}" class="nav-menu__link hover--translate-y-1 tw-pe-5 text-heading tw-py-9 fw-semibold w-100">Home</a>
                </li>
{{--                <li class="nav-menu__item  position-relative">--}}
{{--                    <a href="#solution" class="nav-menu__link hover--translate-y-1 tw-pe-5 text-heading tw-py-9 fw-semibold w-100">Solution</a>--}}
{{--                </li>--}}
                <li class="nav-menu__item  position-relative">
                    <a href="{{ url('/') }}#features" class="nav-menu__link hover--translate-y-1 tw-pe-5 text-heading tw-py-9 fw-semibold w-100">Features</a>
                </li>

                <li class="nav-menu__item  position-relative">
                    <a href="{{ url('/') }}#pricing" class="nav-menu__link hover--translate-y-1 tw-pe-5 text-heading tw-py-9 fw-semibold w-100">Pricing</a>
                </li>
                <li class="nav-menu__item  position-relative">
                    <a href="{{ url('/') }}#faq" class="nav-menu__link hover--translate-y-1 tw-pe-5 text-heading tw-py-9 fw-semibold w-100">Frequently Asked Questions</a>
                </li>
            </ul>
            <!-- Nav menu End  -->


        </div>



    </div>
</div>
<!-- ==================== Mobile Menu End Here ==================== -->


    <!-- ========================== Top Header Start ============================== -->
    <div class="gradient-bg-luminii tw-py-205 d-sm-block d-none">
        <div class="container">
            <div class="d-flex justify-content-center">
                <p class="text-white bg-white-13 d-inline-block tw-py-1 tw-px-5 rounded-pill fw-normal">Partner with useluminii to Attract,Simplify, Automate, & Grow Your Business Today.</p>
            </div>
        </div>
    </div>
    <!-- ========================== Top Header End ============================== -->

    <!-- ==================== Header Five Start Here ==================== -->
    <header class="header bg-white transition-all">
        <div class="container container-two">
            <nav class="d-flex align-items-center justify-content-between">
                <!-- Logo Start -->
                <div class="logo">
                    <a href="" class="link hover--translate-y-1 active--translate-y-scale-9">
                        <img src="useluminii/assets/images/logo/useluminii_logo.png" alt="useLuminii" class="max-w-200-px">
                    </a>
                </div>
                <!-- Logo End  -->

                <!-- Menu Start  -->
                <div class="header-menu d-lg-block d-none">
                    <!-- Nav menu Start -->
                    <ul class="nav-menu d-lg-flex align-items-center tw-gap-14">
                        <li class="nav-menu__item  position-relative activePage">
                            <a href="{{ url('/') }}" class="nav-menu__link hover--translate-y-1 tw-pe-5 text-heading tw-py-9 fw-semibold w-100">Home</a>
                               </li>
{{--                        <li class="nav-menu__item  position-relative">--}}
{{--                            <a href="#solution" class="nav-menu__link hover--translate-y-1 tw-pe-5 text-heading tw-py-9 fw-semibold w-100">Solution</a>--}}
{{--                             </li>--}}
                        <li class="nav-menu__item  position-relative">
                            <a href="{{ url('/') }}#features" class="nav-menu__link hover--translate-y-1 tw-pe-5 text-heading tw-py-9 fw-semibold w-100">Features</a>
                        </li>

                        <li class="nav-menu__item  position-relative">
                            <a href="{{ url('/') }}#pricing" class="nav-menu__link hover--translate-y-1 tw-pe-5 text-heading tw-py-9 fw-semibold w-100">Pricing</a>
                        </li>
                        <li class="nav-menu__item  position-relative">
                            <a href="{{ url('/') }}#faq" class="nav-menu__link hover--translate-y-1 tw-pe-5 text-heading tw-py-9 fw-semibold w-100">Frequently Asked Questions</a>
                              </li>

                    </ul>
                    <!-- Nav menu End  -->

                </div>
                <!-- Menu End  -->

                <!-- Header Right start -->
                <div class="d-flex align-items-center tw-gap-6">
                    <a href="{{ url('/contact') }}" class=" gradient-bg-six hover--translate-y-1 active--translate-y-scale-9 btn btn-main hover-style-one button--stroke d-sm-inline-flex d-none align-items-center justify-content-center tw-gap-5 group active--translate-y-2 tw-px-9 rounded-pill tw-py-4 fw-semibold common-shadow-inset-one" data-block="button">
                        <span class="button__flair"></span>
                        <span class="button__label">Partner With Us Today</span>
                    </a>
                    <button type="button" class="toggle-mobileMenu leading-none d-lg-none text-yellow  tw-text-9">
                        <i class="ph ph-list"></i>
                    </button>
                </div>
                <!-- Header Right End  -->
            </nav>
        </div>
    </header>
    <!-- ==================== Header Five End Here ==================== -->




