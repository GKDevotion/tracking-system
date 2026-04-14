@extends('frontend.layout')

@section('content')
    <section class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 content-animate">
                    <h1 class="display-3 fw-bold mb-4">Worlds No. 1<br>Trade Setup Provider</h1>
                    <p class="lead text-black p-0 m-0" style="font-weight: 600;">
                        87% Signals Accuracy
                    </p>
                    <p class="lead text-black p-0 m-0" style="font-weight: 600;">
                        Trade with confirm Entry, SL, TP
                    </p>
                    <p class="lead text-black mb-5 p-0">
                        Where Every Move is Calculated - Not Guessed
                    </p>
                    <a href="#" class="btn btn-outline-dark rounded-pill btn-lg px-5 py-3 shadow-sm hover-btn">
                        Get Started <span class="ms-2">→</span>
                    </a>
                </div>
                <div class="col-lg-5 text-center d-none d-lg-block">
                    <!-- <img src="images/home/candle.png" alt="Trading Candles" class="img-fluid candle-float"> -->
                    <div class="video-box">
                        <video autoplay muted loop playsinline class="img-fluid" style="width: 80%;">
                            <source src="{{ url('public/frontend/videos/bull-jump.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Start Card Scroll Animation -->
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #0a0a0f;
            --accent: #c8a96e;
            --white: #f5f0e8;
            --card1: #1a2a4a;
            --card2: #2a1a3a;
            --card3: #1a3a2a;
            --card4: #3a2a1a;
            --card5: #2a3a1a;
        }

        /* Sticky scene container */
        .scene-wrapper {
            position: relative;
            height: 600vh;
            top: 80px;
        }

        .sticky-scene {
            position: sticky;
            top: 0;
            height: 100vh;
            width: 100%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Noise overlay */
        .noise {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 100;
            opacity: 0.035;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-size: 200px 200px;
        }

        /* Radial glow center */
        .glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(200, 169, 110, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        /* Hero text */
        .hero-text {
            position: absolute;
            z-index: 0;
            text-align: center;
            pointer-events: none;
            user-select: none;
        }

        .hero-text .label {
            display: block;
            font-weight: 300;
            font-size: 11px;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 18px;
            opacity: 0;
            animation: fadeUp 1s 0.3s forwards;
        }

        .hero-text h1 {
            font-weight: 600;
            line-height: 1.0;
            /* color: var(--white); */
            /* opacity: 0; */
            animation: fadeUp 1s 0.1s forwards;
            transition: font-size 0.1s linear;
        }

        .hero-text .sub {
            display: block;
            font-size: 14px;
            color: rgba(245, 240, 232, 0.4);
            margin-top: 20px;
            letter-spacing: 0.05em;
            opacity: 0;
            animation: fadeUp 1s 0.9s forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Cards */
        .card {
            position: absolute;
            border-radius: 42px;
            overflow: hidden;
            will-change: transform, opacity;
            z-index: 5;
        }

        .card img {
            width: 350px;
            height: 250px;
        }

        /* Progress bar */
        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--red-color));
            z-index: 200;
            width: 0%;
            transition: width 0.2s linear;
        }
    </style>

    <div class="cursor" id="cursor"></div>
    <div class="noise"></div>
    <div class="progress-bar" id="progressBar"></div>

    <div class="scene-wrapper" id="sceneWrapper">
        <div class="sticky-scene" id="stickyScene">

            <div class="glow"></div>

            <!-- Hero Text -->
            <div class="hero-text">
                <h1>
                    <p class="p-0 m-0">Proven Signals</p>
                    <p class="p-0 m-0">Consistent
                        <span style="color: #46e546; text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);">Profits</span>
                    </p>
                </h1>
            </div>

            <!-- 5 Cards -->
            <div class="card card-1" id="card1">
                <img src="{{ url('public/frontend/images/3700-pip.png') }}">
            </div>

            <div class="card card-2" id="card2">
                <div class="card-inner">
                    <img src="{{ url('public/frontend/images/confirmed.png') }}">
                </div>
            </div>

            <div class="card card-3" id="card3">
                <div class="card-inner">
                    <img src="{{ url('public/frontend/images/82-accuracy.png') }}">
                </div>
            </div>

            <div class="card card-4" id="card4">
                <div class="card-inner">
                    <img src="{{ url('public/frontend/images/4k-signal-delivered.png') }}">
                </div>
            </div>

            <div class="card card-5" id="card5">
                <div class="card-inner">
                    <img src="{{ url('public/frontend/images/82-profit.png') }}">
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cursor
        const cursor = document.getElementById('cursor');
        document.addEventListener('mousemove', e => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });

        // Card definitions: corner origins (as vw/vh percentages from center)
        // Each card starts at a corner or edge, moves to center, then exits top
        const cards = [{
                el: document.getElementById('card1'),
                startX: -54,
                startY: 20,
                rot: 0
            }, // bottom-left
            {
                el: document.getElementById('card2'),
                startX: 54,
                startY: 20,
                rot: 0
            }, // bottom-right
            {
                el: document.getElementById('card3'),
                startX: -56,
                startY: -40,
                rot: 0
            }, // top-left
            {
                el: document.getElementById('card4'),
                startX: 55,
                startY: -40,
                rot: 0
            }, // top-right
            {
                el: document.getElementById('card5'),
                startX: 0,
                startY: 40,
                rot: 0
            }, // bottom-center
        ];

        const progressBar = document.getElementById('progressBar');
        const wrapper = document.getElementById('sceneWrapper');
        const heroTitle = document.querySelector('.hero-text h1');

        function lerp(a, b, t) {
            return a + (b - a) * t;
        }

        function clamp(v, lo, hi) {
            return Math.min(Math.max(v, lo), hi);
        }

        function ease(t) {
            return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
        } // easeInOut

        // Convert vw offset to px
        function vw(p) {
            return window.innerWidth * p / 100;
        }

        function vh(p) {
            return window.innerHeight * p / 100;
        }

        function update() {
            const scrollTop = window.scrollY;
            const maxScroll = wrapper.offsetHeight - window.innerHeight;
            const raw = clamp(scrollTop / maxScroll, 0, 1);

            // Text scale (180px → 75px)
            const maxFont = 160;
            const minFont = 90;

            // Control how fast it shrinks (0.4 = faster, 1 = full scroll)
            const textProgress = clamp(raw * 1.2, 0, 1);

            const fontSize = lerp(maxFont, minFont, textProgress);

            // Apply font size
            heroTitle.style.fontSize = fontSize + 'px';

            progressBar.style.width = (raw * 100) + '%';

            cards.forEach((c, i) => {
                // Each card has its own scroll window, slightly staggered
                // Phase 1 (0 → 0.5): corner → center
                // Phase 2 (0.5 → 1.0): center → top exit

                const offset = i * 0.03; // tiny stagger so they don't all arrive at same time
                const t = clamp((raw - offset) / (1 - offset), 0, 1);

                let x, y, scale, opacity, rotation;

                if (t < 0.5) {
                    // Incoming: corner → center
                    const p = ease(t / 0.5);
                    x = lerp(vw(c.startX), 0, p);
                    y = lerp(vh(c.startY), 0, p);
                    scale = lerp(0.55, 1, p);
                    opacity = lerp(1, 1, p);
                    rotation = lerp(c.rot, 0, p);
                } else {
                    // Outgoing: center → top
                    const p = ease((t - 0.5) / 0.5);
                    x = lerp(0, 0, p); // straight up
                    y = lerp(0, vh(-60), p);
                    scale = lerp(1, 0.7, p);
                    opacity = lerp(1, 0, p);
                    rotation = lerp(0, c.rot * -0.5, p);
                }

                changeScreen = rotation;

                c.el.style.transform =
                    `translate(calc(0% + ${x}px), calc(20% + ${y}px)) scale(${scale}) rotate(${rotation}deg)`;
                c.el.style.opacity = opacity;
            });
        }

        window.addEventListener('scroll', update, {
            passive: true
        });
        window.addEventListener('resize', update);

        update();
    </script>
    <!-- End Card Scroll Animation -->

    <!-- Blog -->
    <style>
        /* Section */
        .blog-section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-weight: 700;
            color: var(--primary-color);
        }

        .section-title p {
            color: #777;
        }

        /* Card */
        .blog-card {
            background: var(--white-color);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.4s ease;
            position: relative;
            /* border: 1px solid; */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .blog-card:hover {
            transform: translateY(-10px);
            /* box-shadow: 0 20px 40px rgba(0,0,0,0.1); */
        }

        /* Image */
        .blog-img {
            position: relative;
            overflow: hidden;
        }

        .blog-img img {
            width: 100%;
            transition: transform 0.5s ease;
        }

        .blog-card:hover img {
            transform: scale(1.1);
        }

        /* Overlay */
        .blog-img::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background: linear-gradient(to top, rgba(0,0,0,0.6), transparent); */
        }

        /* Content */
        .blog-content {
            padding: 20px;
        }

        .blog-content h5 {
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 10px;
            min-height: 75px;
        }

        .blog-content p {
            font-size: 14px;
            color: #666;
        }

        /* Read More */
        .read-more {
            font-size: 13px;
            font-weight: 600;
            color: var(--red-color);
            text-decoration: none;
            position: relative;
        }

        .read-more::after {
            content: '';
            width: 0;
            height: 2px;
            background: var(--red-color);
            position: absolute;
            left: 0;
            bottom: -2px;
            transition: 0.3s;
        }

        .read-more:hover::after {
            width: 100%;
        }

        /* Button */
        .see-more-btn {
            display: inline-block;
            padding: 12px 35px;
            border: 1px solid var(--red-color);
            color: var(--red-color);
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);
            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);
        }

        .see-more-btn:hover {
            background: var(--red-color);
            color: #fff;
        }
    </style>

    <section class="blog-section d-none">
        <div class="container">

            <!-- Title -->
            <div class="section-title">
                <h2>Latest Market Update</h2>
                <p>Check Latest Gold and All forex currency pair news and chart analysis updates</p>
            </div>

            <!-- Blog Grid -->
            <div class="row g-4">

                <!-- Card 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="{{ url('public/frontend/images/Bitcoin-Under-Pressure.png') }}"
                                alt="Bitcoin Under Pressure">
                        </div>
                        <div class="blog-content">
                            <h5>
                                Bitcoin Under Pressure as War Uncertainty Shakes Markets
                            </h5>
                            <p>
                                Bitcoin is facing renewed selling pressure as escalating geopolitical tensions and
                                war-related uncertainty shake global markets.
                            </p>
                            <a href="javascript:void(0)" class="read-more">READ MORE</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="{{ url('public/frontend/images/Gold-Struggles.png') }}" alt="Gold Struggles">
                        </div>
                        <div class="blog-content">
                            <h5>
                                Gold Struggles to Recover Amid Rising Middle East Tensions
                            </h5>
                            <p>
                                Gold is struggling to regain upward momentum as escalating tensions in the Middle East
                                create mixed market sentiment.
                            </p>
                            <a href="javascript:void(0)" class="read-more">READ MORE</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="{{ url('public/frontend/images/EUR-USD-on-Edge.png') }}" alt="EUR/USD on Edge">
                        </div>
                        <div class="blog-content">
                            <h5>
                                EUR/USD on Edge as Global Tensions and Jobs Data Drive Sentiment
                            </h5>
                            <p>
                                EUR/USD remains on edge as escalating global tensions and key employment data shape market
                                sentiment.
                            </p>
                            <a href="javascript:void(0)" class="read-more">READ MORE</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Button -->
            <div class="text-center mt-5">
                <a href="javascript:void(0)" class="see-more-btn">SEE MORE</a>
            </div>

        </div>
    </section>

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
