@extends('frontend.layout')

@section('content')

    @include('frontend.element.home-slider-carousel')

    <style>
        .join-section .profit-text{
            font-size: 3rem;
        }

        /* .join-section .profit-text span
        {
            color: #46e546;
            font-size: 3rem;
            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);
        } */

        .cta-background-wrap{
            margin-top: -70px;
        }

        .cta-background-wrap .signal-btn{
            font-weight: 800;
        }

        @media only screen and (max-width: 991px){
            .join-section .profit-text{
                font-size: 2rem;
            }

            .join-section .profit-text span
            {
                font-size: 2.5rem;
            }

            .main-button.is-centered{
                height: 0;
            }

            .cta-background-wrap{
                margin-top: 0px;
            }

            .cta-background-wrap .signal-btn{
                font-weight: 600;
            }
        }
    </style>
    <!-- Lunch Movement Animation -->
    <section class="join-section section-cta pt-5">
        <div class="container">
            <div class="row text-center">
                <h2 class="wow fadeInUp text-black profit-text">
                    Thousands Joined.
                    <span >PROFIT</span>
                    Started
                </h2>
            </div>
        </div>

        <link href="{{ url('public/frontend/css/lottie.css') }}" rel="stylesheet" />
        <script src="{{ url('public/frontend/js/lottie.min.js') }}"></script>
        <div class="cta-background-wrap is-relative" >

            <a href="{{ getConfigurationField('SOCIAL_TELEGRAM_LINK') }}" target="_blank" class="main-button is-centered w-inline-block">
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
    <!-- End Lunch Movement Animation -->

    <!-- Start Real numbers. Real trades. -->
    <style>
        .glass-card {
            position: relative;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(14px);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 8px 32px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.4);
            padding: 20px;
        }

        .toggle-btn {
            background: rgba(0,0,0,0.2);
            border-radius: 50px;
            padding: 5px;
            display: inline-flex;
        }

        .toggle-btn button {
            border: none;
            background: transparent;
            padding: 8px 16px;
            border-radius: 50px;
        }

        .toggle-btn .active {
            background: #111;
            color: #fff;
        }

        h2 { margin: 0; }

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
            max-height: 350px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .trade-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 5px;
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
            align-items: center;
            gap: 8px;
            padding: 0px 12px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(231,76,60,0.15), rgba(231,76,60,0.05));
            border: 1px solid rgba(231,76,60,0.3);
            position: relative;
            overflow: hidden;
        }

        /* Shine effect */
        .live-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.4), transparent);
            transform: skewX(-20deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { left: -75%; }
            100% { left: 125%; }
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
            background: rgba(255,77,79,0.5);
            animation: ripple 1.5s infinite;
        }

        @keyframes ripple {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(2.5); opacity: 0; }
        }

        /* Animated gradient text */
        .live-text {
            font-weight: 700;
            background: linear-gradient(90deg, #46e546, #62f36282, #46e546);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientMove 2s linear infinite;
            text-shadow: 0px 4px 4px rgba(98, 243, 98, 0.5);
            font-size: 3rem;
        }

        @keyframes gradientMove {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
    </style>

    <section class="join-section section-cta pt-5">
        <div class="container">
            <div class="row text-center">
                <h2 class="wow fadeInUp text-black profit-text">
                    <span class="live-badge">
                        <span class="live-dot"></span>
                        <span class="live-text">LIVE</span>
                    </span>
                    <p class="live-simple-text pt-2">
                        Verified Performance
                    </p>
                </h2>
            </div>
        </div>
        <div class="container py-3">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="py-3">
                        <div class="d-flex flex-column justify-content-center gap-2">
                            <div class="py-1">✔ Connected directly to live trading account</div>
                            <div class="py-1">✔ Auto-updated results</div>
                            <div class="py-1">✔ Verified by third-party system</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="verified-badge my-3">
                        <span class="check-icon">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        MyFXBook Verified · Updated daily
                    </div>

                    <div class="verified-badge">
                        <span class="check-icon">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        MyFXBook Verified · Updated daily
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="toggle-btn mb-4">
                <button class="active" data-type="daily">Daily</button>
                <button data-type="weekly">Weekly</button>
                <button data-type="monthly">Monthly</button>
            </div>

            <style>
                .kpi-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 18px;
                }

                .kpi-icon {
                    width: 42px;
                    height: 42px;
                    border-radius: 12px;
                    background: #d1fae5;
                    color: #0066ff;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border: 1px solid rgba(0, 102, 255, 0.15);
                }

                .kpi-trend {
                    font-size: 12px;
                    font-weight: 700;
                    color: #10b981;
                    background: #d1fae5;
                    padding: 4px 10px;
                    border-radius: 100px;
                    display: flex;
                    align-items: center;
                    gap: 4px;
                    font-family: var(--font-mono);
                    border: 1px solid rgba(16, 185, 129, 0.15);
                }

                .glass-card small{
                    vertical-align: sub;
                    font-size: 16px;
                }
            </style>
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="glass-card">
                        <div class="kpi-header">
                            <div class="kpi-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </div>
                            <span class="kpi-trend">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                +4.2%
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <h2 id="winRate">68%</h2>
                            </div>
                            <div class="col-6 text-end">
                                <small>
                                    Win Rate
                                </small>
                            </div>
                            <div class="col-12 text-center py-3">
                                vs 70.8% prior week
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-card">
                        <div class="kpi-header">
                            <div class="kpi-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg>
                            </div>
                            <span class="kpi-trend">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                +18%
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <h2 id="pips">+320</h2>
                            </div>
                            <div class="col-6 text-end">
                                <small>Net Pips</small>
                            </div>
                            <div class="col-12 text-center py-3">
                                7-day rolling total
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-card">
                        <div class="kpi-header">
                            <div class="kpi-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"></path><path d="M7 14l4-4 4 4 5-5"></path></svg>
                            </div>
                            <span class="kpi-trend">+6</span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <h2 id="trades">8</h2>
                            </div>
                            <div class="col-6 text-end">
                                <small>Trades</small>
                            </div>
                            <div class="col-12 text-center py-3">
                                21 wins · 7 losses
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-card">
                        <div class="kpi-header">
                            <div class="kpi-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                            </div>
                            <span class="kpi-trend">stable</span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <h2 id="rr">1:1.8</h2>
                            </div>
                            <div class="col-6 text-end">
                                <small>R:R</small>
                            </div>
                            <div class="col-12 text-center py-3">
                                across all closed trades
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="glass-card">
                        <canvas id="chart"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="glass-card">
                        <div class="panel-card">
                            <div class="panel-card-header">
                                <div class="panel-card-title">Recent Trades</div>
                                <div class="panel-card-meta">Last 6 closed</div>
                            </div>
                            <div class="trades-list">
                                <div class="trade-row">
                                    <div class="trade-icon down">↓</div>
                                    <div class="trade-info">
                                        <span class="trade-pair">XAU/USD</span>
                                        <span class="trade-meta">SELL · 27 Apr 14:30</span>
                                    </div>
                                    <div class="trade-pnl profit">+38</div>
                                </div>
                                <div class="trade-row">
                                    <div class="trade-icon up">↑</div>
                                    <div class="trade-info">
                                        <span class="trade-pair">EUR/USD</span>
                                        <span class="trade-meta">BUY · 27 Apr 11:15</span>
                                    </div>
                                    <div class="trade-pnl profit">+22</div>
                                </div>

                                <div class="trade-row">
                                    <div class="trade-icon down">↓</div>
                                    <div class="trade-info">
                                        <span class="trade-pair">GBP/USD</span>
                                        <span class="trade-meta">SELL · 26 Apr 16:08</span>
                                    </div>
                                    <div class="trade-pnl loss">−12</div>
                                </div>

                                <div class="trade-row">
                                    <div class="trade-icon up">↑</div>
                                    <div class="trade-info">
                                        <span class="trade-pair">USD/JPY</span>
                                        <span class="trade-meta">BUY · 26 Apr 09:55</span>
                                    </div>
                                    <div class="trade-pnl profit">+44</div>
                                </div>
                                <div class="trade-row">
                                    <div class="trade-icon up">↑</div>
                                    <div class="trade-info">
                                        <span class="trade-pair">XAU/USD</span>
                                        <span class="trade-meta">BUY · 25 Apr 15:10</span>
                                    </div>
                                    <div class="trade-pnl profit">+118</div>
                                </div>
                                <div class="trade-row">
                                    <div class="trade-icon down">↓</div>
                                    <div class="trade-info">
                                        <span class="trade-pair">EUR/USD</span>
                                        <span class="trade-meta">SELL · 25 Apr 11:30</span>
                                        </div>
                                    <div class="trade-pnl loss">−9</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

        const gradient = ctx.createLinearGradient(0,0,0,300);
        gradient.addColorStop(0, 'rgba(0,123,255,0.5)');
        gradient.addColorStop(1, 'rgba(0,123,255,0)');

        let chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri'],
                datasets: [{
                    data: dashboardData.daily.chart,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: gradient
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        document.querySelectorAll('.toggle-btn button').forEach(btn => {
            btn.addEventListener('click', function () {

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
                    @if ( getConfigurationField('SOCIAL_FACEBOOK_LINK') != '-')
                    <a href="{{ getConfigurationField('SOCIAL_FACEBOOK_LINK') }}" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif

                     @if ( getConfigurationField('SOCIAL_TWITTER_LINK') != '-')
                    <a href="{{ getConfigurationField('SOCIAL_TWITTER_LINK') }}">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    @endif

                     @if ( getConfigurationField('SOCIAL_LINKEDIN_LINK') != '-')
                    <a href="{{ getConfigurationField('SOCIAL_LINKEDIN_LINK') }}" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif

                     @if ( getConfigurationField('SOCIAL_PINTEREST_LINK') != '-')
                    <a href="{{ getConfigurationField('SOCIAL_PINTEREST_LINK') }}" target="_blank">
                        <i class="fab fa-pinterest"></i>
                    </a>
                    @endif

                     @if ( getConfigurationField('SOCIAL_YOUTUBE_LINK') != '-')
                    <a href="{{ getConfigurationField('SOCIAL_YOUTUBE_LINK') }}" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                    @endif

                     @if ( getConfigurationField('SOCIAL_WHATSAPP_LINK') != '-')
                    <a href="{{ getConfigurationField('SOCIAL_WHATSAPP_LINK') }}" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    @endif

                    @if ( getConfigurationField('SOCIAL_TELEGRAM_LINK') != '-')
                    <a href="{{ getConfigurationField('SOCIAL_TELEGRAM_LINK') }}" target="_blank">
                        <i class="fab fa-telegram"></i>
                    </a>
                    @endif

                    @if ( getConfigurationField('SOCIAL_TIKTOK_LINK') != '-')
                    <a href="{{ getConfigurationField('SOCIAL_TIKTOK_LINK') }}" target="_blank">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    @endif

                    @if ( getConfigurationField('SOCIAL_INSTAGRAM_LINK') != '-')
                    <a href="{{ getConfigurationField('SOCIAL_INSTAGRAM_LINK') }}" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                </div>
            </div>

            <div class="newsletter px-2">
                <h3>BE IN THE KNOW</h3>
                <p>Sign up to our newsletter and receive a monthly selection right in your inbox</p>
                <button class="btn btn-primary">Subscribe to our newsletter</button>
            </div>
        </div>
    </section>
    <!-- Follow Up Section End -->
@endsection
