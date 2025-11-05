<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="home-three crm-page">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="author" content="useLuminii">

    <!-- ========== Dynamic Page Title ========== -->
    <title>@yield('title', 'All In One Business Management System | useLuminii - Automate Your Service Business')</title>

    <!-- ========== SEO Meta Tags ========== -->
    <meta name="description" content="@yield('description', 'Streamline your service business with useLuminii. Automated lead generation, quotes, invoicing, job scheduling, and payments for contractors, cleaners, landscapers, plumbers, and service providers. Start your 30-day free trial.')">
    <meta name="keywords" content="@yield('keywords', 'business management software, CRM for contractors, job scheduling, invoice automation, lead generation, quote management, field service management, small business software, contractor CRM, payment processing, service business automation, plumber software, cleaner management system, landscaping software')">
    <meta name="robots" content="@yield('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    <meta name="googlebot" content="index, follow">
    <meta name="google" content="notranslate">

    <!-- ========== Canonical URL ========== -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- ========== Open Graph Tags (Facebook, LinkedIn) ========== -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'useLuminii - All In One Business Management System')">
    <meta property="og:description" content="@yield('og_description', 'Attract, Simplify, Automate & Grow with useLuminii. Manage leads, quotes, jobs, and invoices in one connected platform. Get 50% off your first month!')">
    <meta property="og:image" content="@yield('og_image', asset('useluminii/assets/images/logo/og-image.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="useLuminii">
    <meta property="og:locale" content="en_US">

    <!-- ========== Twitter Card Tags ========== -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'useLuminii - Business Management System for Service Providers')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Streamline workflows, manage leads, quotes, jobs and invoices. All in one connected platform. 30-day free trial available.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('useluminii/assets/images/logo/twitter-card.png'))">
    <meta name="twitter:site" content="@useluminii">
    <meta name="twitter:creator" content="@useluminii">

    <!-- ========== Favicon & App Icons ========== -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('useluminii/assets/images/logo/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('useluminii/assets/images/logo/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('useluminii/assets/images/logo/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('useluminii/assets/images/logo/favicon.png') }}">
    <meta name="theme-color" content="#1a1a1a">

    <!-- ========== PWA Manifest ========== -->
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- ========== Sitemap Reference ========== -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('sitemap.xml') }}">

    <!-- ========== DNS Prefetch & Preconnect for Performance ========== -->
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- ========== Preload Critical Assets ========== -->
    <link rel="preload" href="{{ asset('useluminii/assets/css/main.css') }}" as="style">
    <link rel="preload" href="{{ asset('useluminii/assets/js/jquery-3.7.1.min.js') }}" as="script">

    <!-- ========== Bootstrap ========== -->
    <link rel="stylesheet" href="{{ asset('useluminii/assets/css/bootstrap.min.css') }}">

    <!-- ========== AOS Animation ========== -->
    <link rel="stylesheet" href="{{ asset('useluminii/assets/css/aos.css') }}">

    <!-- ========== Swiper Slider ========== -->
    <link rel="stylesheet" href="{{ asset('useluminii/assets/css/swiper-bundle.min.css') }}">

    <!-- ========== Magnific Popup ========== -->
    <link rel="stylesheet" href="{{ asset('useluminii/assets/css/magnific-popup.css') }}">

    <!-- ========== Satoshi Font ========== -->
    <link rel="stylesheet" href="{{ asset('useluminii/assets/css/satoshi.css') }}">

    <!-- ========== Main CSS ========== -->
    <link rel="stylesheet" href="{{ asset('useluminii/assets/css/main.css') }}">

    <!-- ========== Toastr Notifications ========== -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- ========== Additional Head Scripts Stack ========== -->
    @stack('head-styles')

    <!-- ========== Structured Data (JSON-LD Schema) ========== -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "useLuminii",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "Web",
      "offers": {
        "@type": "Offer",
        "price": "350.00",
        "priceCurrency": "ZAR",
        "priceValidUntil": "2025-12-31"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "reviewCount": "127"
      },
      "description": "All-in-one business management system for service providers. Manage leads, quotes, jobs, invoices, and payments seamlessly.",
      "featureList": [
        "Lead Generation & Management",
        "Automated Quote Generation",
        "Job Scheduling & Tracking",
        "Invoice Automation",
        "Payment Processing",
        "Team Management",
        "Expense Tracking",
        "Reporting & Analytics"
      ],
      "screenshot": "{{ asset('useluminii/assets/images/thumbs/hero.png') }}",
      "url": "{{ url('/') }}",
      "creator": {
        "@type": "Organization",
        "name": "useLuminii"
      }
    }
    </script>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "useLuminii",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('useluminii/assets/images/logo/footer_logo.png') }}",
      "description": "Business management platform designed for service providers and growing businesses",
      "sameAs": [
        "https://www.facebook.com/useluminii",
        "https://www.linkedin.com/company/useluminii",
        "https://twitter.com/useluminii"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "contactType": "Customer Service",
        "email": "support@useluminii.com",
        "availableLanguage": ["English"]
      },
      "address": {
        "@type": "PostalAddress",
        "addressCountry": "ZA"
      }
    }
    </script>

    @yield('schema')

    <!-- ========== Google Analytics (Replace with your GA4 ID) ========== -->
    @if(app()->environment('production'))
    <!-- Google tag (gtag.js) -->
    {{-- Uncomment and add your Google Analytics 4 Measurement ID --}}
    {{--
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-XXXXXXXXXX');
    </script>
    --}}

    {{-- Google Tag Manager (Optional) --}}
    {{--
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-XXXXXXX');</script>
    --}}
    @endif

    @stack('head-scripts')

