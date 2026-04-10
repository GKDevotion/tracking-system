 @extends('frontend.layout')

 @section('content') 

   <!-- Page Header Start -->
    <div class="page-header bg-section parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="wow fadeInUp" data-cursor="-opaque">Cookie <span>Policy</span></h1>
                        <nav class="wow fadeInUp" data-wow-delay="0.2s">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Cookie Policy</li>
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

        .hero{
            background:linear-gradient(135deg,#283048,#859398);
            color:white;
            padding:120px 0;
            text-align:center;
        }

        .hero h1{
            font-size:48px;
            font-weight:700;
        }

        .hero p{
            opacity:.85;
        }

        /* CARD */

        .cookie-card{
            background:white;
            border-radius:14px;
            padding:35px;
            margin-bottom:30px;
            box-shadow:0 15px 40px rgba(0,0,0,0.08);
            transition:.4s;
        }

        .cookie-card:hover{
            transform:translateY(-8px);
            box-shadow:0 20px 45px rgba(0,0,0,0.15);
        }

        /* ICON */

        .section-icon{
            font-size:35px;
            color:#0d6efd;
            margin-bottom:15px;
        }

        /* TEXT */

        p{
            color:#555;
            line-height:1.7;
        }

        ul{
            padding-left:18px;
        }

        ul li{
            margin-bottom:8px;
        }

        /* FADE */

        .fade-in{
            opacity:0;
            transform:translateY(30px);
            transition:all .6s ease;
        }

        .fade-in.show{
            opacity:1;
            transform:translateY(0);
        }
    </style>

    <section class="py-5">

        <div class="container">

            <!-- Introduction -->

            <div class="cookie-card fade-section">
                <h4>Introduction</h4>

                <p>

                    This Cookie Policy explains how <strong>Wealthora</strong> uses cookies and similar
                    technologies when users access or interact with our website and digital services.

                </p>

                <p>

                    By continuing to use the Wealthora platform, you consent to the use
                    of cookies in accordance with this policy.

                </p>

            </div>


            <!-- What Are Cookies -->

            <div class="cookie-card fade-section">

                <h4>What Are Cookies</h4>

                <p>

                    Cookies are small text files stored on a user’s device when visiting a website.
                    They help websites function efficiently and enable features such as
                    user preferences, analytics, and improved browsing experience.

                </p>

            </div>


            <!-- How We Use Cookies -->

            <div class="cookie-card fade-section">

                <h4>How We Use Cookies</h4>

                <p>Wealthora may use cookies for the following purposes:</p>

                <ul>

                    <li>To ensure proper functionality of the website</li>

                    <li>To improve website performance and user experience</li>

                    <li>To understand how visitors interact with our platform</li>

                    <li>To maintain secure access to certain features or services</li>

                </ul>

                <p>

                    These cookies help us enhance the quality and usability of our services.

                </p>

            </div>


            <!-- Third Party Cookies -->

            <div class="cookie-card fade-section">
                <h4>Third-Party Cookies</h4>

                <p>

                    In some cases, Wealthora may use trusted third-party services such as
                    analytics tools that may place cookies on your device to help us
                    understand website traffic and usage patterns.

                </p>

                <p>

                    These services operate under their own privacy policies.

                </p>

            </div>


            <!-- Managing Cookies -->

            <div class="cookie-card fade-section">

                <h4>Managing Cookies</h4>

                <p>

                    Users can choose to accept or decline cookies through their browser settings.
                    Most web browsers allow users to control or disable cookies.

                </p>

                <p>

                    Please note that disabling certain cookies may affect the functionality
                    of some parts of the website.

                </p>

            </div>


            <!-- Updates -->

            <div class="cookie-card fade-section">

                <h4>Updates to This Policy</h4>

                <p>

                    Wealthora reserves the right to update or modify this Cookie Policy at any time.
                    Any updates will be published on this page.

                </p>

                <p>

                    By continuing to use the Wealthora platform, users acknowledge and accept
                    the use of cookies as described in this policy.

                </p>

            </div>

        </div>

    </section>


 @endsection