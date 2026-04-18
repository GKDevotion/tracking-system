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
                <a href="{{url('forex-signal')}}" class="btn btn-logo rounded-pill px-4 py-2 fw-bold">Get Started →</a>
            </div>
        </div>
    </div>
</nav>