</head>
<body>

<!-- Google Tag Manager (noscript) - Optional -->
@if(app()->environment('production'))
{{--
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
--}}
@endif

@include("partials.useluminii_header")

@yield('content')

@include("partials.useluminii_footer")

<!-- ========== Jquery ========== -->
<script src="{{ asset('useluminii/assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- ========== Phosphor Icons ========== -->
<script src="{{ asset('useluminii/assets/js/phosphor-icon.js') }}"></script>

<!-- ========== Bootstrap Bundle ========== -->
<script src="{{ asset('useluminii/assets/js/boostrap.bundle.min.js') }}"></script>

<!-- ========== GSAP Animation ========== -->
<script src="{{ asset('useluminii/assets/js/gsap.min.js') }}"></script>
<script src="{{ asset('useluminii/assets/js/ScrollTrigger.min.js') }}"></script>
<script src="{{ asset('useluminii/assets/js/ScrollSmoother.min.js') }}"></script>
<script src="{{ asset('useluminii/assets/js/SplitText.min.js') }}"></script>
<script src="{{ asset('useluminii/assets/js/custom-gsap.js') }}"></script>

<!-- ========== AOS Animation ========== -->
<script src="{{ asset('useluminii/assets/js/aos.js') }}"></script>

<!-- ========== Counter Up ========== -->
<script src="{{ asset('useluminii/assets/js/counterup.min.js') }}"></script>

<!-- ========== Swiper Slider ========== -->
<script src="{{ asset('useluminii/assets/js/swiper-bundle.min.js') }}"></script>

<!-- ========== Marquee ========== -->
<script src="{{ asset('useluminii/assets/js/jquery.marquee.min.js') }}"></script>

<!-- ========== Magnific Popup ========== -->
<script src="{{ asset('useluminii/assets/js/magnific-popup.min.js') }}"></script>

<!-- ========== Main JS ========== -->
<script src="{{ asset('useluminii/assets/js/main.js') }}"></script>

<!-- ========== Toastr JS ========== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- ========== Toastr Flash Messages ========== -->
<script>
    @if(session('success'))
    toastr.success("{{ session('success') }}");
    @elseif(session('error'))
    toastr.error("{{ session('error') }}");
    @elseif(session('warning'))
    toastr.warning("{{ session('warning') }}");
    @elseif(session('info'))
    toastr.info("{{ session('info') }}");
    @endif
</script>

<!-- ========== Smooth Scroll for Anchor Links ========== -->
<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            if (window.location.pathname === "/") {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
</script>

<!-- ========== Additional Body Scripts Stack ========== -->
@stack('body-scripts')

</body>
</html>
