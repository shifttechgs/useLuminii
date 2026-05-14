@extends("layouts.master")
@section("content")

    <!-- Hero -->
    <section style="background: linear-gradient(135deg, #123d33 0%, #123d33 100%); padding: 140px 0 100px;">
        <img src="assets/images/shapes/sqaure_shape.png"
             alt="Shape"
             class="position-absolute top-0 tw-end-0 tw-me-12-percent"
             style="filter: brightness(50%); opacity: 0.2;">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                <span class="d-inline-block tw-py-2 tw-px-4 rounded-pill text-white fw-medium tw-text-sm tw-mb-4" style="background: rgba(116, 184, 18, 0.2); border: 1px solid #74b812;">
                   Case study - Vision Plus Wealth
                </span>
                    <h1 style="color: white; font-size: 72px; line-height: 1.1; font-weight: 700; margin-bottom: 32px; letter-spacing: -0.03em;">
                        Redefining Vision Plus Wealth digital presence to match Series A momentum <span style="color: #74b812;">fast</span>
                    </h1>
                    <p style="color: rgba(255,255,255,0.7); font-size: 22px; line-height: 1.6; max-width: 680px;">
                        Most agencies talk about "digital transformation" and "synergies." We just ship great software. MVPs in weeks. Enterprise platforms that scale.
                    </p>
                </div>
            </div>
        </div>
    </section>



    <!-- ==================== CTA Section ==================== -->
    <section class="py-5" style="background: linear-gradient(135deg, #74b812 0%, #5a9a0a 100%);">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="text-white fw-bold tw-mb-3">Ready to transform your business?</h2>
                    <p class="text-white tw-mb-4" style="opacity: 0.9;">Book a free 30-minute discovery call. No commitment, just clarity.</p>
                    <a href="#contactForm" class="btn btn-lg text-dark fw-bold px-5 py-3" style="background: white; border-radius: 50px;">
                        Book Your Free Call <i class="ph-bold ph-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        @media (max-width: 768px) {
            section h1 {
                font-size: 42px !important;
            }
            section h2 {
                font-size: 36px !important;
            }
            section h3 {
                font-size: 24px !important;
            }
        }
    </style>

@endsection
