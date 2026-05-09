
        <footer>
            <div class="footer-top">
                <div class="container">
                <div class="row g-4 row-stretch">
            
                    <!-- Brand Column -->
                    <div class="col-12 col-md-4 col-lg-3">
                    <style> 
                        .navbar-brand-footer {
                                margin: 0; 
                            }

                        .navbar-brand-footer img{
                            width: 80%;
                            height: auto;
                        }
    
                    </style>
                        <a class="navbar-brand-footer" href="{{ url('/') }}">
                        <img src="{{ url('public/frontend/images/logo.png') }}" alt="Wealthora" height="40">
                    </a> 
                    <p class="footer-desc">
                        Professional forex trading signals with clear entries, stop loss, and take profit levels. Built for traders who value discipline, transparency, and results.
                    </p>
                    </div>
            
                    <!-- Product Column -->
                    <div class="col-6 col-md col-divider">
                        <h6 class="footer-col-title">Product</h6>
                        <ul class="footer-links">
                            <li><a href="{{ url('forex-signal') }}">Forex Signals</a></li>
                            <li><a href="#">Results</a></li>
                            <li><a href="{{ url('news-analysis') }}">News Analysis</a></li>
                            <li><a href="{{ url('education') }}">Education</a></li>
                            <li><a href="{{ url('faqs') }}">FAQ</a></li>
                        </ul>
                    </div>
            
                    <!-- Service Column -->
                    <div class="col-6 col-md col-divider">
                        <h6 class="footer-col-title">Service</h6>
                        <ul class="footer-links">
                            <li><a href="#">How It Works</a></li>
                            <li><a href="#">Pricing</a></li>
                            <li><a href="#">Performance</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Risk Management</a></li>
                        </ul>
                    </div>
            
                    <!-- Company Column -->
                    <div class="col-6 col-md col-divider">
                        <h6 class="footer-col-title">Company</h6>
                        <ul class="footer-links">
                            <li><a href="{{ url('about') }}">About Us</a></li>
                            <li><a href="{{ url('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
            
                    <!-- Get Started Column -->
                    <div class="col-6 col-md col-divider">
                        <h6 class="get-started-title">Get Started</h6>
                        <a href="{{ url('forex-signal') }}" class="btn-get-started">
                            Get Started <span class="arrow">→</span>
                        </a>
                    </div>
            
                </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="container">
                <p>© 2026 Wealthora. All rights reserved.</p>
                <ul class="footer-bottom-links">
                    <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ url('cookie-policy') }}">Cookies Policy</a></li>
                    <li><a href="{{ url('risk-disclosure') }}">Risk Disclosure</a></li>
                    <li><a href="{{ url('disclaimer') }}">Disclaimer</a></li>
                    <li><a href="{{ url('terms-and-conditions') }}">Terms and Conditions</a></li>
                </ul>
                </div>
            </div>
        </footer>   

        <style>
            footer {
                background-color: #EBEBEB;;
            }
        
            .footer-top {
                padding: 100px 100px;
            }
        
            .footer-logo-text {
                font-size: 1.5rem;
                font-weight: 800;
                letter-spacing: 2px;
                color: #E84025;
                text-transform: uppercase;
            }
        
            .logo-icon {
                width: 44px;
                height: 38px;
                margin-right: 8px;
                vertical-align: middle;
            }
        
            .footer-desc {
                font-size: 0.92rem;
                color: #000;
                line-height: 1.75;
                margin-top: 18px;
                max-width: 290px;
            }
        
            .footer-col-title {
                font-size: 1rem;
                font-weight: 700;
                color: #000;
                margin-bottom: 20px;
            }
        
            .footer-links {
                list-style: none;
                padding: 0;
                margin: 0;
            }
        
            .footer-links li {
                margin-bottom: 14px;
            }
        
            .footer-links a {
                text-decoration: none;
                color: #000;
                font-size: 0.93rem;
                font-weight: 400;
                transition: color 0.2s ease;
                }
        
            .footer-links a:hover {
                color: #E84025;
            }
        
            .get-started-title {
                font-size: 1rem;
                font-weight: 700;
                color: #000;
                margin-bottom: 20px;
            }
        
            .btn-get-started {
                background-color: #E84025;
                color: #fff;
                border: none;
                border-radius: 50px;
                padding: 13px 28px;
                font-size: 0.95rem;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
                transition: background-color 0.2s ease, transform 0.15s ease;
                white-space: nowrap;
            }
        
            .btn-get-started:hover {
                background-color: #c93520;
                color: #fff;
                transform: translateY(-1px);
            }
        
            .btn-get-started .arrow {
                font-size: 1.1rem;
            }
        
            /* Vertical dividers — full height using stretch row */
            .row-stretch {
                align-items: stretch;
            }
        
            .col-divider {
                border-left: 1.5px solid #ccc;
                padding-left: 30px;
            }
        
            .footer-bottom {
                padding: 22px 0;
                text-align: center;
                position: relative;
            }

            .footer-bottom::before {
                content: "";
                position: absolute;
                top: 0;
                left: 16%;   /* ← gap from left */
                right: 16%;  /* ← gap from right */
                height: 1.5px;
                background-color: #ccc;
            }
                    
            .footer-bottom p {
                font-size: 0.975rem;
                color: #000;
                margin-bottom: 20px;
            }
        
            .footer-bottom-links {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 0;
            }
        
            .footer-bottom-links li {
                display: flex;
                align-items: center;
            }
        
            .footer-bottom-links li a {
                text-decoration: none;
                color: #000;
                font-size: 1rem;
                padding: 0 14px;
                margin-bottom: 40px;
                transition: color 0.2s;
            }
        
            .footer-bottom-links li a:hover {
                color: #E84025;
            }
        
            .footer-bottom-links li + li::before {
                content: "|";
                color: #ccc;
                margin-bottom: 40px;
                font-size: 0.875rem;
            }
        
            @media (max-width: 767.98px) {
                .col-divider {
                    border-left: none;
                    padding-left: 0;
                    border-top: 1.5px solid #ccc;
                    padding-top: 28px;
                    margin-top: 10px;
                }
            
                .footer-desc {
                    max-width: 100%;
                }
            
                .footer-bottom-links li a {
                    padding: 0 8px;
                }
            }
        </style>
 
        <!-- Offer Popup -->
        <div class="offer-popup" id="offerPopup">

            <div class="offer-content">

                <!-- Close -->
                <span class="offer-close" onclick="closeOffer()">×</span>

                <!-- Left Icon -->
                <div class="offer-icon">
                    ⏰
                </div>

                <!-- Content -->
                <div class="offer-text">
                    <h6>Limited Offer</h6>
                    <p>Trading Signals Ends In</p>

                    <!-- Timer -->
                    <div class="offer-timer" id="countdown">
                        <span><b id="days">00</b>d</span>
                        <span><b id="hours">00</b>h</span>
                        <span><b id="minutes">00</b>m</span>
                        <span><b id="seconds">00</b>s</span>
                    </div>
                </div>

                <!-- Button -->
                <a href="#" class="offer-btn">Get Now</a>

            </div>
        </div>

        <!-- SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Jquery Library File -->
        <script src="{{ url('public/frontend/js/jquery-3.7.1.min.js') }}"></script>

        <script src="{{ url('public/frontend/js/jquery-3.7.1.min.js') }}"></script>

        <!-- Bootstrap js file -->
        <script src="{{ url('public/frontend/js/bootstrap.min.js') }}"></script>

        <!-- Validator js file -->
        <script src="{{ url('public/frontend/js/validator.min.js') }}"></script>
        <script src="{{ url('public/frontend/js/jquery.slicknav.js') }}"></script>
        <!-- Swiper js file -->
        <script src="{{ url('public/frontend/js/swiper-bundle.min.js') }}"></script>

        <!-- Counter js file -->
        <script src="{{ url('public/frontend/js/jquery.waypoints.min.js') }}"></script>
        <script src="{{ url('public/frontend/js/jquery.counterup.min.js') }}"></script>

        <!-- Magnific js file -->
        <script src="{{ url('public/frontend/js/jquery.magnific-popup.min.js') }}"></script>

        <!-- Parallax js -->
        <script src="{{ url('public/frontend/js/parallaxie.js') }}"></script>

        <!-- MagicCursor js file -->
        {{-- <!-- <script src="{{ url('public/frontend/js/gsap.min.js') }}"></script> -->
        <!-- <script src="{{ url('public/frontend/js/magiccursor.js') }}"></script> --> --}}

        <!-- Text Effect js file -->
        <script src="{{ url('public/frontend/js/SplitText.js') }}"></script>
        <script src="{{ url('public/frontend/js/ScrollTrigger.min.js') }}"></script>

        <!-- SmoothScroll -->
        {{-- <script src="{{ url('public/frontend/js/SmoothScroll.js') }}"></script> --}}

        <!-- YTPlayer js File -->
        <script src="{{ url('public/frontend/js/jquery.mb.YTPlayer.min.js') }}"></script>

        <!-- Wow js file -->
        <script src="{{ url('public/frontend/js/wow.min.js') }}"></script>

        <!-- Main Custom js file -->
        <script src="{{ url('public/frontend/js/function.js') }}"></script>

        <script>
            const fadeElements = document.querySelectorAll('.fade-in');

            function checkFade() {
                fadeElements.forEach(el => {
                    const top = el.getBoundingClientRect().top;
                    if (top < window.innerHeight - 100) {
                        el.classList.add('show');
                    }
                });
            }

            window.addEventListener('scroll', checkFade);
            checkFade();
        </script>

        <script>
            // Sticky Header Logic
            // window.onscroll = function() {
            //     var nav = document.getElementById('mainNav');
            //     if (window.pageYOffset > 50) {
            //         nav.classList.add('sticky-active');
            //     } else {
            //         nav.classList.remove('sticky-active');
            //     }
            // };
        </script>

        <script>
            function startCountdown() {
                let endDate = new Date();
                endDate.setHours(endDate.getHours() + 20); // 5 hour offer

                function updateTimer() {
                    let now = new Date().getTime();
                    let distance = endDate - now;

                    if (distance < 0) return;

                    let d = Math.floor(distance / (1000 * 60 * 60 * 24));
                    let h = Math.floor((distance / (1000 * 60 * 60)) % 24);
                    let m = Math.floor((distance / (1000 * 60)) % 60);
                    let s = Math.floor((distance / 1000) % 60);

                    document.getElementById("days").innerText = d;
                    document.getElementById("hours").innerText = h;
                    document.getElementById("minutes").innerText = m;
                    document.getElementById("seconds").innerText = s;
                }

                setInterval(updateTimer, 1000);
            }

            startCountdown();

            /* Close */
            function closeOffer() {
                document.getElementById("offerPopup").style.display = "none";
            }
        </script>
