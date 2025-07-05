@extends("layouts.master")
@section("content")
<div class="main ">

    <section class="position-relative bg-image pt-100" image-overlay="10">
        <div class="background-image-wraper"></div>
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-10 col-lg-6">
                    <div class="hero-slider-content text-white py-5">
                        <h1 class="text-white">All-in-One Job Management System.</h1>
                        <p class="lead">Effortlessly manage leads,quotes, jobs, invoices and scheduling – all in one place.</p>
                        <div class="action-btns mt-3">
                            <div class="action-btns mt-3">
                                <a href="#" class="btn btn-brand-01">Join Waiting List</a>
{{--                                <a href="#" class="btn btn-primary">Join Waiting List</a>--}}
                                <a href="#" class="btn btn-brand-01">Request Call Back</a>
                            </div>
                        </div>
{{--                        <div class="col-md-6 col-lg-5">--}}
{{--                            <form class="newsletter-form position-relative">--}}
{{--                                <input type="text" class="input-newsletter form-control" placeholder="Enter your email" name="email" required="" autocomplete="off">--}}
{{--                                <button type="submit" class="disabled"><i class="fas fa-paper-plane"></i></button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
                        <p class=""> Access all features. No credit card required.</p>

                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div class="hero-image-wrap">
                        <div class="content-img-wrap">
                            <img class="fancy-radius-1 hero-img-width img-custom-width img-fluid gray-light-bg z--1" src="assets/img/phone-with-men.png" alt="modern desk">
                            <div class="position-absolute dot-shape">
                                <img src="assets/img/dot-shape.png" alt="appdash">
                            </div>
                            <div class="animation-item d-none d-md-block d-lg-block">
                                <div class="position-absolute rounded-custom d-flex bg-white hero-animated-card-4">
                                    <img src="assets/img/invoice.png" alt="widget" class="rounded-custom img-fluid">
                                </div>
                                <div class="position-absolute p-4 w-75 rounded-custom d-flex bg-white hero-animated-card-1">
                                    <p class="gr-text-11 mb-0 text-mirage-2">"Invoicing—all in one intuitive dashboard. It has truly improved our efficiency!”</p>
                                    <div class="small-card-img ml-3">
                                        <img src="assets/img/client/3.jpg" alt="" width="80px" class="rounded-circle img-fluid">
                                    </div>
                                </div>
                                <div class="position-absolute hero-animated-card-3">
                                    <img src="assets/img/custom-shape.svg" alt="shape">
                                </div>
                                <div class="position-absolute p-4 w-75 rounded-custom d-flex secondary-bg hero-animated-card-2">
                                    <div class="small-card-img mr-3 text-white">
                                        <img src="assets/img/client/1.jpg" alt="" width="80px" class="rounded-circle img-fluid">
                                    </div>
                                    <p class="gr-text-11 mb-0 text-white">“I can track everything in one place and focus on growing my business.”</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>

    </section>
      <!--pain points section start-->
    <section id="about" class="promo-section  ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="section-heading text-center">
                        <h2>Running a business is hard. Managing it shouldn’t be.</h2>
{{--                        <p>Our system automates and streamlines your workflow, saving time and boosting efficiency. </p>--}}
                    </div>
                </div>
            </div>
            <div class="row justify-content-md-center justify-content-sm-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card single-pricing-pack mt-4">
                        <div class="row g-0 align-items-center">
                            <div class="col-12 ">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-cubes icon-size-lg color-primary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Win More Jobs, Effortlessly</h5>
                                        <p class="mb-0">Stay connected with your customers anytime, whether you're in the field or at the office. Luminii streamlines lead management, quotes, invoices, and tasks—all in one place—so you never miss an opportunity.</p>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card single-pricing-pack mt-4">
                        <div class="row g-0 align-items-center">
                            <div class="col-12 ">
                                <div class="card-body">
                                    <div class="pb-2">
                                        <span class="fas fa-lock icon-size-lg color-primary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>More Jobs, Done Right</h5>
                                        <p class="mb-0">Juggling multiple tasks can slow you down. Luminii helps you streamline workflows, assign tasks efficiently, and keep your team on track—so every job gets done right, on time, every time.</p>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card single-pricing-pack mt-4">
                        <div class="row g-0 align-items-center">
                            <div class="col-12 ">
                                <div class="card-body">
                                    <div class="pb-2">

                                        <span class="fas fa-headset icon-size-lg color-primary"></span>
                                    </div>
                                    <div class="pt-2 pb-3">
                                        <h5>Deliver Stand-Out Service</h5>
                                        <p class="mb-0">Keep your customers in the loop at every step with automated emails and SMS updates. Stand out with one-click quote approvals and seamless in-app payment options, making their experience effortless and professional.</p>

                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--pain points section end-->


    <!--features section start-->
    <section id="features"  class="feature-section ptb-100 gray-light-bg ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-9">
                    <div class="section-heading text-center mb-5">
                        <h2>The features you need. All in one place.</h2>
                        <p>Luminii digitizes and optimizes your entire operation—from the moment a customer reaches out to when they make their payment—streamlining every step for maximum efficiency and seamless service.</p>

                    </div>
                </div>
            </div>



            <div class="row">
                <!-- First row (2 cards on top) -->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card single-pricing-pack mt-4">
                        <div class="row g-0 align-items-center">

                            <div class="col-12 col-md-6">
                                <div class="card-body">
                                    <a href="#">
                                        <h3 class="card-title h5">Leads, Quotes & Invoice Management</h3>
                                    </a>
                                    <p class="card-text mb-4">Streamline your workflow by managing leads, quotes, and invoices in one place.</p>
{{--                                     <a href="#" class="btn btn-outline-secondary">Read More</a>--}}


                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <img src="assets/img/blog/blog-1.jpg" class="card-img rounded-left" alt="Our office">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card single-pricing-pack mt-4">
                        <div class="row g-0 align-items-center">

                            <div class="col-12 col-md-6">
                                <div class="card-body">

                                    <a href="#">
                                        <h3 class="card-title h5">Billing and Payments</h3>
                                    </a>
                                    <p class="card-text mb-4">Simplify your billing process with automated invoicing, payments, and tax calculations.</p>
{{--                                     <a href="#" class="btn btn-outline-secondary">Read More</a>--}}

                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <img src="assets/img/blog/blog-2.jpg" class="card-img rounded-left" alt="Google Office">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second row (3 cards below) -->
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="card single-pricing-pack mt-4">
                        <div class="row g-0 align-items-center">
                            <div class="col-12 ">
                                <div class="card-body">
                                    <a href="#">
                                        <h3 class="card-title h5">Job Cards Management</h3>
                                    </a>
                                    <p class="card-text mb-4">Effortlessly manage tasks with job cards that track progress and assign responsibilities.</p>
{{--                                     <a href="#" class="btn btn-outline-secondary">Read More</a>--}}
                                </div>
                            </div>

                        </div>
                        <div class="col-12 d-flex justify-content-center align-items-end">
                            <img src="assets/img/invoice.png" class="card-img rounded-bottom" alt="Google Office" style="max-width: 90%; max-height: 50%;">
                        </div>


                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-4">
                    <div class="card single-pricing-pack mt-4" >
                        <div class="row g-0 align-items-center">
                            <div class="col-12 ">
                                <div class="card-body">
                                    <a href="#">
                                        <h3 class="card-title h5">Client Hub</h3>
                                    </a>
                                    <p class="card-text mb-4">Your customer's online portal to request work, approve quotes, review jobs, make payments, and refer friends.</p>
{{--                                    <a href="#" class="btn btn-brand-01">Explore Hub</a>--}}
{{--                                    <a href="#" class="btn btn-outline-secondary">Explore Hub</a>--}}
                                </div>
                            </div>

                        </div>
                        <div class="col-12 d-flex justify-content-center align-items-end">
                            <img src="assets/img/blog/blog-2.jpg" class="card-img rounded-bottom" alt="Google Office" style="max-width: 90%; max-height: 50%;">
                        </div>

                    </div>
                </div>


                <div class="col-12 col-md-4 col-lg-4">
                    <div class="card single-pricing-pack mt-4 " style="height:  511px;">
                        <div class="row g-0 align-items-center">
                            <div class="col-12">
                                <div class="card-body">
                                    <!-- Logo at the top left -->
                                    <div class="d-flex justify-content-start mb-4">
                                        <div class="pb-2">
                                            <span class="fas fa-cubes icon-size-lg color-primary"></span>
                                        </div>
                                    </div>

                                    <a href="#">
                                        <h3 class="card-title h5">More Features</h3>
                                    </a>

                                    <!-- List with forward arrow -->
                                    <ul class="check-list-wrap list-two-col py-3">
                                        <li>Reporting</li>
                                        <li> Payroll</li>
                                        <li> Expenses</li>
                                        <li> Estimates</li>
                                        <li> Inventory</li>
                                        <li> Mobile</li>
                                        <li> Clients</li>
                                        <li> AI Integrations</li>
                                        <li> Team Management</li>
                                        <li> Service Management</li>


                                    </ul>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </section>
    <!--features section end-->
    <!--video with download start-->
    <section class="position-relative overflow-hidden ptb-100">
        <div class="mask-65"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <div class="section-heading text-center  text-white">
                        <h2 class="text-white">Use Lumini<span style="color: rgb(255 196 20);">i</span> your way</h2>
                        <p>Simplify Lead Management, Streamline Quotes & Invoices, and Take Control of Your Business Operations.</p>
                    </div>
                    <div class="video-promo-content my-5 pb-4">
                        <a href="https://www.youtube.com/watch?v=9No-FiEInLA" class="popup-youtube video-play-icon text-center m-auto"><span class="ti-control-play"></span> </a>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            <div class="container mt-4">
                <div class="card single-promo-card shadow p-4">
                    <div class="row justify-content-center text-center">
                        <!-- Column 1 -->
                        <div class="col-md-3 d-flex flex-column align-items-center text-center">
                            <h5>Freelancers</h5>
                            <p class="text-center">Stay on top of job management, keep clients satisfied, and streamline your workflow with ease.</p>
{{--                            <a href="#" class="btn btn-outline-secondary">Start Now</a>--}}

                        </div>

                        <!-- Divider -->
                        <div class="col-md-1 d-none divider d-md-block border-end"></div>

                        <!-- Column 2 -->
                        <div class="col-md-3 d-flex flex-column align-items-center text-center">
                            <h5>Solopreneurs</h5>
                            <p class="text-center">Get the tools to scale your business efficiently and manage projects effortlessly.</p>
{{--                            <a href="#" class="btn btn-outline-secondary">Start Now</a>--}}
                        </div>

                        <!-- Divider -->
                        <div class="col-md-1 d-none divider d-md-block border-end"></div>

                        <!-- Column 3 -->
                        <div class="col-md-3 d-flex flex-column align-items-center text-center">
                            <h5>Enterprises</h5>
                            <p class="text-center">Optimize workflow, enhance collaboration, and drive business growth with advanced solutions.</p>
{{--                            <a href="#" class="btn btn-outline-secondary">Start Now</a>--}}
                        </div>


                            <div class="action-btns mt-3">
                                <a href="#" class="btn btn-outline-secondary" >Join Waiting List</a>

                                {{--                                    <a href="#" class="btn btn-outline-secondary">Book a Demo</a>--}}
                                <a href="#" class="btn btn-outline-secondary">Request Call Back</a>
                            </div>

                    </div>

                </div>
            </div>


        </div>
    </section>
    <!--video with download end-->
    <!--testimonial section start-->
    <section class="review-section  ptb-100 gray-light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <div class="section-heading text-center mb-4">
{{--                        <h6 class="text-uppercase color-accent mb-1">Client Review</h6>--}}
                        <h2>What People Are Saying About Lumini<span style="color: rgb(255 196 20);">i</span></h2>
                        <p>
                            Professional, affordable solutions that streamline our business operations. Luminii’s approach focuses on delivering client-centered solutions with exceptional value.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel owl-theme client-testimonial-2 dot-indicator">
                        <div class="item">
                            <div class="single-review-wrap gray-light-bg p-5 my-3">
                                <div class="review-top d-flex align-items-center justify-content-between mb-3">
                                    <div class="review-author d-flex align-items-center">
                                        <img src="assets/img/client/2.jpg" width="50" alt="author" class="rounded-circle border shadow-sm img-fluid mr-3" />
                                        <div class="review-info">
                                            <h6 class="mb-0">Sophia T</h6>
                                            <span>Business Consultant</span>
                                        </div>
                                    </div>
                                    <span><i class="fas fa-quote-left icon-size-md color-primary"></i></span>
                                </div>
                                <div class="review-body">
                                    <p class="mb-0">Luminii brings everything together—job tracking, client management, and invoicing—all in one intuitive dashboard. It has truly improved our efficiency!</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="single-review-wrap gray-light-bg p-5 my-3">
                                <div class="review-top d-flex align-items-center justify-content-between mb-3">
                                    <div class="review-author d-flex align-items-center">
                                        <img src="assets/img/client/1.jpg" width="50" alt="author" class="rounded-circle border shadow-sm img-fluid mr-3" />
                                        <div class="review-info">
                                            <h6 class="mb-0"> David L</h6>
                                            <span>Freelancer</span>
                                        </div>
                                    </div>
                                    <span><i class="fas fa-quote-left icon-size-md color-primary"></i></span>
                                </div>
                                <div class="review-body">
                                    <p class="mb-0">This platform is a game-changer for freelancers and agencies. It keeps our workflow organized, ensures timely invoicing, and helps us close more deals effortlessly!</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="single-review-wrap gray-light-bg p-5 my-3">
                                <div class="review-top d-flex align-items-center justify-content-between mb-3">
                                    <div class="review-author d-flex align-items-center">
                                        <img src="assets/img/client/3.jpg" width="50" alt="author" class="rounded-circle border shadow-sm img-fluid mr-3" />
                                        <div class="review-info">
                                            <h6 class="mb-0">Emily R </h6>
                                            <span>Small Business Owner</span>
                                        </div>
                                    </div>
                                    <span><i class="fas fa-quote-left icon-size-md color-primary"></i></span>
                                </div>
                                <div class="review-body">
                                    <p class="mb-0">Managing leads and invoices used to be a headache, but Luminii made it seamless. Now, I can track everything in one place and focus on growing my business.</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="single-review-wrap gray-light-bg p-5 my-3">
                                <div class="review-top d-flex align-items-center justify-content-between mb-3">
                                    <div class="review-author d-flex align-items-center">
                                        <img src="assets/img/client/4.jpg" width="50" alt="author" class="rounded-circle border shadow-sm img-fluid mr-3" />
                                        <div class="review-info">
                                            <h6 class="mb-0">Mark S</h6>
                                            <span> Operations Manager</span>
                                        </div>
                                    </div>
                                    <span><i class="fas fa-quote-left icon-size-md color-primary"></i></span>
                                </div>
                                <div class="review-body">
                                    <p class="mb-0">Luminii has completely streamlined our job management process. Tracking tasks, assigning work, and staying on top of deadlines has never been easier!"
                                       </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--testimonial section end-->
    <!-- why choose us section -->

    <section class="promo-section ptb-100  ">
        <div class="container">

            <div class="row justify-content-md-center justify-content-sm-center">
                <div class="col-md-6 col-lg-7">
                    <div class="card border-0 single-promo-card single-pricing-pack  text-center p-2 mt-4" style=" height: 222px;     background: #f5f5f5;">
                        <div class="card-body">
                            <div class="pb-2">
{{--                                <span class="fas fa-cogs icon-size-lg color-primary"></span>--}}
                            </div>
                            <div class="pt-2 pb-3">
                                <h3>More Reasons To Choose lumini<span style="color: rgb(255 196 20);">i</span></h3>
                                <div class="action-btns mt-3">
                                    <a href="#" class="btn btn-outline-secondary" >Join Waiting List</a>

                                    {{--                                    <a href="#" class="btn btn-outline-secondary">Book a Demo</a>--}}
                                    <a href="#" class="btn btn-outline-secondary">Request Call Back</a>
                                </div>
                            </div>
                        </div>
                    </div>

                        </div>

                <div class="col-md-6 col-lg-5">
                    <div class="card border-0 single-promo-card single-pricing-pack text-center p-2 mt-4" style=" height: 222px">
                        <div class="card-body">
                            <div class="pb-2">
                                <span class="fas fa-chart-line icon-size-lg color-primary"></span>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5>Data-Driven Insights</h5>
                                <p class="mb-0">Make informed decisions with real-time analytics and performance tracking.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 single-promo-card single-pricing-pack text-center p-2 mt-4">
                        <div class="card-body">
                            <div class="pb-2">
                                <span class="fas fa-shield-alt icon-size-lg color-primary"></span>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5>Security First</h5>
                                <p class="mb-0">Your data is safe with us—our platform is built with robust security features to protect your business.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 single-promo-card single-pricing-pack text-center p-2 mt-4">
                        <div class="card-body">
                            <div class="pb-2">
                                <span class="fas fa-headset icon-size-lg color-primary"></span>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5>24/7 Support</h5>
                                <p class="mb-0">Our dedicated support team is always here to help you with any questions or issues.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 single-promo-card single-pricing-pack text-center p-2 mt-4">
                        <div class="card-body">
                            <div class="pb-2">
                                <span class="fas fa-rocket icon-size-lg color-primary"></span>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5>Scalable Growth</h5>
                                <p class="mb-0">Whether you're a small business or a growing enterprise, luminii scales with your needs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Why choose us section end-->

    <!--pricing section start-->
    <section id="pricing" class="pricing-section ptb-100 gray-light-bg ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <div class="section-heading text-center mb-4">
                        <h2>Flexible Plans for Every Business</h2>
                        <p>
                            Choose from free trial, monthly plans, or custom enterprise solutions.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-md-center justify-content-center">
                <div class="col-12">
                    <div class="d-flex justify-content-center text-center">
                        <label class="pricing-switch-wrap">
                                <span class="beforeinput year-switch text-success">
                                Monthly
                            </span>
                            <input type="checkbox" class="d-none" id="js-contcheckbox">
                            <span class="switch-icon"></span>
                            <span class="afterinput year-switch">
                                    Yearly
                            </span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="text-center bg-white single-pricing-pack mt-4">
                        <div class="price-img pt-4">
                            <img src="assets/img/priching-img-1.png" alt="price" width="120" class="img-fluid">
                        </div>
                        <div class="py-4 border-0 pricing-header">
                            <div class="price text-center mb-0 monthly-price color-secondary" style="display: block;">R190<span>.99</span></div>
                            <div class="price text-center mb-0 yearly-price color-secondary" style="display: none;">R699<span>.99</span></div>
                        </div>
                        <div class="price-name">
                            <h5 class="mb-0">Starter Plan</h5>
                        </div>
                        <div class="pricing-content">
                            <ul class="list-unstyled mb-4 pricing-feature-list">
                                <li><span>Limited</span> access for a month</li>
                                <li><span>15</span> customize sub page</li>
                                <li class="text-deem"><span>105</span> disk space</li>
                                <li class="text-deem"><span>3</span> domain access</li>
                                <li class="text-deem">24/7 phone support</li>
                            </ul>
                            <a href="#" class="btn btn-outline-secondary">Start Now</a>

                            {{--                                <a href="#" class="btn btn-primary">Join Waiting List</a>--}}
{{--                            <a href="#" class="btn btn-outline-secondary">Start Now</a>--}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="popular-price bg-white text-center single-pricing-pack mt-4">
                        <div class="price-img pt-4">
                            <img src="assets/img/priching-img-2.png" alt="price" width="120" class="img-fluid">
                        </div>
                        <div class="py-4 border-0 pricing-header">
                            <div class="price text-center mb-0 monthly-price color-secondary" style="display: block;">R350<span>.99</span></div>
                            <div class="price text-center mb-0 yearly-price color-secondary" style="display: none;">R850<span>.99</span></div>
                        </div>
                        <div class="price-name">
                            <h5 class="mb-0">Professional Plan</h5>
                        </div>
                        <div class="pricing-content">
                            <ul class="list-unstyled mb-4 pricing-feature-list">
                                <li><span>Unlimited</span> access for a month</li>
                                <li><span>25</span> customize sub page</li>
                                <li><span>150</span> disk space</li>
                                <li class="text-deem"><span>5</span> domain access</li>
                                <li class="text-deem">24/7 phone support</li>
                            </ul>
                            <a href="#" class="btn btn-brand-01">Start Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="text-center bg-white single-pricing-pack mt-4">
                        <div class="price-img pt-4">
                            <img src="assets/img/priching-img-3.png" alt="price" width="120" class="img-fluid">
                        </div>
                        <div class="py-4 border-0 pricing-header">
                            <div class="price text-center mb-0 monthly-price color-secondary" style="display: block;">R650<span>.99</span></div>
                            <div class="price text-center mb-0 yearly-price color-secondary" style="display: none;">R1350<span>.99</span></div>
                        </div>
                        <div class="price-name">
                            <h5 class="mb-0">Enterprise Plan</h5>
                        </div>
                        <div class="pricing-content">
                            <ul class="list-unstyled mb-4 pricing-feature-list">
                                <li><span>Limited</span> access for a month</li>
                                <li><span>15</span> customize sub page</li>
                                <li><span>120</span> disk space</li>
                                <li><span>5</span> domain access</li>
                                <li>24/7 phone support</li>
                            </ul>
                            <a href="#" class="btn btn-outline-secondary">Start Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="support-cta text-center mt-5">
                        <h5 class="mb-1"><span class="ti-headphone-alt color-primary mr-3"></span>We're Here to Help You
                        </h5>
                        <p>Have some questions? <a href="#">Chat with us now</a>, or <a href="#">send us an email</a> to
                            get in touch.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--pricing section end-->





    <section id="faq" class="ptb-100 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12">
                    <div class="section-heading text-center mb-5">
                        <h2>Frequently Asked Questions</h2>
                        <p>Unlock reliable solutions and streamline your processes with ease. Have more questions? We're here to help – feel free to contact us!</p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">

                <div class="col-md-12 col-lg-12">
                    <div id="accordion" class="accordion faq-wrap">
                        <!-- FAQ 1 -->
                        <div class="card mb-3">
                            <a class="card-header " data-toggle="collapse" href="#collapse0" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">What do I get in my 30-day free trial of Luminii?</h6>
                            </a>
                            <div id="collapse0" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>During your 30-day trial, you’ll get full access to all Luminii features—everything you need to streamline your job management, track tasks, and collaborate with your team. From task assignment to project timelines and client management, experience the full power of Luminii to optimize your operations. After the trial, you’ll have the option to choose the plan that best fits your business needs.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse1" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">Which Luminii plan is right for me?</h6>
                            </a>
                            <div id="collapse1" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>We offer various plans tailored to businesses of all sizes. Whether you're a freelancer, a solopreneur, or a growing company with employees or contractors, there’s a plan designed to help you succeed. Choose the plan that aligns with your business size and feature requirements.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">What is job management software?</h6>
                            </a>
                            <div id="collapse2" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>Job management software is a tool designed to help businesses track, manage, and organize tasks, projects, and teams. It streamlines workflow, improves communication, and boosts efficiency across your operations. Luminii is the all-in-one solution for managing your business’ job-related tasks.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 4 -->
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse3" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">How does Luminii work?</h6>
                            </a>
                            <div id="collapse3" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>Luminii helps you manage tasks, track progress, and communicate with your team all in one platform. From setting up projects to creating job orders and managing client relationships, Luminii streamlines your daily operations, allowing you to stay on top of everything, efficiently and seamlessly.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 5 -->
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse4" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">Does Luminii work on all of my devices?</h6>
                            </a>
                            <div id="collapse4" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>Yes! Luminii is fully responsive and works seamlessly across desktop, tablet, and mobile devices. Access your job management tools anywhere, anytime, to stay productive on the go.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 6 -->
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse5" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">Does Luminii offer customer support?</h6>
                            </a>
                            <div id="collapse5" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>Absolutely! Luminii provides comprehensive customer support via email, chat, and phone. Our team is here to assist you with any questions or technical issues you may have.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 7 -->
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse6" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">How do I collaborate with my team using Luminii?</h6>
                            </a>
                            <div id="collapse6" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>Luminii makes team collaboration easy with its intuitive interface. You can assign tasks, set deadlines, track progress, and share updates—all in real time. Stay connected with your team and keep everyone on the same page, no matter where they are.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 8 -->
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse7" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">Can Luminii help me transfer my data?</h6>
                            </a>
                            <div id="collapse7" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>Yes, we offer data migration support to help you seamlessly transition from your current system to Luminii. Our team will guide you through the process to ensure that your data is accurately transferred and fully integrated into your Luminii account.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


</div>

@endsection
