<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--favicon icon-->
    <link rel="icon" href="assets/img/favicon.png" type="image/png" sizes="16x16">

    <!--title-->
    <title>Luminii -  Landing Page </title>

    <!--build:css-->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- endbuild -->
</head>



<body>

@include("partials.header")


@yield('content')


@include("partials.footer")

<div class="scroll-top scroll-to-target primary-bg text-white" data-target="html">
    <span class="fas fa-hand-point-up"></span>
</div>
<!--scroll bottom to top button end-->
<!--build:js-->
<script src="assets/js/vendors/jquery-3.5.1.min.js"></script>
<script src="assets/js/vendors/popper.min.js"></script>
<script src="assets/js/vendors/bootstrap.min.js"></script>
<script src="assets/js/vendors/jquery.easing.min.js"></script>
<script src="assets/js/vendors/owl.carousel.min.js"></script>
<script src="assets/js/vendors/countdown.min.js"></script>
<script src="assets/js/vendors/jquery.waypoints.min.js"></script>
<script src="assets/js/vendors/jquery.rcounterup.js"></script>
<script src="assets/js/vendors/magnific-popup.min.js"></script>
<script src="assets/js/vendors/validator.min.js"></script>
<script src="assets/js/app.js"></script>



</body>

</html>
