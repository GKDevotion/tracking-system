<style>
    /* Hero Section */
    .hero-section {
        min-height: 90vh;
        /* background: url('images/background/red-shadow-background.png') no-repeat center center; */
        background-size: cover;
        padding-top: 100px;
        position: relative;
        color: #333;
    }

    /* Navbar Initial State */
    .custom-nav {
        padding: 20px 0;
        transition: all 0.4s ease-in-out;
    }

    .nav-container {
        /* background: #ef3c2814; */
        /* Semi-transparent pill */
        backdrop-filter: blur(10px);
        border-radius: 50px;
        /* padding: 10px 30px; */
        transition: all 0.4s ease;
    }

    .nav-link {
        color: #000 !important;
        font-weight: 500;
        margin: 0 5px;
    }

    .nav-link:hover,
    .nav-link.active,
    .sticky-active .nav-link.active,
    .sticky-active .nav-link:hover {
        color: #d62828 !important;
    }

    /* Sticky Navbar State (On Scroll) */
    .sticky-active {
        background: #ffffff !important;
        padding: 10px 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .sticky-active .nav-container {
        background: transparent;
        max-width: 100%;
        /* Full width update */
    }

    .sticky-active .nav-link {
        color: #333 !important;
    }

    /* Left Side Content Animation */
    .content-animate {
        animation: fadeInUp 1s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Right Side Candle Animation */
    .candle-float {
        animation: float 4s ease-in-out infinite;
        max-width: 100%;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    /* Button Hover */
    .hover-btn {
        transition: transform 0.3s ease;
    }

    .hover-btn:hover {
        transform: scale(1.05);
        background-color: white;
        color: #d62828 !important;
    }
</style>

<nav class="navbar navbar-expand-lg fixed-top custom-nav sticky-active" id="mainNav">
    <div class="container nav-container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ url('public/frontend/images/logo.png') }}" alt="Wealthora" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto text-uppercase">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('forex.signals') ? 'active' : '' }}" href="{{ route('forex.signal') }}">
                        FOREX SIGNALS
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('results') ? 'active' : '' }}" href="#">
                        RESULTS
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('news.analysis') ? 'active' : '' }}"
                        href="{{ route('news.analysis') }}">
                        NEWS ANALYSIS
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}" href="{{ route('faqs') }}">
                        FAQ
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('education') ? 'active' : '' }}" href="{{ route('education') }}">
                        EDUCATION
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        ABOUT US
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">
                        CONTACT US
                    </a>
                </li>
            </ul>
            <div class="d-flex" style="padding: 0 50px 0 0;">
                <style>
                    .join-tg-channel {
                        margin: 12px 10px;
                        text-align: center;
                        border-radius: 25px;
                    }

                    .channel-blob-btn {
                        z-index: 1;
                        position: relative;
                        padding: 10px 20px;
                        text-align: center;
                        text-transform: uppercase;
                        color: var(--logo-color);
                        font-size: 15px;
                        font-weight: bold;
                        background-color: transparent;
                        outline: none;
                        border: none;
                        transition: color 0.5s;
                        cursor: pointer;
                        border-radius: 25px;
                    }
                    .channel-blob-btn:before {
                        content: "";
                        z-index: 1;
                        position: absolute;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        border: 2px solid var(--logo-color);
                        border-radius: 30px;
                    }
                    .channel-blob-btn:after {
                        content: "";
                        z-index: -2;
                        position: absolute;
                        left: 3px;
                        top: 3px;
                        width: 100%;
                        height: 100%;
                        transition: all 0.3s 0.2s;
                        border-radius: 30px;
                    }
                    .channel-blob-btn:hover {
                        color: #FFFFFF;
                        border-radius: 30px;
                    }
                    .channel-blob-btn:hover:after {
                        transition: all 0.3s;
                        left: 0;
                        top: 0;
                        border-radius: 30px;
                    }
                    .channel-blob-btn__inner {
                        z-index: -1;
                        overflow: hidden;
                        position: absolute;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        border-radius: 30px;
                        background: #ffffff;
                    }
                    .channel-blob-btn__blobs {
                        position: relative;
                        display: block;
                        height: 100%;
                        filter: url("#goo");
                    }
                    .channel-blob-btn__blob {
                        position: absolute;
                        top: 2px;
                        width: 25%;
                        height: 100%;
                        background: var(--logo-color-hover);
                        border-radius: 100%;
                        transform: translate3d(0, 150%, 0) scale(1.7);
                        transition: transform 0.45s;
                    }
                    @supports (filter: url("#goo")) {
                        .channel-blob-btn__blob {
                            transform: translate3d(0, 150%, 0) scale(1.4);
                        }
                    }
                    .channel-blob-btn__blob:nth-child(1) {
                        left: 0%;
                        transition-delay: 0s;
                    }
                    .channel-blob-btn__blob:nth-child(2) {
                        left: 30%;
                        transition-delay: 0.08s;
                    }
                    .channel-blob-btn__blob:nth-child(3) {
                        left: 60%;
                        transition-delay: 0.16s;
                    }
                    .channel-blob-btn__blob:nth-child(4) {
                        left: 90%;
                        transition-delay: 0.24s;
                    }
                    .channel-blob-btn:hover .channel-blob-btn__blob {
                        transform: translateZ(0) scale(1.7);
                    }
                    @supports (filter: url("#goo")) {
                        .channel-blob-btn:hover .channel-blob-btn__blob {
                            transform: translateZ(0) scale(1.4);
                        }
                    }
                </style>
                <div class="join-tg-channel">
                    <a class="channel-blob-btn" href="https://t.me/Wealthoraofficial" target="_blank">
                        Join Channel
                        <span class="channel-blob-btn__inner">
                        <span class="channel-blob-btn__blobs">
                            <span class="channel-blob-btn__blob"></span>
                            <span class="channel-blob-btn__blob"></span>
                            <span class="channel-blob-btn__blob"></span>
                            <span class="channel-blob-btn__blob"></span>
                        </span>
                        </span>
                    </a>
                </svg>
            </div>
            <div class="d-flex" style="padding: 0 50px 0 0;">
                <a href="{{url('forex-signal')}}" class="btn btn-logo rounded-pill px-4 py-2 fw-bold">Get Started →</a>
            </div>
        </div>
    </div>
</nav>
