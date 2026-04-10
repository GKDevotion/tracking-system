 @extends('frontend.layout')

 @section('content') 

  <!-- Page Header Start -->
    <div class="page-header bg-section parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="wow fadeInUp" data-cursor="-opaque">Terms & <span>Conditions</span></h1>
                        <nav class="wow fadeInUp" data-wow-delay="0.2s">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <style>
        /* HERO SECTION */

        .hero {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: white;
            padding: 120px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
        }

        .hero p {
            opacity: .8;
        }

        /* GLASS CARD */

        .terms-card {
            background: #f4f7fb;
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 35px;
            margin-bottom: 30px;
            transition: .4s;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .terms-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        /* SECTION NUMBER */

        .section-number {
            font-size: 28px;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 10px;
        }

        /* HEADINGS */

        h2 {
            font-weight: 600;
            font-size: 22px;
        }

        /* LIST */

        ul {
            padding-left: 18px;
        }

        ul li {
            margin-bottom: 8px;
        }

        /* SCROLL ANIMATION */

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all .6s ease;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <section class="py-5">
        <div class="container">

            <div class="terms-card fade-in">
                <div class="section-number">1.</div>
                <h2>Acceptance of Terms</h2>
                <p>
                    These Terms and Conditions govern your access to and use of the services, content,
                    and digital platforms operated under Wealthora.
                    By accessing, browsing, subscribing, or otherwise using the platform,
                    you agree to comply with these Terms and Conditions.
                </p>
            </div>

            <div class="terms-card fade-in">
                <div class="section-number">2.</div>
                <h2>Description of Services</h2>

                <p>Wealthora provides educational insights related to financial markets including:</p>

                <ul>
                    <li>Educational content related to financial markets</li>
                    <li>Market analysis and commentary</li>
                    <li>Structured trade setups and analytical insights</li>
                    <li>Subscription-based trading signals</li>
                    <li>Portfolio planning perspectives</li>
                    <li>Community learning environments</li>
                </ul>

                <p>All information is provided strictly for educational and informational purposes.</p>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">3.</div>
                <h2>User Eligibility</h2>

                <p>
                    By accessing Wealthora services, you confirm that you are legally capable
                    of entering into binding agreements in your jurisdiction.
                </p>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">4.</div>
                <h2>No Personalized Advice</h2>

                <p>
                    Information and analysis provided by Wealthora are general in nature
                    and should not be interpreted as financial or investment advice.
                    Users are responsible for evaluating all information independently.
                </p>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">5.</div>
                <h2>Subscription Services</h2>

                <ul>
                    <li>Premium services may require paid subscriptions.</li>
                    <li>Access is limited to the active subscription period.</li>
                    <li>Subscription content cannot be redistributed.</li>
                </ul>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">6.</div>
                <h2>Payment Terms</h2>

                <p>
                    Payments for digital services may be non-refundable once platform
                    access has been granted unless otherwise stated.
                </p>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">7.</div>
                <h2>User Conduct</h2>

                <ul>
                    <li>Do not copy or distribute proprietary content</li>
                    <li>Do not share subscription information</li>
                    <li>Do not harm the platform or community</li>
                </ul>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">8.</div>
                <h2>Intellectual Property Rights</h2>

                <p>
                    All Wealthora content including analysis, trading insights, graphics,
                    branding, and educational materials remain the property of Wealthora.
                </p>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">9.</div>
                <h2>Platform Availability</h2>

                <p>
                    Wealthora strives to maintain uninterrupted access,
                    but availability cannot always be guaranteed.
                </p>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">10.</div>
                <h2>Limitation of Liability</h2>

                <p>
                    Wealthora shall not be liable for any losses resulting from the use
                    of the information or services provided through the platform.
                </p>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">11.</div>
                <h2>Indemnification</h2>

                <p>
                    Users agree to indemnify and hold harmless Wealthora
                    from any claims arising from their use of the platform.
                </p>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">12.</div>
                <h2>Amendments</h2>

                <p>
                    Wealthora may update these Terms and Conditions at any time.
                    Changes become effective immediately upon publication.
                </p>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">13.</div>
                <h2>Termination of Access</h2>

                <p>
                    Access may be restricted or terminated if users violate these terms
                    or compromise the platform integrity.
                </p>

            </div>

            <div class="terms-card fade-in">
                <div class="section-number">14.</div>
                <h2>Contact Information</h2>

                <p>
                    For inquiries regarding these Terms & Conditions,
                    please contact Wealthora through the official platform channels.
                </p>

            </div>

        </div>
    </section>


 @endsection