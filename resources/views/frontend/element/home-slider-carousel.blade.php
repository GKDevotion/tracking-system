<style>

    /* ── Carousel container ── */
    #mainCarousel {
        width: 100%;
        margin-top: 50px;
    }

    .carousel-inner {
        width: 100%;
    }

    /* .carousel-item{
        height: 95vh;
    } */

    /* ── Each slide is a banner image ── */
    .carousel-item img {
        width: 100%;
        /* height: 420px; */
        object-fit: cover;
        display: block;
    }

    /* ── Responsive heights ── */
    @media (max-width: 991px) {
        .carousel-item img {
            height: 300px;
        }
    }

    @media (max-width: 575px) {
        .carousel-item img {
            height: 200px;
        }
    }

    /* ── Prev / Next buttons ── */
    .carousel-control-prev,
    .carousel-control-next {
        width: 44px;
        height: 44px;
        background: rgba(232, 56, 13, .85);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
        transition: background .2s;
    }

    .carousel-control-prev {
        left: 14px;
    }

    .carousel-control-next {
        right: 14px;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background: #c42e0b;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 16px;
        height: 16px;
    }

    /* ── Dot indicators ── */
    .carousel-indicators [data-bs-target] {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: none;
        background: #ccc;
        opacity: 1;
        transition: background .2s, transform .2s;
    }

    .carousel-indicators .active {
        background: #E8380D;
        transform: scale(1.3);
    }


    .hero-slider {
        position: relative;
        min-height: calc(100vh - 40px);
        background: var(--black);
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    .hero-slider-bg {
        position: absolute;
        inset: 0;
        background:
        radial-gradient(ellipse 80% 60% at 65% 50%, rgba(200, 16, 46, 0.18) 0%, transparent 60%),
        radial-gradient(ellipse 40% 40% at 10% 80%, rgba(200, 16, 46, 0.08) 0%, transparent 50%);
    }

    .hero-slider-grid {
        position: absolute;
        inset: 0;
        background-image:
        linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        background-size: 60px 60px;
    }

    .hero-slider-content {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
        padding: 80px 0;
    }

    .hero-slider-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(200, 16, 46, 0.15);
        border: 1px solid rgba(200, 16, 46, 0.3);
        color: #ff6b7a;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 100px;
        margin-bottom: 24px;
    }

    .hero-slider-badge span {
        width: 6px;
        height: 6px;
        background: var(--red);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
        transform: scale(1);
        opacity: 1;
        }

        50% {
        transform: scale(1.5);
        opacity: 0.6;
        }
    }

    .hero-slider-title {
        font-family: var(--font-display);
        font-size: clamp(2.8rem, 5vw, 4.2rem);
        font-weight: 900;
        line-height: 1.05;
        color: var(--white);
        margin-bottom: 20px;
    }

    .hero-slider-title em {
        color: var(--red);
        font-style: normal;
    }

    .hero-slider-desc {
        font-size: 1.05rem;
        color: rgba(0, 0, 0, 0.65);
        max-width: 480px;
        line-height: 1.8;
        margin-bottom: 36px;
    }

    .hero-slider-actions {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 48px;
    }

    .hero-slider-stats {
        display: flex;
        gap: 32px;
        flex-wrap: wrap;
    }

    .hero-slider-stat-divider {
        width: 1px;
        background: rgba(255, 255, 255, 0.12);
    }

    .hero-slider-stat-num {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 700;
        color: rgb(0, 0, 0);
        line-height: 1;
    }

    .hero-slider-stat-num span {
        color: var(--red);
    }

    .hero-slider-stat-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
        margin-top: 4px;
    }

    .hero-slider-visual {
        position: relative;
    }

    .hero-slider-card-main {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.10);
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 32px 80px rgba(0, 0, 0, 0.4);
    }

    .hero-slider-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .hero-slider-card-title {
        font-size: 13px;
        font-weight: 600;
        color: rgba(0, 0, 0, 0.691);
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .hero-slider-card-badge {
        font-size: 11px;
        font-weight: 600;
        color: #4ade80;
        background: rgba(74, 222, 128, 0.1);
        padding: 3px 8px;
        border-radius: 4px;
    }

    .portfolio-rows {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .portfolio-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 8px;
        transition: background .2s;
    }

    .portfolio-row:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .portfolio-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .portfolio-name {
        font-size: 13px;
        font-weight: 600;
        color: rgb(3, 3, 3);
    }

    .portfolio-cat {
        font-size: 11px;
        color: rgba(0, 0, 0, 0.4);
    }

    .portfolio-bar-wrap {
        flex: 1;
    }

    .portfolio-bar-bg {
        height: 4px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 2px;
        overflow: hidden;
    }

    .portfolio-bar {
        height: 100%;
        border-radius: 2px;
    }

    .portfolio-pct {
        font-size: 12px;
        font-weight: 600;
        color: rgb(0, 0, 0);
        text-align: right;
        margin-top: 3px;
    }

    .hero-slider-card-float {
        position: absolute;
        background: rgba(0, 0, 0, 0.08);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 10px;
        padding: 14px 18px;
    }

    .hero-slider-card-float.f1 {
        top: -75px;
        right: -25px;
        z-index: 1;
    }

    .hero-slider-card-float.f2 {
        bottom: -75px;
        left: -25px;
    }

    .float-label {
        font-size: 10px;
        color: rgba(0, 0, 0, 0.5);
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .float-value {
        font-family: var(--font-display);
        font-size: 22px;
        font-weight: 700;
        color: rgb(0, 0, 0);
        margin: 2px 0;
    }

    .float-value span {
        color: var(--red);
        font-size: 14px;
    }

    .float-sub {
        font-size: 11px;
        color: rgba(0, 0, 0, 0.4);
    }
</style>

<div id="mainCarousel"
        class="carousel slide"
        data-bs-ride="carousel"
        data-bs-interval="6000">

    <!-- Indicators -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">

        @if( false )
            <!-- Video Slide -->
            <div class="carousel-item active">
                <video id="carouselVideo"
                    class="d-block w-100"
                    autoplay
                    muted
                    playsinline
                    preload="auto">
                    <source src="{{ asset('storage/app/public/home-slider/trade-with-verify-signals.mp4') }}" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>
        @endif

        <!-- Content Slide -->
        <div class="carousel-item d-none">
            <section class="hero-slider">
                <div class="hero-slider-bg"></div>
                <div class="hero-slider-grid"></div>
                <div class="container">
                    <div class="hero-slider-content">
                        <div class="hero-slider-left">
                        <div class="hero-slider-badge"><span></span> SEBI Registered Investment Advisor</div>
                            <h1 class="hero-slider-title">
                                Your Bridge to<br>
                                <em>Financial</em><br>
                                Freedom
                            </h1>
                            <p class="hero-slider-desc">
                                Expert-driven financial planning, wealth management and investment advisory services — personalized for every stage of your life.
                            </p>
                            <div class="hero-slider-actions">
                                <a href="#contact" class="btn btn-primary">Start Your Journey <i class="fas fa-arrow-right"></i></a>
                                <a href="#services" class="btn btn-outline" style="color:rgba(255,255,255,0.8); border-color:rgba(255,255,255,0.2)">Explore Services</a>
                            </div>
                            <div class="hero-slider-stats">
                                <div>
                                    <div class="hero-slider-stat-num">₹2,400<span>Cr+</span></div>
                                    <div class="hero-slider-stat-label">AUM Managed</div>
                                </div>
                                <div class="hero-slider-stat-divider"></div>
                                <div>
                                    <div class="hero-slider-stat-num">8,500<span>+</span></div>
                                    <div class="hero-slider-stat-label">Happy Clients</div>
                                </div>
                                <div class="hero-slider-stat-divider"></div>
                                <div>
                                    <div class="hero-slider-stat-num">18<span>+</span></div>
                                    <div class="hero-slider-stat-label">Years Experience</div>
                                </div>
                                <div class="hero-slider-stat-divider"></div>
                            </div>
                        </div>
                        <div class="hero-slider-visual">
                            <div class="hero-slider-card-float f1" data-aos="fade-left" data-aos-delay="400">
                                <div class="float-label">Portfolio Return</div>
                                <div class="float-value">+24.6<span>%</span></div>
                                <div class="float-sub">YTD FY 2024-25</div>
                            </div>
                            <div class="hero-slider-card-main" data-aos="fade-up" data-aos-delay="200">
                                <div class="hero-slider-card-header">
                                    <div class="hero-slider-card-title">Portfolio Allocation</div>
                                    <div class="hero-slider-card-badge">▲ Active</div>
                                </div>
                                <div class="portfolio-rows">
                                    <div class="portfolio-row">
                                        <div class="portfolio-icon" style="background:rgba(59,130,246,0.15); color:#3b82f6">📊</div>
                                        <div>
                                            <div class="portfolio-name">Equity Funds</div>
                                            <div class="portfolio-cat">High Growth</div>
                                        </div>
                                        <div class="portfolio-bar-wrap">
                                            <div class="portfolio-bar-bg"><div class="portfolio-bar" style="width:40%; background:#3b82f6"></div></div>
                                            <div class="portfolio-pct">40%</div>
                                        </div>
                                    </div>
                                    <div class="portfolio-row">
                                        <div class="portfolio-icon" style="background:rgba(200,16,46,0.15); color:var(--red)">🏠</div>
                                        <div>
                                            <div class="portfolio-name">Real Estate</div>
                                            <div class="portfolio-cat">Stable Returns</div>
                                        </div>
                                        <div class="portfolio-bar-wrap">
                                            <div class="portfolio-bar-bg"><div class="portfolio-bar" style="width:25%; background:var(--red)"></div></div>
                                            <div class="portfolio-pct">25%</div>
                                        </div>
                                    </div>
                                    <div class="portfolio-row">
                                        <div class="portfolio-icon" style="background:rgba(234,179,8,0.15); color:#eab308">🥇</div>
                                        <div>
                                            <div class="portfolio-name">Gold & Bonds</div>
                                            <div class="portfolio-cat">Hedge</div>
                                        </div>
                                        <div class="portfolio-bar-wrap">
                                            <div class="portfolio-bar-bg"><div class="portfolio-bar" style="width:20%; background:#eab308"></div></div>
                                            <div class="portfolio-pct">20%</div>
                                        </div>
                                    </div>
                                    <div class="portfolio-row">
                                        <div class="portfolio-icon" style="background:rgba(74,222,128,0.15); color:#4ade80">💵</div>
                                        <div>
                                            <div class="portfolio-name">Debt Funds</div>
                                            <div class="portfolio-cat">Low Risk</div>
                                        </div>
                                        <div class="portfolio-bar-wrap">
                                            <div class="portfolio-bar-bg"><div class="portfolio-bar" style="width:15%; background:#4ade80"></div></div>
                                            <div class="portfolio-pct">15%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hero-slider-card-float f2" data-aos="fade-right" data-aos-delay="500">
                                <div class="float-label">New Clients</div>
                                <div class="float-value">+247<span> this month</span></div>
                                <div class="float-sub">Across India & NRI</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Image Slide -->
        <div class="carousel-item active">
            <a href="https://t.me/Wealthoraofficial" target="_blank">
                <img src="{{ asset('storage/app/public/home-slider/website-07.png') }}"
                    class="d-block w-100"
                    alt="Money Making Machine">
            </a>
        </div>

    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const carouselElement = document.getElementById('mainCarousel');
    const carousel = new bootstrap.Carousel(carouselElement, {
        interval: 6000,
        ride: 'carousel'
    });

    const video = document.getElementById('carouselVideo');

    carouselElement.addEventListener('slid.bs.carousel', function () {

        const activeSlide = carouselElement.querySelector('.carousel-item.active');

        if (activeSlide.contains(video)) {
            carousel.pause();
            video.currentTime = 0;
            video.playbackRate = 1.0; // 2X Speed
            video.play();
        } else {
            video.pause();
            video.currentTime = 0;
            video.playbackRate = 1.0; // Reset (optional)
            carousel.cycle();
        }

    });

    video.addEventListener('ended', function () {
        carousel.next();
        carousel.cycle();
    });

});
</script>
