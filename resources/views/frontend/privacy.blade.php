 @extends('frontend.layout')

 @section('content') 

 <!-- Page Header Start -->
    <div class="page-header bg-section parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="wow fadeInUp" data-cursor="-opaque">Privacy <span>Policy</span></h1>
                        <nav class="wow fadeInUp" data-wow-delay="0.2s">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
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
        /* HERO */

        .hero {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 120px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
        }

        .hero p {
            opacity: .85;
        }

        /* CARD */

        .policy-card {
            background: white;
            border-radius: 14px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            transition: .4s;
        }

        .policy-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
        }

        /* TEXT */

        p {
            color: #555;
            line-height: 1.7;
        }

        ul {
            padding-left: 18px;
        }

        ul li {
            margin-bottom: 8px;
        }

        /* FADE */

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: .6s ease;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <section class="py-5">

        <div class="container">

            <!-- Information We Collect -->

            <div class="policy-card fade-in">
                <h4>Information We Collect</h4>
                <p>
                    When users interact with the <strong>Wealthora platform</strong>, we may collect certain
                    basic personal information such as name, email address, contact details,
                    and account or subscription information.
                </p>
                <p>
                    This information is collected solely to facilitate access to our services
                    and improve the functionality and experience of the platform.
                </p>
            </div>


            <!-- Use of Information -->

            <div class="policy-card fade-in">
                <h4>Use of Information</h4>
                <p>Information collected by Wealthora may be used for the following purposes:</p>
                <ul>
                    <li>Providing access to platform services and subscriptions</li>
                    <li>Communicating important updates or service-related information</li>
                    <li>Improving platform performance and user experience</li>
                    <li>Providing customer support when required</li>
                </ul>

                <p>
                    Wealthora does not sell, rent, or distribute personal information
                    to third parties unless required by applicable law.
                </p>

            </div>


            <!-- Data Protection -->

            <div class="policy-card fade-in">
                <h4>Data Protection</h4>
                <p>
                    Wealthora takes reasonable administrative and technical measures
                    to safeguard personal information and maintain the confidentiality
                    of user data.
                </p>

                <p>
                    While we strive to protect user information, no digital platform
                    can guarantee absolute security of data transmitted over the internet.
                </p>

            </div>


            <!-- Third Party Services -->

            <div class="policy-card fade-in">
                <h4>Third-Party Services</h4>
                <p>
                    In certain cases, Wealthora may utilize third-party tools or services
                    to support platform functionality.
                </p>

                <p>
                    These services may operate under their own privacy policies, and
                    users are encouraged to review the policies of any third-party
                    services they interact with through the platform.
                </p>

            </div>


            <!-- Updates -->

            <div class="policy-card fade-in">
                <h4>Updates to This Policy</h4>
                <p>
                    Wealthora reserves the right to update or modify this Privacy Policy
                    at any time. Any revisions will be published on this page.
                </p>

                <p>
                    By continuing to access or use Wealthora services, users acknowledge
                    and accept the terms outlined in this Privacy Policy.

                </p>

            </div>
        </div>

    </section>


 @endsection