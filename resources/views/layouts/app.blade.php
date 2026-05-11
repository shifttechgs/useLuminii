<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="author" content="useLuminii">

    <title>@yield('title', 'useLuminii — Business Management for Service Businesses')</title>

    <meta name="description" content="@yield('description', 'Stop losing leads. Start closing jobs. useLuminii captures enquiries, sends quotes, manages jobs, and collects payments — all automated.')">
    <meta name="keywords" content="@yield('keywords', 'business management software, CRM for contractors, job scheduling, invoice automation, South Africa')">
    <meta name="robots" content="@yield('robots', 'index, follow')">

    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'useLuminii — Business Management System')">
    <meta property="og:description" content="@yield('og_description', 'From first enquiry to final payment — fully automated.')">
    <meta property="og:image" content="@yield('og_image', asset('useluminii/assets/images/logo/og-image.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="useLuminii">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'useLuminii — Business Management System')">
    <meta name="twitter:description" content="@yield('twitter_description', 'From first enquiry to final payment — fully automated.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('useluminii/assets/images/logo/twitter-card.png'))">

    <link rel="icon" type="image/png" href="{{ asset('useluminii/assets/images/logo/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('useluminii/assets/images/logo/favicon.png') }}">
    <meta name="theme-color" content="#0A0A0A">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('useluminii/assets/css/bootstrap.min.css') }}">
    <!-- AOS -->
    <link rel="stylesheet" href="{{ asset('useluminii/assets/css/aos.css') }}">
    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    @stack('head-styles')
    @stack('head-scripts')
</head>
<body>

@include("components.navbar")

@yield('content')

@include("components.footer")

<!-- jQuery -->
<script src="{{ asset('useluminii/assets/js/jquery-3.7.1.min.js') }}"></script>
<!-- Phosphor Icons -->
<script src="{{ asset('useluminii/assets/js/phosphor-icon.js') }}"></script>
<!-- Bootstrap Bundle -->
<script src="{{ asset('useluminii/assets/js/boostrap.bundle.min.js') }}"></script>
<!-- AOS -->
<script src="{{ asset('useluminii/assets/js/aos.js') }}"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 60 });

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

@stack('body-scripts')

</body>
</html>
