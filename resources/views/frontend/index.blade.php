@extends('frontend.layout')

@section('content')

    @include('frontend.element.home-slider-carousel')

    {{-- <div class="carousel-inner" style="height: 100% !important;">

        <div class="carousel-item active h-100 position-relative">
            <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover">
                <source src="{{ url('public/frontend/videos/final.mp4') }}" type="video/mp4">
            </video>
        </div>

    </div> --}}

    <style>
        .join-section .profit-text {
            font-size: 3rem;
        }

        /* .join-section .profit-text span
                {
                    color: #46e546;
                    font-size: 3rem;
                    text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);
                } */

        .cta-background-wrap {
            margin-top: -70px;
        }

        .cta-background-wrap .signal-btn {
            font-weight: 800;
        }

        .join-section .profit-text span.color-change {
            color: #46e546;
            font-size: 3rem;
            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);
        }

        @media only screen and (max-width: 991px) {
            .join-section .profit-text {
                font-size: 2rem;
            }

            .join-section .profit-text span.color-change {
                font-size: 2.5rem;
            }

            .main-button.is-centered {
                height: 0;
            }

            .cta-background-wrap {
                margin-top: 0px;
            }

            .cta-background-wrap .signal-btn {
                font-weight: 600;
            }
        }
    </style>
    <!-- Lunch Movement Animation -->
    <section class="join-section section-cta pt-5">
        <div class="container">
            <div class="row text-center">
                <h2 class="wow fadeInUp text-black profit-text">
                    Thousands Have Already
                    <span class="color-change">Joined</span>

                </h2>
            </div>
        </div>

        <link href="{{ url('public/frontend/css/lottie.css') }}" rel="stylesheet" />
        <script src="{{ url('public/frontend/js/lottie.min.js') }}"></script>
        <div class="cta-background-wrap is-relative">

            <a href="{{ getConfigurationField('SOCIAL_TELEGRAM_LINK') }}" target="_blank"
                class="main-button is-centered w-inline-block">
                <div class="button-text-wrap" style="display: block;">
                    <div class="btn-text text-white signal-btn">TODAY SIGNALS</div>
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

    <!-- Start Real numbers. Real trades. -->
    <style>
        .glass-card {
            position: relative;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(14px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.4);
            padding: 20px;
            transition: all 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* Smooth hover top move */
        .glass-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.08);
        }

        /* Optional premium glow effect */
        .glass-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .glass-card:hover::before {
            opacity: 1;
        }

        .toggle-btn {
            background: var(--secondary-color);
            border-radius: 50px;
            padding: 5px;
            display: inline-flex;
        }

        .toggle-btn button {
            border: none;
            background: transparent;
            padding: 12px 24px;
            border-radius: 50px;
        }

        .toggle-btn .active {
            background: #111;
            color: #fff;
        }

        h2 {
            margin: 0;
        }

        /* Recent Trades Styling */
        .panel-card {
            height: 100%;
        }

        .panel-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .panel-card-title {
            font-size: 20px;
            font-weight: 600;
        }

        .panel-card-meta {
            font-size: 12px;
            color: #888;
        }

        .trades-list {
            max-height: 375px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .trade-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12.5px 5px;
        }

        .trade-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }

        .trade-icon.up {
            background: rgba(0, 200, 120, 0.15);
            color: #00a86b;
        }

        .trade-icon.down {
            background: rgba(255, 80, 80, 0.15);
            color: #ff4d4f;
        }

        .trade-info {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .trade-pair {
            font-weight: 600;
        }

        .trade-meta {
            font-size: 12px;
            color: #888;
        }

        .trade-pnl {
            font-weight: 600;
            font-size: 1.3rem;
        }

        .trade-pnl.profit {
            color: #00a86b;
        }

        .trade-pnl.loss {
            color: #ff4d4f;
        }

        .verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            background: rgba(255, 255, 255, 1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 0, 0, 0.7);
            border-radius: 14px;
            font-size: 13px;
            font-weight: 500;
            color: #4a5568;
            box-shadow: 0 1px 2px rgba(10, 14, 26, 0.04), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
        }

        .live-badge {
            display: inline-flex;
            align-items: baseline;
            gap: 8px;
            padding: 0px 12px;
            border-radius: 20px;
            /* background: linear-gradient(135deg, rgba(231,76,60,0.15), rgba(231,76,60,0.05)); */
            border: 1px solid #e0e6ed;
            position: relative;
            overflow: hidden;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);
        }

        /* Shine effect */
        .live-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-20deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% {
                left: -75%;
            }

            100% {
                left: 125%;
            }
        }

        /* Live dot with ripple */
        .live-dot {
            width: 10px;
            height: 10px;
            background: #ff4d4f;
            border-radius: 50%;
            position: relative;
        }

        .live-dot::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: rgba(255, 77, 79, 0.5);
            animation: ripple 1.5s infinite;
        }

        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        /* Animated gradient text */
        .live-text {
            font-weight: 700;
            background: linear-gradient(90deg, red, #ff0000, red);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientMove 2s linear infinite;
            text-shadow: 0px 4px 4px rgb(243 98 98 / 50%);
            font-size: 3rem;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% center;
            }

            100% {
                background-position: 200% center;
            }
        }
    </style>

    <section class="join-section section-cta" style="margin-top: -90px;">
        <div class="container d-none">
            <div class="row text-center">
                <h2 class="wow fadeInUp text-black profit-text">
                    <span class="live-badge">
                        <span style="font-size: 2rem;">Tracked</span>
                        <span class="live-text">LIVE</span>
                        <span style="font-size: 2rem;">Result</span>
                        <span class="live-dot"></span>
                    </span>
                    <p class="live-simple-text pt-2 d-none">
                        Verified Performance
                    </p>
                </h2>
            </div>
        </div>

        <style>
            :root {
                --red: #FF3B30;
                --red-soft: #FFF0EE;
                --green: #1FAE5C;
                --green-soft: #E9FBF1;
                --ink: #1A1A1A;
                --muted: #8B8F98;
                --line: #ECEDF0;
            }

            .wrap {
                max-width: 1100px;
                margin: 0 auto;
                padding: 48px 16px;
            }

            .divider-heading {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 14px;
                margin-bottom: 40px;
                flex-wrap: wrap;
            }

            .divider-line {
                height: 1px;
                background: var(--line);
                flex: 1 1 80px;
                max-width: 140px;
            }

            .divider-heading .label {
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--red);
                font-weight: 700;
                font-size: 1.5rem;
                white-space: nowrap;
            }

            .badge-card {
                border-radius: 14px;
                height: 90px;
                display: flex;
                align-items: center;
                justify-content: center;
                /* background: #fff; */
                box-shadow: 0px 1px 6px rgba(0, 0, 0, 0.6);
                padding: 35px;
            }

            /* .badge-card img,
            .badge-card .logo-text {
                max-height: 34px;
            } */

            .myfxbook-pill {
                /* background: #111; */
                border-radius: 10px;
                padding: 10px 18px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .myfxbook-pill span {
                font-weight: 800;
                font-size: 1.3rem;
                color: #fff;
            }

            .myfxbook-pill span em {
                color: #FF7A3D;
                font-style: normal;
            }

            .check-circle {
                width: 22px;
                height: 22px;
                border-radius: 50%;
                background: var(--green);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-size: .7rem;
            }

            .fxblue-text {
                font-weight: 800;
                font-size: 1.5rem;
                letter-spacing: 2px;
            }

            .fxblue-text .blue {
                color: #2D6CDF;
            }

            .shield-icon {
                width: 74px;
                height: 74px;
                border-radius: 50%;
                background: var(--red);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-size: 1.8rem;
                box-shadow: 0 8px 20px rgba(255, 59, 48, .25);
            }

            .toggle-group .btn {
                border-radius: 999px !important;
                font-weight: 600;
                padding: 8px 22px;
                border: 1px solid var(--line);
                color: var(--ink);
            }

            .toggle-group .btn.active {
                background: var(--red);
                border-color: var(--red);
                color: #fff;
            }

            .stat-card {
                border: 1px solid var(--line);
                border-radius: 16px;
                padding: 20px;
                height: 100%;
                background: #fff;
                display: flex;
                align-items: center;
                gap: 30px;
                text-align: left;
            }

            .stat-icon {
                width: 46px;
                height: 46px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                flex: 0 0 auto;
            }

            .icon-red {
                background: var(--red-soft);
                color: var(--red);
            }

            .icon-green {
                background: var(--green-soft);
                color: var(--green);
            }

            .stat-value {
                font-size: 2.2rem;
                /* font-weight: 800; */
                line-height: 1.1;
            }

            .stat-label {
                font-weight: 700;
                font-size: .95rem;
                margin-top: 2px;
                color: ##665b5b;
            }

            .stat-sub {
                color: var(--muted);
                font-size: .85rem;
                margin-top: 2px;
            }

            @media (max-width:767px) {
                .stat-value {
                    font-size: 1.6rem;
                }

                .shield-icon {
                    width: 60px;
                    height: 60px;
                    font-size: 1.4rem;
                }

                .divider-line{
                    display:none;
                }

                .divider-heading{
                    margin-top: 40px;
                }
            }
        </style>

        <div class="wrap">

            <!-- Verified heading -->
            <div class="divider-heading">
                <span class="divider-line"></span>
                <span class="label">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L4 5V11C4 16 7.5 19.5 12 21C16.5 19.5 20 16 20 11V5L12 2Z" stroke="currentColor"
                            stroke-width="2" stroke-linejoin="round" />
                        <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    Result Verified by Third-Party
                </span>
                <span class="divider-line"></span>
            </div>

            <!-- Verification badges row -->
            <div class="row g-3 align-items-center mb-5 justify-content-center">
                <div class="col-12 col-md-4">
                    <div class="badge-card">
                        <div class="myfxbook-pill">
                            <img src="{{url('public/frontend/images/home/MyFXBook-Verified.png')}}" title="MyFXBook Verified" />
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-2 d-flex justify-content-center">
                    <style>
                        /* ============================= */
                        /* 3D TRUSTED SHIELD ICON */
                        /* ============================= */

                        .trusted-shield{
                            position: relative;
                            width: 100px;
                            height: auto;
                            margin: auto;
                            animation: floating 2s ease-in-out infinite;
                            transform-style: preserve-3d;
                        }

                        /* FLOATING EFFECT */
                        @keyframes floating{
                            0%,100%{
                                transform: translateY(0px);
                            }
                            50%{
                                transform: translateY(-12px);
                            }
                        }

                        /* MOBILE */
                        @media(max-width:768px){

                            .trusted-shield{
                                width: 100px;
                                height: auto;
                            }
                        }
                    </style>
                    <div class="trusted-shield">
                        <img src="{{url('public/frontend/images/Trusted-Sheild.png')}}">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="badge-card">
                        <img src="{{url('public/frontend/images/home/BlueFX-Verified.webp')}}" title="Blue FX Verified" />
                    </div>
                </div>
            </div>

            <!-- Daily / Weekly / Monthly toggle -->
            <div class="text-center mb-5">
                <div class="btn-group toggle-group gap-3" role="group">
                    <button type="button" class="btn d-none">Daily</button>
                    <button type="button" class="btn active">Weekly</button>
                    <button type="button" class="btn">Monthly</button>
                </div>
            </div>

            <!-- Stats grid -->
            
            {{-- <div class="row g-3 mb-4 d-none">

                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon icon-red">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
                                <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2" />
                                <circle cx="12" cy="12" r="1" fill="currentColor" />
                            </svg>
                        </div>
                        <div class="stat-text">
                            <div class="stat-value" style="">89%</div>
                            <div class="stat-label">Win Rate</div>
                            <div class="stat-sub d-none">Winning Accuracy</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon icon-green">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                <path d="M3 17L9 11L13 15L21 7" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15 7H21V13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="stat-text">
                            <div class="stat-value" style="color:var(--green)"> +7711</div>
                            <div class="stat-label">Net Pips</div>
                            <div class="stat-sub d-none">Total Profit</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon icon-red">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                <rect x="4" y="12" width="3" height="8" fill="currentColor" />
                                <rect x="10.5" y="8" width="3" height="12" fill="currentColor" />
                                <rect x="17" y="4" width="3" height="16" fill="currentColor" />
                            </svg>
                        </div>
                        <div class="stat-text">
                            <div class="stat-value">
                                <span>36 <small style="font-size: 16px; color: gray;">Trade</small></span><br>

                            </div>
                            <div class="stat-label">
                                <span style="color:var(--green); font-size: 16px; font-weight: 500;">32 win, </span>
                                <span style="color:var(--red); font-size: 16px; font-weight: 500;">4 loss</span>
                            </div>
                            <div class="stat-sub d-none">Total Executed</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon icon-green">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                <path d="M12 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <path d="M5 7H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <circle cx="6" cy="10" r="3" stroke="currentColor"
                                    stroke-width="2" />
                                <circle cx="18" cy="10" r="3" stroke="currentColor"
                                    stroke-width="2" />
                            </svg>
                        </div>
                        <div class="stat-text">
                            <div class="stat-value" style="">1:2.4</div>
                            <div class="stat-label">R:R Ratio</div>
                            <div class="stat-sub d-none">Risk to Reward</div>
                        </div>
                    </div>
                </div>

            </div> --}}

            <div class="row g-3 mb-4">

                    <!-- Win Rate -->
                    @if (getConfigurationField('WIN_RATE') && getConfigurationField('WIN_RATE') != '-')
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <div class="stat-icon icon-red">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="12" cy="12" r="1" fill="currentColor"/>
                                    </svg>
                                </div>

                                <div class="stat-text">
                                    <div class="stat-value">
                                        {!! (int) getConfigurationField('WIN_RATE') !!}%
                                    </div>

                                    <div class="stat-label">
                                        {!! getConfigurationDisplayName('WIN_RATE') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Net Pips -->
                    @if (getConfigurationField('NET_PIPS') && getConfigurationField('NET_PIPS') != '-')
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <div class="stat-icon icon-green">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                        <path d="M3 17L9 11L13 15L21 7"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <path d="M15 7H21V13"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                </div>

                                <div class="stat-text">
                                    <div class="stat-value text-success"> 
                                        +{!! (int) getConfigurationField('NET_PIPS') !!}
                                    </div>

                                    <div class="stat-label">
                                        {!! getConfigurationDisplayName('NET_PIPS') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Total Trades -->
                    @if (getConfigurationField('TOTAL_TRADES') && getConfigurationField('TOTAL_TRADES') != '-')
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <div class="stat-icon icon-red">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                        <rect x="4" y="12" width="3" height="8" fill="currentColor"/>
                                        <rect x="10.5" y="8" width="3" height="12" fill="currentColor"/>
                                        <rect x="17" y="4" width="3" height="16" fill="currentColor"/>
                                    </svg>
                                </div>

                                <div class="stat-text">
                                    <div class="stat-value">
                                        {!! (int) getConfigurationField('TOTAL_TRADES') !!}
                                        <small style="font-size:16px;color:#777;">{!! getConfigurationDisplayName('TOTAL_TRADES') !!}</small>
                                    </div>

                                    <div class="stat-label">
                                        <span style="color:var(--green);">
                                            {!! (int) getConfigurationField('WIN_TRADES') !!} <span>{!! getConfigurationDisplayName('WIN_TRADES') !!}</span>,
                                        </span>

                                        <span style="color:var(--red);">
                                            {!! (int) getConfigurationField('LOSS_TRADES') !!} <span>{!! getConfigurationDisplayName('LOSS_TRADES') !!}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- RR Ratio -->
                    @if (getConfigurationField('RR_RATIO') && getConfigurationField('RR_RATIO') != '-')
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <div class="stat-icon icon-green">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 3V21" stroke="currentColor" stroke-width="2"/>
                                        <path d="M5 7H19" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="6" cy="10" r="3" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="18" cy="10" r="3" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                </div>

                                <div class="stat-text">
                                    <div class="stat-value">
                                        {!! getConfigurationField('RR_RATIO') !!}
                                    </div>

                                    <div class="stat-label">
                                        R:R Ratio
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

            </div>

            @include('frontend.element.result')
            
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dashboardData = {
            daily: {
                winRate: "68%",
                pips: "+320",
                trades: "8",
                rr: "1:1.8",
                chart: [50, 80, 60, 90, 120]
            },
            weekly: {
                winRate: "75%",
                pips: "+1247",
                trades: "28",
                rr: "1:2.4",
                chart: [100, 300, 500, 800, 1200]
            },
            monthly: {
                winRate: "82%",
                pips: "+4820",
                trades: "96",
                rr: "1:2.9",
                chart: [500, 1200, 2000, 3500, 4800]
            }
        };

        const ctx = document.getElementById('chart').getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0,123,255,0.5)');
        gradient.addColorStop(1, 'rgba(0,123,255,0)');

        let chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                datasets: [{
                    data: dashboardData.daily.chart,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: gradient
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        document.querySelectorAll('.toggle-btn button').forEach(btn => {
            btn.addEventListener('click', function() {

                document.querySelectorAll('.toggle-btn button')
                    .forEach(b => b.classList.remove('active'));

                this.classList.add('active');

                const type = this.getAttribute('data-type');
                const data = dashboardData[type];

                document.getElementById('winRate').innerText = data.winRate;
                document.getElementById('pips').innerText = data.pips;
                document.getElementById('trades').innerText = data.trades;
                document.getElementById('rr').innerText = data.rr;

                chart.data.datasets[0].data = data.chart;
                chart.update();
            });
        });
    </script>
    <!-- End Real numbers. Real trades. -->

    <!-- Start Analysis report -->
    {{-- <div class="our-empact d-none">
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
    </div> --}}
    <!-- End Analysis Report -->

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
                        <style>
                            .pricing-header h2 small {
                                font-size: 20px;
                                font-weight: 600;
                            }
                        </style>
                        <!-- Pricing Tab Item Start -->
                        <div class="pricing-tab-item" id="annually">
                            <div class="row">

                                @foreach ($planArr as $k => $val)
                                    <div class="col-lg-4 col-md-6">
                                        <!-- Pricing Box Start -->
                                        <div class="pricing-item {{ $val['price_item_class'] }}">

                                            <!-- Pricing Header Start -->
                                            <div class="pricing-header">
                                                <h3>{{ $k }}</h3>

                                                <h2 style="font-weight: 400; font-size: 28px;">
                                                    <?php if (isset($val['discount_price']) && $val['discount_price'] !== '') : ?>
                                                    <span class="text-muted">
                                                        <strike class="me-2">
                                                            <span>$</span>{{$val['discount_price']}}
                                                        </strike>
                                                    </span>
                                                    <?php endif; ?>

                                                    <span style="font-size: 60px; text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.18);"><span style="font-size: 45px;">$</span>{{$val['price']}}</span>

                                                    @if (!empty($val['type']))
                                                        <small>/{{ $val['type'] }}</small>
                                                    @endif
                                                </h2>
                                            </div>
                                            <!-- Pricing Header End -->

                                            <!-- Pricing Item Content Start -->
                                            <div class="pricing-item-content">
                                                <p>
                                                    {{ $val['value'] }}
                                                </p>
                                            </div>
                                            <!-- Pricing Item Content End -->

                                            <!-- Pricing Button Start -->
                                            <div class="pricing-btn">
                                                <a href="{{ url('purchase?plan=' . $val['link']) }}" class="btn-default">
                                                    Get Started Now
                                                </a>
                                            </div>
                                            <!-- Pricing Button End -->

                                            <!-- Pricing body Start -->
                                            <div class="pricing-body">
                                                <h3 class="d-none">What's Included:</h3>

                                                <ul>
                                                    @foreach ($val['feature'] as $f)
                                                        <li>{!! $f !!}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <!-- Pricing body End -->

                                            @if (!empty($val['remove']) && is_array($val['remove']) && count($val['remove']) > 0)
                                                <!-- Pricing body Start -->
                                                <div class="pricing-body-exclude mt-1">
                                                    <h3 class="d-none">What's Exclude:</h3>

                                                    <ul>
                                                        @if (!empty($val['remove']) && is_array($val['remove']))
                                                            @foreach ($val['remove'] as $f)
                                                                <li>{!! $f !!}</li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                                <!-- Pricing body End -->
                                            @endif

                                        </div>
                                        <!-- Pricing Box End -->
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <!-- Pricing Tab Item End -->
                    </div>

                    <!-- Pricing Benifit List Start -->
                    <div class="pricing-benefit-list wow fadeInUp" data-wow-delay="0.6s">
                        <ul>
                            <li><img src="{{url('public/frontend/images/icon-pricing-benefit-1.svg')}}" alt="Get free trial">Get free trial
                            </li>
                            <li><img src="{{url('public/frontend/images/icon-pricing-benefit-2.svg')}}" alt="No Hidden Fees">No Hidden Fees
                            </li>
                            <li><img src="{{url('public/frontend/images/icon-pricing-benefit-3.svg')}}" alt="You can cancel anytime">You can cancel
                                anytime </li>
                        </ul>
                    </div>
                    <!-- Pricing Benifit List End -->
                </div>

            </div>
        </div>
    </div>
    <!-- Page Pricing End -->

    @include('frontend.element.blog')

    <!-- Page Team Single Start -->
    <div class="page-team-single pt-0 mt-0 mt-md-5">
        <div class="container">
            <div class="row">
                <!-- Team Single Content Start -->
                <div class="team-single-content">
                    <!-- Team Member Info Start -->
                    <div class="team-member-info pb-0 pb-md-5">

                        <!-- Section Title Start -->
                        <div class="section-title pt-5">
                            <h2 class="wow fadeInUp" data-cursor="-opaque">What we <span>Are</span></h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Team Member Info Counters Start -->
                        <div class="team-member-info-counters">
                            <!-- Member Info Counter Item Start -->
                            @if (getConfigurationField('YEAR_OF_EXPERIENCE') && getConfigurationField('YEAR_OF_EXPERIENCE') != '-')
                                <div class="member-info-counter-item">
                                    <h2>
                                        <span class="counter">
                                            {!! getConfigurationField('YEAR_OF_EXPERIENCE') !!}
                                        </span>+
                                    </h2>
                                    <p>{!! getConfigurationDisplayName('YEAR_OF_EXPERIENCE') !!}</p>
                                </div>
                            @endif
                            <!-- Member Info Counter Item End -->

                            <!-- Member Info Counter Item Start -->
                            @if (getConfigurationField('SIGNAL_ACCURACY') && getConfigurationField('SIGNAL_ACCURACY') != '-')
                                <div class="member-info-counter-item">
                                    <h2>
                                        <span class="counter">
                                            {!! getConfigurationField('SIGNAL_ACCURACY') !!}
                                        </span>%
                                    </h2>
                                    <p>{!! getConfigurationDisplayName('SIGNAL_ACCURACY') !!}</p>
                                </div>
                            @endif
                            <!-- Member Info Counter Item End -->

                            <!-- Member Info Counter Item Start -->
                            @if (getConfigurationField('PIPS_MONTHLY') && getConfigurationField('PIPS_MONTHLY') != '-')
                                <div class="member-info-counter-item">
                                    <h2>
                                        <span class="counter">
                                            {!! getConfigurationField('PIPS_MONTHLY') !!}
                                        </span>+
                                    </h2>
                                    <p>{!! getConfigurationDisplayName('PIPS_MONTHLY') !!}</p>
                                </div>
                            @endif
                            <!-- Member Info Counter Item End -->

                            <!-- Member Info Counter Item Start -->
                            @if (getConfigurationField('COUNTRIES') && getConfigurationField('COUNTRIES') != '-')
                                <div class="member-info-counter-item">
                                    <h2>
                                        <span class="counter">
                                            {!! getConfigurationField('COUNTRIES') !!}
                                        </span>
                                        +
                                    </h2>
                                    <p>{!! getConfigurationDisplayName('COUNTRIES') !!}</p>
                                </div>
                            @endif
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
                        
                        @if (getConfigurationField('HUMAN_HYBRID_ANALYSIS') && getConfigurationField('HUMAN_HYBRID_ANALYSIS') != '-')
                            <div class="skills-progress-bar">
                                <div class="skillbar" data-percent="95%">
                                    <div class="skill-data">
                                        <div class="skill-title">
                                            {!! getConfigurationDisplayName('HUMAN_HYBRID_ANALYSIS') !!}
                                        </div>
                                        <div class="skill-no">{!! getConfigurationField('HUMAN_HYBRID_ANALYSIS') !!}%</div>
                                    </div>
                                    <div class="skill-progress">
                                        <div class="count-bar"></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- Skills Progress Bar End -->

                        <!-- Skills Progress Bar Start -->
                        @if (getConfigurationField('VERIFIED_RESULTS') && getConfigurationField('VERIFIED_RESULTS') != '-')
                            <div class="skills-progress-bar">
                                <!-- Skill Item Start -->
                                <div class="skillbar" data-percent="98%">
                                    <div class="skill-data">
                                        <div class="skill-title"> {!! getConfigurationDisplayName('VERIFIED_RESULTS') !!}</div>
                                        <div class="skill-no">{!! getConfigurationField('VERIFIED_RESULTS') !!}%</div>
                                    </div>
                                    <div class="skill-progress">
                                        <div class="count-bar"></div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                            </div>
                        @endif
                        <!-- Skills Progress Bar End -->

                        <!-- Skills Progress Bar Start -->
                        @if (getConfigurationField('RISK_MANAGEMENT') && getConfigurationField('RISK_MANAGEMENT') != '-')
                            <div class="skills-progress-bar">
                                <!-- Skill Item Start -->
                                <div class="skillbar" data-percent="92%">
                                    <div class="skill-data">
                                        <div class="skill-title">{!! getConfigurationDisplayName('RISK_MANAGEMENT') !!}</div>
                                        <div class="skill-no">{!! getConfigurationField('RISK_MANAGEMENT') !!}%</div>
                                    </div>
                                    <div class="skill-progress">
                                        <div class="count-bar"></div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                            </div>
                        @endif
                        <!-- Skills Progress Bar End -->

                        <!-- Skills Progress Bar Start -->
                        @if (getConfigurationField('SIGNAL_SUCCESS_RATE') && getConfigurationField('SIGNAL_SUCCESS_RATE') != '-')
                            <div class="skills-progress-bar">
                                <!-- Skill Item Start -->
                                <div class="skillbar" data-percent="87%">
                                    <div class="skill-data">
                                        <div class="skill-title">{!! getConfigurationDisplayName('SIGNAL_SUCCESS_RATE') !!}</div>
                                        <div class="skill-no">{!! getConfigurationField('SIGNAL_SUCCESS_RATE') !!}%</div>
                                    </div>
                                    <div class="skill-progress">
                                        <div class="count-bar"></div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                            </div>
                        @endif
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
            padding: 80px 0;
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
            background-color: var(--primary-color);
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
            z-index: 0;
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
                    @if (getConfigurationField('SOCIAL_FACEBOOK_LINK') != '-')
                        <a href="{{ getConfigurationField('SOCIAL_FACEBOOK_LINK') }}" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif

                    @if (getConfigurationField('SOCIAL_TWITTER_LINK') != '-')
                        <a href="{{ getConfigurationField('SOCIAL_TWITTER_LINK') }}">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                    @endif

                    @if (getConfigurationField('SOCIAL_LINKEDIN_LINK') != '-')
                        <a href="{{ getConfigurationField('SOCIAL_LINKEDIN_LINK') }}" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif

                    @if (getConfigurationField('SOCIAL_PINTEREST_LINK') != '-')
                        <a href="{{ getConfigurationField('SOCIAL_PINTEREST_LINK') }}" target="_blank">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    @endif

                    @if (getConfigurationField('SOCIAL_YOUTUBE_LINK') != '-')
                        <a href="{{ getConfigurationField('SOCIAL_YOUTUBE_LINK') }}" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif

                    @if (getConfigurationField('SOCIAL_WHATSAPP_LINK') != '-')
                        <a href="{{ getConfigurationField('SOCIAL_WHATSAPP_LINK') }}" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    @endif

                    @if (getConfigurationField('SOCIAL_TELEGRAM_LINK') != '-')
                        <a href="{{ getConfigurationField('SOCIAL_TELEGRAM_LINK') }}" target="_blank">
                            <i class="fab fa-telegram"></i>
                        </a>
                    @endif

                    @if (getConfigurationField('SOCIAL_TIKTOK_LINK') != '-')
                        <a href="{{ getConfigurationField('SOCIAL_TIKTOK_LINK') }}" target="_blank">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    @endif

                    @if (getConfigurationField('SOCIAL_INSTAGRAM_LINK') != '-')
                        <a href="{{ getConfigurationField('SOCIAL_INSTAGRAM_LINK') }}" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                </div>
            </div>

            <div class="newsletter px-2">
                <h3 class="mb-3">NEVER MISS A SIGNAL</h3>
                <p>Get live forex & gold trade setups delivered instantly.</p>
                <button class="btn btn-primary mt-2">Profit Starts Here</button>
            </div>
        </div>
    </section>
    <!-- Follow Up Section End -->
@endsection
