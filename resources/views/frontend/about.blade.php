@extends('frontend.layout')

@section('content')

    <!-- Page Header Start -->
    <div class="page-header" style="background: url('{{url( 'public/frontend/images/about-us.jpg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="wow fadeInUp" data-cursor="-opaque">About US</h1>
                        <nav class="wow fadeInUp" data-wow-delay="0.2s">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">about us</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- About Us Section Start -->
    <div class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- About Us Info Start -->
                    <div class="about-us-info">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">About Us</h3>
                        </div>
                        <!-- Section Title End -->

                        <!-- About Us Circle Start -->
                        <div class="year-experience-circle">
                            <img src="public/frontend/images/year-experience-circle.svg" alt="">
                            <h2><span class="counter">20</span>+</h2>
                        </div>
                        <!-- About Us Circle End -->
                    </div>
                    <!-- About Us Info End -->
                </div>

                <div class="col-lg-8">
                    <!-- About Us Content Start -->
                    <div class="about-us-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h2 class="text-effect wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">
                                Wealthora was created to bring clarity, structure, and discipline to the trading journey.
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay="0.4s">
                                Wealthora is a community-driven trading platform dedicated to helping traders understand the real dynamics of financial markets. Many traders enter Forex, Cryptocurrency, Stocks, and Indices trading expecting quick profits, but without a clear understanding of market psychology, institutional behaviour, and risk management, trading often becomes emotional and inconsistent.
                            </p>

                            <p>
                                Our platform provides professional trading signals, structured market analysis, and customized trade setups across Forex, Crypto, Global Stocks, and major Indices. Every trade opportunity shared within the Wealthora community is based on technical market structure, institutional insights, and disciplined risk management, helping traders understand not only when to trade, but also why a trade opportunity exists.
                            </p>

                            <p>
                                Beyond signals, Wealthora focuses on helping traders develop a structured financial approach through customized trade planning, wealth portfolio guidance, and strong risk management principles to protect capital and support long-term growth.
                            </p>
                        </div>
                        <!-- Section Title End -->

                    </div>
                    <!-- About Us Content End -->
                </div>

            </div>
        </div>
    </div>
    <!-- About Us Section End -->

    <!-- Our Benefits Section Start -->
    <div class="our-benefits bg-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <!-- Our Benefit Image Start -->
                    <div class="our-benefit-image wow fadeInUp">
                        <!-- Benefit Image Start -->
                        <div class="benefit-img">
                            <figure class="image-anime">
                                <img src="public/frontend/images/benefit-image.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Benefit Image End -->

                        <!-- Benefit CTA Box Start -->
                        <div class="benefit-cta-box">
                            <div class="benefit-cta-content">
                                <h2><span class="counter">10</span>K+</h2>
                                <p>Voiceovers Delivered</p>
                            </div>
                        </div>
                        <!-- Benefit CTA Box End -->
                    </div>
                    <!-- Our Benefit Image End -->
                </div>

                <div class="col-lg-7">
                    <!-- Benefit Content Start -->
                    <div class="benefit-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">
                                Wealthora community
                            </h3>
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">
                                Inside the Wealthora <span>community, members</span> gain access to:
                            </h2>

                            <p class="wow fadeInUp" data-wow-delay="0.4s">
                                Tools and insights designed for professional trading growth
                            </p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Benefit Body Start -->
                        <div class="benefit-body">
                            <!-- Trading Signals Start -->
                            <div class="benefit-body-item wow fadeInUp" data-wow-delay="0.4s">
                                <div class="icon-box">
                                    <img src="public/frontend/images/icon-graph-up-arrow.svg" alt="">
                                </div>
                                <div class="benefit-body-content">
                                    <h3>Trading Signals</h3>
                                    <p>
                                        Forex, Crypto, Stocks, and Indices trading signals based on structured technical analysis.
                                    </p>
                                </div>
                            </div>
                            <!-- Trading Signals End -->

                            <!-- Technical Market Analysis Start -->
                            <div class="benefit-body-item wow fadeInUp" data-wow-delay="0.6s">
                                <div class="icon-box">
                                    <img src="public/frontend/images/icon-bar-chart.svg" alt="">
                                </div>
                                <div class="benefit-body-content">
                                    <h3>Technical Market Analysis</h3>
                                    <p>
                                        Professional analysis with clear market reasoning to understand trade opportunities.
                                    </p>
                                </div>
                            </div>
                            <!-- Technical Market Analysis End -->

                            <!-- Trading Discipline Start -->
                            <div class="benefit-body-item wow fadeInUp" data-wow-delay="0.8s">
                                <div class="icon-box">
                                    <img src="public/frontend/images/icon-person-check.svg" alt="">
                                </div>
                                <div class="benefit-body-content">
                                    <h3>Trading Discipline</h3>
                                    <p>
                                        Discussions and insights focused on market psychology and emotional control.
                                    </p>
                                </div>
                            </div>
                            <!-- Trading Discipline End -->

                            <!-- Risk Management Start -->
                            <div class="benefit-body-item wow fadeInUp" data-wow-delay="0.8s">
                                <div class="icon-box">
                                    <img src="public/frontend/images/icon-shield-check.svg" alt="">
                                </div>
                                <div class="benefit-body-content">
                                    <h3>Risk Management</h3>
                                    <p>
                                        Capital protection strategies and structured risk management principles.
                                    </p>
                                </div>
                            </div>
                            <!-- Risk Management End -->

                        </div>
                        <!-- Benefit Body End -->
                    </div>
                    <!-- Benefit Content End -->
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <!-- Wealth Portfolio Planning Start -->
                        <div class="benefit-body-item wow fadeInUp" data-wow-delay="0.8s">
                            <div class="icon-box">
                                <img src="public/frontend/images/icon-wallet2.svg" alt="">
                            </div>
                            <div class="benefit-body-content">
                                <h3>Wealth Portfolio Planning</h3>
                                <p>
                                    Guidance on building a diversified financial portfolio for long-term growth.
                                </p>
                            </div>
                        </div>
                        <!-- Wealth Portfolio Planning End -->
                    </div>
                    <div class="col-lg-6">
                        <!-- Custom Trade Setups Start -->
                        <div class="benefit-body-item wow fadeInUp" data-wow-delay="0.8s">
                            <div class="icon-box">
                                <img src="public/frontend/images/icon-lightbulb.svg" alt="">
                            </div>
                            <div class="benefit-body-content">
                                <h3>Custom Trade Setups</h3>
                                <p>
                                    Structured setups with institutional insights and strategic market reasoning.
                                </p>
                            </div>
                        </div>
                        <!-- Custom Trade Setups End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Our Benefits Section End -->

    <!-- Our Vision -->
    <style>
        .mission-box{
            background:linear-gradient(135deg,#020617,#0f172a);
            border-radius:20px;
            padding:60px;
            border:1px solid rgba(255,255,255,0.08);
        }
        .mission-box .section-title h2, .mission-box p{
            color: #fff;
        }
    </style>
    <section class="our-approach">
        <div class="container">

            <div class="mission-box text-center" data-aos="fade-up">

                <div class="section-title">
                    <h2 class="wow fadeInUp" data-cursor="-opaque">
                        Our Mission
                    </h2>
                </div>

                <p class="mb-2">
                    Our mission is to help traders move beyond speculation and develop a professional, disciplined, and informed approach to financial markets.
                </p>

                <p class="lead">
                    Because in trading, the real edge is not chasing the market — it is understanding and managing risk within it.
                </p>

            </div>

        </div>

        </section>
    <!-- Our Mission -->

    <!-- Our Approach Section Start -->
    <div class="our-approach d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Approach Image Start -->
                    <div class="approach-image wow fadeInUp">
                        <!-- Approach Image Start -->
                        <div class="approach-img">
                            <figure class="image-anime">
                                <img src="images/approach-image.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Approach Image End -->

                        <!-- Review Rating Box Start -->
                        <div class="review-rating-box">
                            <!-- Review Images Start -->
                            <div class="review-images">
                                <div class="review-image">
                                    <figure class="image-anime">
                                        <img src="images/author-1.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="review-image">
                                    <figure class="image-anime">
                                        <img src="images/author-2.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="review-image">
                                    <figure class="image-anime">
                                        <img src="images/author-3.jpg" alt="">
                                    </figure>
                                </div>
                            </div>
                            <!-- Review Images End -->

                            <!-- Review Content Start -->
                            <div class="review-content">
                                <div class="review-rating-star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <span class="counter">4.9</span>
                                </div>
                                <div class="review-rating-content">
                                    <p>4.9 / 5 Ratings</p>
                                </div>
                            </div>
                            <!-- Review Content End -->
                        </div>
                        <!-- Review Rating Box End -->
                    </div>
                    <!-- Approach Image End -->
                </div>

                <div class="col-lg-8">
                    <!-- Approach Content Start -->
                    <div class="approach-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Our approach</h3>
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">

                            </h2>
                            <p class="wow fadeInUp" data-wow-delay="0.4s">

                            </p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Approach Button Start -->
                        <div class="approach-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="contact.php" class="btn-default">learn More</a>
                        </div>
                        <!-- Approach Button End -->

                        <!-- Approach Body Start -->
                        <div class="approach-body wow fadeInUp" data-wow-delay="0.8s">
                            <!-- Mission Vision Item Start -->
                            <div class="mission-vision-item">
                                <div class="icon-box">
                                    <img src="images/icon-mission.svg" alt="">
                                </div>

                                <div class="mission-vision-content">
                                    <h3>Our Mission</h3>
                                    <p>With a proven track record of delivering high-quality voiceovers for brands,</p>
                                </div>

                                <div class="mission-vision-btn">
                                    <a href="contact.php" class="readmore-btn">read more</a>
                                </div>
                            </div>
                            <!-- Mission Vision Item End -->

                            <!-- Mission Vision Item Start -->
                            <div class="mission-vision-item">
                                <div class="icon-box">
                                    <img src="images/icon-vision.svg" alt="">
                                </div>

                                <div class="mission-vision-content">
                                    <h3>Our Vision</h3>
                                    <p>We believe in transparency, communication, and fast delivery</p>
                                </div>

                                <div class="mission-vision-btn">
                                    <a href="contact.php" class="readmore-btn">read more</a>
                                </div>
                            </div>
                            <!-- Mission Vision Item End -->
                        </div>
                        <!-- Approach Body End -->
                    </div>
                    <!-- Approach Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Approach Section End -->

    <!-- How It Work Section Start -->
    <div class="how-it-work bg-section d-none">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <h3 class="wow fadeInUp">How it work</h3>
                        <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Getting your voiceover has never been <span>this easy</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <!-- Work Step Item Start -->
                    <div class="work-step-item box-bg-shape wow fadeInUp">
                        <div class="icon-box">
                            <img src="images/icon-work-step-1.svg" alt="">
                        </div>
                        <div class="work-step-content">
                            <h3>Send Your Script</h3>
                            <p>Not ready? We can help you craft or refine it.</p>
                        </div>
                        <div class="work-step-no">
                            <h3>step 01</h3>
                        </div>
                    </div>
                    <!-- Work Step Item End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Work Step Item Start -->
                    <div class="work-step-item box-bg-shape wow fadeInUp" data-wow-delay="0.2s">
                        <div class="work-step-item-body">
                            <div class="icon-box">
                                <img src="images/icon-work-step-2.svg" alt="">
                            </div>
                            <div class="work-step-content">
                                <h3>Choose Your Voice</h3>
                                <p>Pick from our roster of professional artists.</p>
                            </div>
                        </div>
                        <div class="work-step-no">
                            <h3>step 02</h3>
                        </div>
                    </div>
                    <!-- Work Step Item End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Work Step Item Start -->
                    <div class="work-step-item box-bg-shape wow fadeInUp" data-wow-delay="0.4s">
                        <div class="work-step-item-body">
                            <div class="icon-box">
                                <img src="images/icon-work-step-3.svg" alt="">
                            </div>
                            <div class="work-step-content">
                                <h3>We Record & Edit</h3>
                                <p>Our team records your voiceover.</p>
                            </div>
                        </div>
                        <div class="work-step-no">
                            <h3>step 03</h3>
                        </div>
                    </div>
                    <!-- Work Step Item End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Work Step Item Start -->
                    <div class="work-step-item box-bg-shape wow fadeInUp" data-wow-delay="0.6s">
                        <div class="work-step-item-body">
                            <div class="icon-box">
                                <img src="images/icon-work-step-4.svg" alt="">
                            </div>
                            <div class="work-step-content">
                                <h3>Review & Download</h3>
                                <p>Get the final audio within 24 - 48 hours.</p>
                            </div>
                        </div>
                        <div class="work-step-no">
                            <h3>step 04</h3>
                        </div>
                    </div>
                    <!-- Work Step Item End -->
                </div>

                <div class="col-lg-12">
                    <!-- Section Footer Text Start -->
                    <div class="section-footer-text wow fadeInUp" data-wow-delay="0.8s">
                        <p>Let's make something great work together. <a href="contact.php">Get Free Quote</a></p>
                    </div>
                    <!-- Section Footer Text End -->
                </div>
            </div>
        </div>
    </div>
    <!-- How It Work Section End -->

    <!-- Our Impact Section Start -->
    <div class="our-empact d-none">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <!-- Our Impact Image Start -->
                    <div class="our-impact-image wow fadeInUp">
                        <!-- Impact Image Start -->
                        <div class="impact-image">
                            <figure class="image-anime">
                                <img src="images/our-impact-image.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Impact Image End -->

                        <div class="impact-image-list">
                            <ul>
                                <li>Robotic Voice</li>
                                <li>High Cost</li>
                                <li>Audio Quality</li>
                                <li>Limited Language</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Our Impact Image End -->
                </div>
                <div class="col-lg-7">
                    <!-- Impact Content Start -->
                    <div class="impact-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Our Impact</h3>
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Impacting brand globaly with <span>powerful voiceovers</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.4s">Our voiceovers don't just sound great — they deliver measurable results. From increasing viewer engagement and brand trust to helping businesses expand globally with multilingual</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Impact Body Start -->
                        <div class="impact-body">
                            <!-- Impact Body Item Start -->
                            <div class="impact-body-item box-bg-shape">
                                <h2><span class="counter">5</span>K+</h2>
                                <h3>Projects Delivered</h3>
                                <p>From explainer videos to documentaries, we've voiced</p>
                            </div>
                            <!-- Impact Body Item End -->

                            <!-- Impact Body Item Start -->
                            <div class="impact-body-item box-bg-shape">
                                <h2><span class="counter">30</span>+</h2>
                                <h3>Languages</h3>
                                <p>Reach a global audience with voiceovers tailored</p>
                            </div>
                            <!-- Impact Body Item End -->
                        </div>
                        <!-- Impact Body End -->

                        <!-- Impact Button Start -->
                        <div class="impact-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="contact.php" class="btn-default">learn more</a>
                        </div>
                        <!-- Impact Button End -->
                    </div>
                    <!-- Impact Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Impact Section End -->

    <!-- Our Team Section Start -->
    <div class="our-team bg-section d-none">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <h3 class="wow fadeInUp">Our Team</h3>
                        <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Meet the voices behind your <span>brand's success</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item box-bg-shape wow fadeInUp">
                        <!-- Team Image Start -->
                        <div class="team-image">
                            <figure>
                                <img src="images/team-1.png" alt="">
                            </figure>
                        </div>
                        <!-- Team Image End -->

                        <!-- Team Content Start -->
                        <div class="team-content">
                            <h3><a href="team-single.php">Sophia Bennett</a></h3>
                            <p>Marketing director</p>
                        </div>
                        <!-- Team Content End -->

                        <!-- Team Social Icon Start -->
                        <div class="team-social-icon">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-pinterest-p"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                        <!-- Team Social Icon End -->
                    </div>
                    <!-- Team Item End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item box-bg-shape wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Team Image Start -->
                        <div class="team-image">
                            <figure>
                                <img src="images/team-2.png" alt="">
                            </figure>
                        </div>
                        <!-- Team Image End -->

                        <!-- Team Content Start -->
                        <div class="team-content">
                            <h3><a href="team-single.php">James Rutledge</a></h3>
                            <p>Marketing director</p>
                        </div>
                        <!-- Team Content End -->

                        <!-- Team Social Icon Start -->
                        <div class="team-social-icon">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-pinterest-p"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                        <!-- Team Social Icon End -->
                    </div>
                    <!-- Team Item End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item box-bg-shape wow fadeInUp" data-wow-delay="0.4s">
                        <!-- Team Image Start -->
                        <div class="team-image">
                            <figure>
                                <img src="images/team-3.png" alt="">
                            </figure>
                        </div>
                        <!-- Team Image End -->

                        <!-- Team Content Start -->
                        <div class="team-content">
                            <h3><a href="team-single.php">Emily Bradford</a></h3>
                            <p>Marketing director</p>
                        </div>
                        <!-- Team Content End -->

                        <!-- Team Social Icon Start -->
                        <div class="team-social-icon">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-pinterest-p"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                        <!-- Team Social Icon End -->
                    </div>
                    <!-- Team Item End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item box-bg-shape wow fadeInUp" data-wow-delay="0.6s">
                        <!-- Team Image Start -->
                        <div class="team-image">
                            <figure>
                                <img src="images/team-4.png" alt="">
                            </figure>
                        </div>
                        <!-- Team Image End -->

                        <!-- Team Content Start -->
                        <div class="team-content">
                            <h3><a href="team-single.php">Brian Whitaker</a></h3>
                            <p>Marketing director</p>
                        </div>
                        <!-- Team Content End -->

                        <!-- Team Social Icon Start -->
                        <div class="team-social-icon">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-pinterest-p"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                        <!-- Team Social Icon End -->
                    </div>
                    <!-- Team Item End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Team Section End -->

    <!-- What We Do Section Start -->
    <div class="what-we-do d-none">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- What We Do image Box Start -->
                    <div class="what-we-do-image-box wow fadeInUp">
                        <!-- What We Do image Start -->
                        <div class="what-we-do-img box-bg-shape">
                            <figure class="image-anime">
                                <img src="images/what-we-do-image.jpg" alt="">
                            </figure>
                        </div>
                        <!-- What We Do image End -->

                        <!-- Review Rating Box Start -->
                        <div class="review-rating-box wow fadeInUp">
                            <!-- Review Images Start -->
                            <div class="review-images">
                                <div class="review-image">
                                    <figure class="image-anime">
                                        <img src="images/author-1.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="review-image">
                                    <figure class="image-anime">
                                        <img src="images/author-2.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="review-image">
                                    <figure class="image-anime">
                                        <img src="images/author-3.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="review-image">
                                    <figure class="image-anime">
                                        <img src="images/author-4.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="review-image add-more">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                            <!-- Review Images End -->

                            <!-- Review Content Start -->
                            <div class="review-content">
                                <div class="review-rating-star">
                                    <span class="counter">4.9</span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div class="review-rating-content">
                                    <p>Google Rating</p>
                                </div>
                            </div>
                            <!-- Review Content End -->
                        </div>
                        <!-- Review Rating Box End -->
                    </div>
                    <!-- What We Do image Box End -->
                </div>

                <div class="col-lg-6">
                    <!-- What We Do Content Start -->
                    <div class="what-we-do-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">What we do</h3>
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Purpose driven voiceover for <span>maximum impact</span></h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- What We Do Tab Box Start -->
                        <div class="what-we-do-tab-box tab-content wow fadeInUp" data-wow-delay="0.4s" id="myTabContent">
                            <!-- Sidebar What We Do Tab Nav start -->
                            <div class="what-we-do-nav">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="voiceovers-tab" data-bs-toggle="tab" data-bs-target="#voiceovers" type="button" role="tab" aria-selected="true">Voiceovers</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="script-tab" data-bs-toggle="tab" data-bs-target="#script" type="button" role="tab" aria-selected="false">Script Help</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="multilingual-tab" data-bs-toggle="tab" data-bs-target="#multilingual" type="button" role="tab" aria-selected="false">Multilingual</button>
                                    </li>
                                </ul>
                            </div>
                            <!-- Sidebar What We Do Tab Nav End -->

                            <!-- What We Do Tab Item Start -->
                            <div class="what-we-do-tab-item tab-pane fade show active" id="voiceovers" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- What We Do Tab Content Start -->
                                        <div class="what-we-do-tab-content">
                                            <div class="what-we-do-tab-header">
                                                <p>From life-like voice quality to flexible pricing and powerful customization, we offer everything you need to create professional audio. From life-like voice quality to flexible pricing and powerful customization.</p>
                                            </div>

                                            <div class="what-we-do-tab-body">
                                                <div class="what-we-do-body-info">
                                                    <div class="icon-box">
                                                        <img src="images/icon-what-we-do-body-1.svg" alt="">
                                                    </div>
                                                    <div class="what-we-do-body-title">
                                                        <h3>End-to-End Support</h3>
                                                    </div>
                                                </div>
                                                <div class="what-we-do-body-content">
                                                    <p>We're with you every step of the way - ensuring your voiceover is smooth.</p>
                                                    <ul>
                                                        <li>Script-to-Sound Expertise</li>
                                                        <li>Dedicated Project Management</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- What We Do Tab Content End -->
                                    </div>
                                </div>
                            </div>
                            <!-- What We Do Tab Item End -->

                            <!-- What We Do Tab Item Start -->
                            <div class="what-we-do-tab-item tab-pane fade" id="script" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- What We Do Tab Content Start -->
                                        <div class="what-we-do-tab-content">
                                            <div class="what-we-do-tab-header">
                                                <p>From life-like voice quality to flexible pricing and powerful customization, we offer everything you need to create professional audio. From life-like voice quality to flexible pricing and powerful customization.</p>
                                            </div>

                                            <div class="what-we-do-tab-body">
                                                <div class="what-we-do-body-info">
                                                    <div class="icon-box">
                                                        <img src="images/icon-what-we-do-body-2.svg" alt="">
                                                    </div>
                                                    <div class="what-we-do-body-title">
                                                        <h3>End-to-End Support</h3>
                                                    </div>
                                                </div>
                                                <div class="what-we-do-body-content">
                                                    <p>We're with you every step of the way - ensuring your voiceover is smooth.</p>
                                                    <ul>
                                                        <li>Script-to-Sound Expertise</li>
                                                        <li>Dedicated Project Management</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- What We Do Tab Content End -->
                                    </div>
                                </div>
                            </div>
                            <!-- What We Do Tab Item End -->

                            <!-- What We Do Tab Item Start -->
                            <div class="what-we-do-tab-item tab-pane fade" id="multilingual" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- What We Do Tab Content Start -->
                                        <div class="what-we-do-tab-content">
                                            <div class="what-we-do-tab-header">
                                                <p>From life-like voice quality to flexible pricing and powerful customization, we offer everything you need to create professional audio. From life-like voice quality to flexible pricing and powerful customization.</p>
                                            </div>

                                            <div class="what-we-do-tab-body">
                                                <div class="what-we-do-body-info">
                                                    <div class="icon-box">
                                                        <img src="images/icon-what-we-do-body-3.svg" alt="">
                                                    </div>
                                                    <div class="what-we-do-body-title">
                                                        <h3>End-to-End Support</h3>
                                                    </div>
                                                </div>
                                                <div class="what-we-do-body-content">
                                                    <p>We're with you every step of the way - ensuring your voiceover is smooth.</p>
                                                    <ul>
                                                        <li>Script-to-Sound Expertise</li>
                                                        <li>Dedicated Project Management</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- What We Do Tab Content End -->
                                    </div>
                                </div>
                            </div>
                            <!-- What We Do Tab Item End -->
                        </div>
                        <!-- What We Do Tab Box End -->

                        <!-- What We Do Button Start -->
                        <div class="what-we-do-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="contact.php" class="btn-default">learn more</a>
                        </div>
                        <!-- What We Do Button End -->
                    </div>
                    <!-- What We Do Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- What We Do Section End -->

    <!-- Our Faqs Section Start -->
    <div class="our-faqs bg-section d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <!-- Faqs Content Start -->
                    <div class="faqs-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">FAQ's</h3>
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Answers to help you <span>get started</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.4s">Whether you're new to voiceovers or a seasoned creator, we've gathered the most common questions.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Faqs Button Start -->
                        <div class="faqs-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="faqs.php" class="btn-default">View All FAQs</a>
                        </div>
                        <!-- Faqs Button End -->
                    </div>
                    <!-- Faqs Content End -->
                </div>

                <div class="col-lg-7">
                    <!-- FAQ Accordion Start -->
                    <div class="faq-accordion" id="accordion">
                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    1. What is an AI Video Generator and how does it work?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Most projects are delivered within 24-48 hours. Larger or multilingual projects may take a bit longer, but we always meet your deadline.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    2. What languages and voices are available?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse show" aria-labelledby="heading2" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Most projects are delivered within 24-48 hours. Larger or multilingual projects may take a bit longer, but we always meet your deadline.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    3. Can I edit the video after generation?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Most projects are delivered within 24-48 hours. Larger or multilingual projects may take a bit longer, but we always meet your deadline.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.6s">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    4. Are the videos suitable for commercial use?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Most projects are delivered within 24-48 hours. Larger or multilingual projects may take a bit longer, but we always meet your deadline.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.8s">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    5. Is my data safe on your platform?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Most projects are delivered within 24-48 hours. Larger or multilingual projects may take a bit longer, but we always meet your deadline.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->
                    </div>
                    <!-- FAQ Accordion End -->
                </div>

                <div class="col-lg-12">
                    <!-- Comapany Support Slider Start -->
                    <div class="company-slider-box">
                        <!-- Comapany Support Content Start -->
                        <div class="company-supports-content wow fadeInUp" data-wow-delay="0.2s">
                            <hr>
                            <h3>Helping 5,000+ Brands Sound Their Best</h3>
                            <hr>
                        </div>
                        <!-- Comapany Support Content End -->

                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <!-- Company Support Logo Start -->
                                <div class="swiper-slide">
                                    <div class="company-supports-logo">
                                        <img src="images/company-supports-logo-1.svg" alt="">
                                    </div>
                                </div>
                                <!-- Comapany Support Logo End -->

                                <!-- Company Support Logo Start -->
                                <div class="swiper-slide">
                                    <div class="company-supports-logo">
                                        <img src="images/company-supports-logo-2.svg" alt="">
                                    </div>
                                </div>
                                <!-- Comapany Support Logo End -->

                                <!-- Company Support Logo Start -->
                                <div class="swiper-slide">
                                    <div class="company-supports-logo">
                                        <img src="images/company-supports-logo-3.svg" alt="">
                                    </div>
                                </div>
                                <!-- Comapany Support Logo End -->

                                <!-- Company Support Logo Start -->
                                <div class="swiper-slide">
                                    <div class="company-supports-logo">
                                        <img src="images/company-supports-logo-4.svg" alt="">
                                    </div>
                                </div>
                                <!-- Comapany Support Logo End -->

                                <!-- Company Support Logo Start -->
                                <div class="swiper-slide">
                                    <div class="company-supports-logo">
                                        <img src="images/company-supports-logo-5.svg" alt="">
                                    </div>
                                </div>
                                <!-- Comapany Support Logo End -->

                                <!-- Company Support Logo Start -->
                                <div class="swiper-slide">
                                    <div class="company-supports-logo">
                                        <img src="images/company-supports-logo-1.svg" alt="">
                                    </div>
                                </div>
                                <!-- Comapany Support Logo End -->

                                <!-- Company Support Logo Start -->
                                <div class="swiper-slide">
                                    <div class="company-supports-logo">
                                        <img src="images/company-supports-logo-2.svg" alt="">
                                    </div>
                                </div>
                                <!-- Comapany Support Logo End -->

                                <!-- Company Support Logo Start -->
                                <div class="swiper-slide">
                                    <div class="company-supports-logo">
                                        <img src="images/company-supports-logo-3.svg" alt="">
                                    </div>
                                </div>
                                <!-- Comapany Support Logo End -->

                                <!-- Company Support Logo Start -->
                                <div class="swiper-slide">
                                    <div class="company-supports-logo">
                                        <img src="images/company-supports-logo-4.svg" alt="">
                                    </div>
                                </div>
                                <!-- Comapany Support Logo End -->

                                <!-- Company Support Logo Start -->
                                <div class="swiper-slide">
                                    <div class="company-supports-logo">
                                        <img src="images/company-supports-logo-5.svg" alt="">
                                    </div>
                                </div>
                                <!-- Comapany Support Logo End -->
                            </div>
                        </div>
                    </div>
                    <!-- Comapany Support Slider End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Faqs Section End -->

    <!-- Our Testimonials Section Start -->
    <div class="our-testimonials about-our-testimonials d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <!-- Testimonials Content Box Start -->
                    <div class="testimonials-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Our testimonials</h3>
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Hear what our happy clients <span>have to say</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.4s">From lifelike voice quality to flexible pricing and powerful customization, we offer everything you need to create professional audio - fast, simple.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Testimonial Button Start -->
                        <div class="testimonial-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="testimonials.php" class="btn-default">View All Reviews</a>
                        </div>
                        <!-- Testimonial Button End -->

                        <!-- Testimonial Slider Start -->
                        <div class="testimonial-slider">
                            <div class="swiper">
                                <div class="swiper-wrapper" data-cursor-text="Drag">
                                    <!-- Testimonial Slide Start -->
                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="testimonial-quote">
                                                <img src="images/testimonial-quote.svg" alt="">
                                            </div>
                                            <div class="testimonial-item-content">
                                                <p>I integrated the API into our mobile app with ease. now users enjoy seamless, natural voice interactions no extra recording needed</p>
                                            </div>
                                            <div class="testimonial-author">
                                                <div class="author-content">
                                                    <h3>Leslie Alexander</h3>
                                                    <p>CEO, Tech Startup</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Slide End -->

                                    <!-- Testimonial Slide Start -->
                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="testimonial-quote">
                                                <img src="images/testimonial-quote.svg" alt="">
                                            </div>
                                            <div class="testimonial-item-content">
                                                <p>I integrated the API into our mobile app with ease. now users enjoy seamless, natural voice interactions no extra recording needed</p>
                                            </div>
                                            <div class="testimonial-author">
                                                <div class="author-content">
                                                    <h3>Darlene Robertson</h3>
                                                    <p>co.Founder</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Slide End -->

                                    <!-- Testimonial Slide Start -->
                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="testimonial-quote">
                                                <img src="images/testimonial-quote.svg" alt="">
                                            </div>
                                            <div class="testimonial-item-content">
                                                <p>I integrated the API into our mobile app with ease. now users enjoy seamless, natural voice interactions no extra recording needed</p>
                                            </div>
                                            <div class="testimonial-author">
                                                <div class="author-content">
                                                    <h3>Ethan Parker</h3>
                                                    <p>Research Assistant</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Slide End -->
                                </div>
                            </div>
                        </div>
                        <!-- Testimonial Slider End -->
                    </div>
                    <!-- Testimonial Content Box End -->
                </div>

                <div class="col-lg-6">
                    <!-- Testimonial Image Start -->
                    <div class="testimonial-image">
                        <figure class="image-anime reveal">
                            <img src="images/testimonial-image.jpg" alt="">
                        </figure>
                    </div>
                    <!-- Testimonial Image End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Testimonials Section End -->
@endsection
