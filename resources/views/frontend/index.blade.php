@extends('frontend.layout')

@section('content')

    @include('frontend.element.home-slider-carousel')

    <div class="">
        <img src="{{url('storage/app/public/home-slider/website-08.jpg')}}" alt="Our Signals are Money Making Machine" class="img-fluid w-100" />
    </div>

    @include('frontend.element.blog')

    <!-- Start Analysis report -->
    <div class="our-empact d-none">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <!-- Our Impact Image Start -->
                    <div class="our-impact-image wow fadeInUp">
                        <!-- Impact Image Start -->
                        <div class="impact-image text-center">
                            <style>
                                .profit-header {
                                    background: #F0F2F4;
                                    border-radius: 25px;
                                    padding: 30px 40px;
                                    font-weight: bold;
                                    display: inline-block;
                                    font-size: 2rem;
                                }

                                .signal-count {
                                    font-size: 2rem;
                                    font-weight: bold;
                                    color: #004aad;
                                    margin-right: 40px;
                                }

                                .profit-percent {
                                    font-size: 2rem;
                                    font-weight: bold;
                                    color: #28a745;
                                }

                                .custom-card {
                                    border: 1px solid #000;
                                    border-radius: 20px;
                                    padding: 5px;
                                    margin: 5px;
                                }

                                .total-positive {
                                    color: #28a745;
                                    font-weight: bold;
                                }

                                .total-negative {
                                    color: red;
                                    font-weight: bold;
                                }

                                .negative-label {
                                    font-size: 12px;
                                    font-weight: 700;
                                    color: #999090;
                                }

                                .total-final {
                                    color: #004aad;
                                    font-weight: bold;
                                }

                                .custom-card td,
                                .custom-card th {
                                    border: 0;
                                    font-size: 12px;
                                    padding: 10px;
                                }

                                .custom-card tr {
                                    border-top: 0;
                                }

                                .tr-heading {
                                    border-bottom: 1px solid #000;
                                }

                                .custom-card th {
                                    border-top: 0;
                                    background-color: #fff;
                                }

                                .table-bordered>:not(caption)>* {
                                    border-width: inherit !important;
                                }
                            </style>

                            <!-- Table -->
                            <div class="custom-card">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle text-start mb-0"
                                        style="min-height: 550px;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <!-- Impact Body Item Start -->
                                                    <div class="impact-body-item box-bg-shape mt-0 w-100">
                                                        <h2 class="mt-3 mb-3">
                                                            <label>R</label>esult's You Can Track
                                                        </h2>
                                                        <p>Reach a global audience with voiceovers tailored</p>
                                                    </div>
                                                    <!-- Impact Body Item End -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Impact Image End -->
                    </div>
                    <!-- Our Impact Image End -->
                </div>
                <div class="col-lg-7">
                    <!-- Impact Content Start -->
                    <div class="impact-content">
                        <!-- Section Title Start -->
                        <div class="section-title mt-4">
                            <h3 class="wow fadeInUp">Our Analysis Report</h3>
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">
                                100% Transparent & Verified.
                            </h2>
                            <p class="wow fadeInUp fs-3" data-wow-delay="0.4s">
                                Every Win. Every Loss. Always Visible.
                            </p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Impact Body Start -->
                        <div class="impact-body">


                            <!-- Impact Body Item Start -->
                            <div class="impact-body-item box-bg-shape">
                                <h2 class="mt-3 mb-3">
                                    <label>R</label>esult's You Can Track
                                </h2>
                                <p>Reach a global audience with voiceovers tailored</p>
                            </div>
                            <!-- Impact Body Item End -->

                            <!-- Impact Body Item Start -->
                            <div class="impact-body-item box-bg-shape">
                                <h2 class="mt-4">
                                    <span class="counter">53.2</span>
                                    <label>%</label>
                                </h2>
                                <h3 class="fs-3">Last month Profit</h3>
                                <p class="mt-5">Reach a global audience with voiceovers tailored</p>
                            </div>
                            <!-- Impact Body Item End -->
                        </div>
                        <!-- Impact Body End -->

                    </div>
                    <!-- Impact Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Analysis Report -->

    <!-- Lunch Movement Animation -->
    <section class="section-cta pt-5">
        <div class="container">
            <div class="row text-center">
                <h2 class="wow fadeInUp text-black" style="font-size: 3rem;">Thousands Joined. <span
                        style="color: #46e546; font-size: 4rem; text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);">PROFIT</span>
                    Started</h2>
            </div>
        </div>

        <link href="{{ url('public/frontend/css/lottie.css') }}" rel="stylesheet" />
        <script src="{{ url('public/frontend/js/lottie.min.js') }}"></script>
        <div class="cta-background-wrap is-relative" style="margin-top: -70px;">

            <a href="#" target="_blank" class="main-button is-centered w-inline-block">
                <div class="button-text-wrap" style="display: block;">
                    <div class="btn-text text-white " style="font-weight: 800;">Today Signals</div>
                </div>
            </a>

            <!-- Desktop Animation -->
            <div id="lottie-desktop" class="lottie-animation"></div>

            <div class="overlay-left"></div>
            <div class="overlay-right"></div>

            <!-- Mobile Animation -->
            <div id="lottie-mobile" class="lottie-animation is-mobile"></div>

        </div>
        <script>
            // Desktop Lottie
            lottie.loadAnimation({
                container: document.getElementById('lottie-desktop'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: 'public/frontend/json/Landing_Page_Animation_Merge_Without_Text.json'
            });

            // Mobile Lottie
            lottie.loadAnimation({
                container: document.getElementById('lottie-mobile'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: 'public/frontend/json/Landing_Page_Animation_Merge_Without_Text.json'
            });
        </script>
    </section>
    <!-- End Lunch Movement Animation -->

    <!-- Page Pricing Start -->
    <div class="page-pricing">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <h3 class="wow fadeInUp">subscription plans</h3>
                        <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">
                            Choose Your Plan, Start <span>Profiting</span>
                        </h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Our Pricing Box Start -->
                    <div class="our-pricing-box wow fadeInUp" data-wow-delay="0.4s">
                        <div class="d-none our-pricing-swich form-check form-switch">
                            <label class="form-check-label" for="planToggle" id="toggleLabelMonthly">Monthly</label>
                            <span><input class="form-check-input" type="checkbox" id="planToggle"></span>
                            <label class="form-check-label" for="planToggle" id="toggleLabelAnnually">Annually</label>
                        </div>
                        <!-- Sidebar Our Pricing Nav End -->

                        <!-- Pricing Tab Item Start -->
                        <div class="pricing-tab-item d-none" id="monthly">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <!-- Pricing Box Start -->
                                    <div class="pricing-item">
                                        <!-- Pricing Header Start -->
                                        <div class="pricing-header">
                                            <h3>Starter Plan</h3>
                                            <h2>$39.00<sub>/Monthly</sub></h2>
                                        </div>
                                        <!-- Pricing Header End -->

                                        <!-- Pricing Item Content Start -->
                                        <div class="pricing-item-content">
                                            <p>Perfect for short videos, ads, or social media content.</p>
                                        </div>
                                        <!-- Pricing Item Content End -->

                                        <!-- Pricing body Start -->
                                        <div class="pricing-body">
                                            <h3>What's Included:</h3>
                                            <ul>
                                                <li>1 free revision</li>
                                                <li>Up to 150 words</li>
                                                <li>1 voice talent option</li>
                                            </ul>
                                        </div>
                                        <!-- Pricing body End -->

                                        <!-- Pricing Button Start -->
                                        <div class="pricing-btn">
                                            <a href="purchase?plan=free" class="btn-default btn-default-red">get started
                                                now</a>
                                        </div>
                                        <!-- Pricing Button End -->
                                    </div>
                                    <!-- Pricing Box End -->
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <!-- Pricing Box Start -->
                                    <div class="pricing-item highlighted-box box-bg-shape">
                                        <!-- Pricing Header Start -->
                                        <div class="pricing-header">
                                            <h3>Growth Plan</h3>
                                            <h2>$59.00<sub>/Monthly</sub></h2>
                                        </div>
                                        <!-- Pricing Header End -->

                                        <!-- Pricing Item Content Start -->
                                        <div class="pricing-item-content">
                                            <p>Great for product videos, presentations, or training content.</p>
                                        </div>
                                        <!-- Pricing Item Content End -->

                                        <!-- Pricing body Start -->
                                        <div class="pricing-body">
                                            <h3>What's Included:</h3>
                                            <ul>
                                                <li>Up to 500 words</li>
                                                <li>Unlimited revisions</li>
                                                <li>1 premium voice talent option</li>
                                            </ul>
                                        </div>
                                        <!-- Pricing body End -->

                                        <!-- Pricing Button Start -->
                                        <div class="pricing-btn">
                                            <a href="contact.php" class="btn-default">get started now</a>
                                        </div>
                                        <!-- Pricing Button End -->
                                    </div>
                                    <!-- Pricing Box End -->
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <!-- Pricing Box Start -->
                                    <div class="pricing-item">
                                        <!-- Pricing Header Start -->
                                        <div class="pricing-header">
                                            <h3>Enterprise Plan</h3>
                                            <h2>$99.00<sub>/Monthly</sub></h2>
                                        </div>
                                        <!-- Pricing Header End -->

                                        <!-- Pricing Item Content Start -->
                                        <div class="pricing-item-content">
                                            <p>For ongoing, multi-language, or large-scale projects.</p>
                                        </div>
                                        <!-- Pricing Item Content End -->

                                        <!-- Pricing body Start -->
                                        <div class="pricing-body">
                                            <h3>What's Included:</h3>
                                            <ul>
                                                <li>Unlimited word count</li>
                                                <li>Dedicated project manager</li>
                                                <li>Multiple voice talent options</li>
                                            </ul>
                                        </div>
                                        <!-- Pricing body End -->

                                        <!-- Pricing Button Start -->
                                        <div class="pricing-btn">
                                            <a href="contact.php" class="btn-default btn-default-red">get started now</a>
                                        </div>
                                        <!-- Pricing Button End -->
                                    </div>
                                    <!-- Pricing Box End -->
                                </div>
                            </div>
                        </div>
                        <!-- Pricing Tab Item End -->

                        <!-- Pricing Tab Item Start -->
                        <div class="pricing-tab-item" id="annually">
                            <div class="row">
                                <?php
                                foreach( $planArr as $k=>$val ){
                                    ?>
                                <div class="col-lg-4 col-md-6">
                                    <!-- Pricing Box Start -->
                                    <div class="pricing-item <?= $val['price_item_class'] ?>">
                                        <!-- Pricing Header Start -->
                                        <div class="pricing-header">
                                            <h3><?= $k ?></h3>
                                            <h2><?= $val['price'] ?></h2>
                                        </div>
                                        <!-- Pricing Header End -->

                                        <!-- Pricing Item Content Start -->
                                        <div class="pricing-item-content">
                                            <p>
                                                <?= $val['value'] ?>
                                            </p>
                                        </div>
                                        <!-- Pricing Item Content End -->

                                        <!-- Pricing body Start -->
                                        <div class="pricing-body">
                                            <h3>What's Included:</h3>
                                            <ul>
                                                <?php
                                                    foreach( $val['feature'] as $f ){
                                                        ?>
                                                <li>
                                                    <?= $f ?>
                                                </li>
                                                <?php
                                                    }?>
                                            </ul>
                                        </div>
                                        <!-- Pricing body End -->

                                        <!-- Pricing Button Start -->
                                        <div class="pricing-btn">
                                            <a href="<?= url('purchase?plan=' . $val['link']) ?>" class="btn-default">
                                                Get Started Now
                                            </a>
                                        </div>
                                        <!-- Pricing Button End -->
                                    </div>
                                    <!-- Pricing Box End -->
                                </div>
                                <?php
                                }?>

                            </div>
                        </div>
                        <!-- Pricing Tab Item End -->
                    </div>

                    <!-- Pricing Benifit List Start -->
                    <div class="pricing-benefit-list wow fadeInUp" data-wow-delay="0.6s">
                        <ul>
                            <li><img src="frontend/images/icon-pricing-benefit-1.svg" alt="">Get 30 day free trial
                            </li>
                            <li><img src="frontend/images/icon-pricing-benefit-2.svg" alt="">No any hidden fee pay
                            </li>
                            <li><img src="frontend/images/icon-pricing-benefit-3.svg" alt="">You can cancel
                                anytime </li>
                        </ul>
                    </div>
                    <!-- Pricing Benifit List End -->
                </div>

            </div>
        </div>
    </div>
    <!-- Page Pricing End -->

    <!-- Page Team Single Start -->
    <div class="page-team-single pt-0 mt-5">
        <div class="container">
            <div class="row">
                <!-- Team Single Content Start -->
                <div class="team-single-content">
                    <!-- Team Member Info Start -->
                    <div class="team-member-info pb-5">

                        <!-- Section Title Start -->
                        <div class="section-title pt-5">
                            <h2 class="wow fadeInUp" data-cursor="-opaque">What we <span>Are</span></h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Team Member Info Counters Start -->
                        <div class="team-member-info-counters">
                            <!-- Member Info Counter Item Start -->
                            <div class="member-info-counter-item">
                                <h2><span class="counter">9</span>+</h2>
                                <p>Years of experience</p>
                            </div>
                            <!-- Member Info Counter Item End -->

                            <!-- Member Info Counter Item Start -->
                            <div class="member-info-counter-item">
                                <h2><span class="counter">87</span>%</h2>
                                <p>Signals Accuracy</p>
                            </div>
                            <!-- Member Info Counter Item End -->

                            <!-- Member Info Counter Item Start -->
                            <div class="member-info-counter-item">
                                <h2><span class="counter">3000</span>+</h2>
                                <p>PIPs Monthly</p>
                            </div>
                            <!-- Member Info Counter Item End -->

                            <!-- Member Info Counter Item Start -->
                            <div class="member-info-counter-item">
                                <h2><span class="counter">50</span>+</h2>
                                <p>Countries</p>
                            </div>
                            <!-- Member Info Counter Item End -->
                        </div>
                        <!-- Team Member Info Counters End -->
                    </div>
                    <!-- Team Member Info End -->

                </div>
                <!-- Team Single Content End -->

                <!-- Team Member Skills Start -->
                <div class="team-member-skills pt-5">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-cursor="-opaque">Our <span>Strength</span></h2>
                    </div>
                    <!-- Section Title End -->

                    <!-- Team Skills List Start -->
                    <div class="member-skills-list">
                        <!-- Skills Progress Bar Start -->
                        <div class="skills-progress-bar">
                            <!-- Skill Item Start -->
                            <div class="skillbar" data-percent="95%">
                                <div class="skill-data">
                                    <div class="skill-title">AI + Hunam hybride analysis</div>
                                    <div class="skill-no">95%</div>
                                </div>
                                <div class="skill-progress">
                                    <div class="count-bar"></div>
                                </div>
                            </div>
                            <!-- Skill Item End -->
                        </div>
                        <!-- Skills Progress Bar End -->

                        <!-- Skills Progress Bar Start -->
                        <div class="skills-progress-bar">
                            <!-- Skill Item Start -->
                            <div class="skillbar" data-percent="98%">
                                <div class="skill-data">
                                    <div class="skill-title">Verified Results</div>
                                    <div class="skill-no">98%</div>
                                </div>
                                <div class="skill-progress">
                                    <div class="count-bar"></div>
                                </div>
                            </div>
                            <!-- Skill Item End -->
                        </div>
                        <!-- Skills Progress Bar End -->

                        <!-- Skills Progress Bar Start -->
                        <div class="skills-progress-bar">
                            <!-- Skill Item Start -->
                            <div class="skillbar" data-percent="92%">
                                <div class="skill-data">
                                    <div class="skill-title">Risk Managements</div>
                                    <div class="skill-no">92%</div>
                                </div>
                                <div class="skill-progress">
                                    <div class="count-bar"></div>
                                </div>
                            </div>
                            <!-- Skill Item End -->
                        </div>
                        <!-- Skills Progress Bar End -->

                        <!-- Skills Progress Bar Start -->
                        <div class="skills-progress-bar">
                            <!-- Skill Item Start -->
                            <div class="skillbar" data-percent="87%">
                                <div class="skill-data">
                                    <div class="skill-title">Signal Success Rate</div>
                                    <div class="skill-no">87%</div>
                                </div>
                                <div class="skill-progress">
                                    <div class="count-bar"></div>
                                </div>
                            </div>
                            <!-- Skill Item End -->
                        </div>
                        <!-- Skills Progress Bar End -->

                    </div>
                    <!-- Team Skills List End -->
                </div>
                <!-- Team Member Skill End -->
            </div>
        </div>
    </div>

    <!-- Follow Up Section Start -->
    <style>
        .follow-us {
            text-align: center;
            padding: 80px;
            align-items: center;
            justify-content: center;
            background-image: url('public/frontend/images/background/follow-up-background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .follow-us h1 {
            font-size: 8rem;
            font-weight: 800;
            color: var(--red-color);
        }

        .social-icons a {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--black-color);
            color: var(--white-color);
            font-size: 2rem;
            transition: all 0.3s ease;
            margin: 0 18px;
        }

        .social-icons a:hover {
            background: red;
            color: #fff;
            transform: translateY(-5px);
        }

        .newsletter {
            margin-top: 40px;
        }

        .newsletter h3 {
            font-weight: 700;
        }

        .newsletter p {
            font-size: 0.95rem;
            color: #555;
        }

        .newsletter .btn {
            background-color: var(--red-color);
            border: none;
            padding: 10px 20px;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);
            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);
        }

        .newsletter .btn:hover {
            background-color: var(--orange-hover-color);
        }

        /* Gradient edges */
        .icon-scroller::before,
        .icon-scroller::after {
            content: "";
            position: absolute;
            top: 0;
            width: 20%;
            height: 100%;
            z-index: 5;
            pointer-events: none;
        }

        .gradient-box {
            background: linear-gradient(to right, #fff 0%, transparent 25%, transparent 75%, #fff 100%);
        }

        .icon-track {
            display: inline-flex;
            gap: 0px;
            /* animation: scrollLeft 20s linear infinite; */
            z-index: -1;
        }

        .icon-track a {
            width: 60px;
            height: 60px;
            background: #000;
            color: #fff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            text-decoration: none;
            transition: 0.3s;
        }

        .icon-track a:hover {
            background: #ff3c00;
        }

        /* Infinite scroll animation */
        @keyframes scrollLeft {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }
    </style>

    <section class="container-flud follow-us gradient-box">
        <div class="icon-scroller">
            <h1 class="mb-5">FOLLOW US</h1>

            <div class="social-icons d-flex flex-wrap justify-content-center mb-5">
                <div class="icon-track">
                    <!-- First Set -->
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fas fa-globe"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-x-twitter"></i></a>
                </div>
            </div>

            <div class="newsletter">
                <h3>BE IN THE KNOW</h3>
                <p>Sign up to our newsletter and receive a monthly selection right in your inbox</p>
                <button class="btn btn-primary">Subscribe to our newsletter</button>
            </div>
        </div>
    </section>
    <!-- Follow Up Section End -->
@endsection
