        <!-- Footer Section Start -->
        <footer class="main-footer bg-section dark-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 d-none">
                        <!-- Footer Header Start -->
                        <div class="footer-header">
                            <!-- Section Title Start -->
                            <div class="section-title d-none">
                                <h2 class="wow fadeInUp text-white" data-cursor="-opaque">Partner with us and let your
                                    story be told in the voice it deserves.</h2>
                            </div>
                            <!-- Section Title End -->

                            <!-- Contact Us Circle Start -->
                            <div class="contact-us-circle d-none">
                                <a href="contact.php"><img src="images/contact-us-circle.svg" alt=""></a>
                            </div>
                            <!-- Contact Us Circle End -->
                        </div>
                        <!-- Footer Header End -->
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <!-- About Footer Start -->
                        <div class="about-footer">
                            <!-- Footer Logo Start -->
                            <div class="footer-logo d-none">
                                <img src="{{ url('public/frontend/images/footer-logo.png') }}" alt="">
                            </div>
                            <!-- Footer Logo End -->

                            <!-- About Footer Content Start -->
                            <div class="about-footer-content">
                                <p>Perfect for beginners or casual users who want to explore. Perfect for beginners or
                                    casual users.</p>
                            </div>
                            <!-- About Footer Content End -->
                        </div>
                        <!-- About Footer End -->
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <!-- Footer Links start -->
                        <div class="footer-links">
                            <h3>Contact Information</h3>
                            <!-- Footer Contact List Start -->
                            <div class="footer-contact-list">
                                <!-- Footer Contact Item Start -->

                                @if (getConfigurationField('CONTACT_PHONE') != '-')
                                    <div class="footer-contact-item">
                                        <p>Phone Number</p>
                                        <a href="tel:{!! getConfigurationField('CONTACT_PHONE') !!}">{!! getConfigurationField('CONTACT_PHONE') !!}</a>
                                    </div>
                                @endif

                                <!-- Footer Contact Item End -->

                                <!-- Footer Contact Item Start -->
                                @if (getConfigurationField('CONTACT_EMAIL') != '-')
                                    <div class="footer-contact-item">
                                        <p>Email Address</p>
                                        <a href="mailto:{!! getConfigurationField('CONTACT_EMAIL') !!}">{!! getConfigurationField('CONTACT_EMAIL') !!}</a>
                                    </div>
                                @endif

                                <!-- Footer Contact Item End -->
                            </div>
                            <!-- Footer Contact List End -->
                        </div>
                        <!-- Footer Links end -->
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <!-- Footer Links start -->
                        <div class="footer-links">
                            <!-- Footer Location Item start -->
                            @if (getConfigurationField('OFFICE_ADDRESS') != '-')
                                <div class="footer-location-item">
                                    <h3>Our Location</h3>
                                    <p>{!! getConfigurationField('OFFICE_ADDRESS') !!}</p>
                                </div>
                            @endif
                            <!-- Footer Location Item End -->

                            <!-- Footer Social Link Start -->
                            <div class="footer-social-links d-none">
                                <h3>Our Socials:</h3>
                                <ul>
                                    @if (getConfigurationField('SOCIAL_PINTEREST_LINK') != '-')
                                        <li>
                                            <a href="{{ getConfigurationField('SOCIAL_PINTEREST_LINK') }}"
                                                target="_blank"><i class="fa-brands fa-pinterest-p"></i></a>
                                        </li>
                                    @endif
                                    @if (getConfigurationField('SOCIAL_TWITTER_LINK') != '-')
                                        <li>
                                            <a href="{{ getConfigurationField('SOCIAL_TWITTER_LINK') }}"
                                                target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                                        </li>
                                    @endif
                                    @if (getConfigurationField('SOCIAL_FACEBOOK_LINK') != '-')
                                        <li>
                                            <a href="{{ getConfigurationField('SOCIAL_FACEBOOK_LINK') }}"
                                                target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                        </li>
                                    @endif
                                    @if (getConfigurationField('SOCIAL_INSTAGRAM_LINK') != '-')
                                        <li>
                                            <a href="{{ getConfigurationField('SOCIAL_INSTAGRAM_LINK') }}"
                                                target="_blank"><i class="fa-brands fa-instagram"></i></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- Footer Social Link End -->
                        </div>
                        <!-- Footer Links end -->
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <!-- Footer Links Start -->
                        <div class="footer-links footer-newsletter-form">
                            <h3>Subscribe Our Newsletter</h3>

                            <form id="newslettersForm" action="#" method="POST">
                                <div class="form-group">
                                    <input type="email" name="mail" class="form-control" id="mail"
                                        placeholder="Email Address*" required>
                                    <button type="submit" class="newsletter-btn"><img
                                            src="{{ url('public/frontend/images/arrow-white.svg') }}"
                                            alt=""></button>
                                </div>
                            </form>

                            <p>* Get the latest voiceover tips, trends, and offers.</p>
                        </div>
                        <!-- Footer Links End -->
                    </div>

                    <div class="col-lg-12">
                        <!-- Footer Copyright Start -->
                        <div class="footer-copyright">
                            <!-- Copyright Text Start -->
                            @if (!empty(trim(getConfigurationField('FOOTER_COPYRIGHT'))) && trim(getConfigurationField('FOOTER_COPYRIGHT')) !== '-')
                                <div class="footer-copyright-text">
                                    <p>{!! getConfigurationField('FOOTER_COPYRIGHT') !!}</p>
                                </div>
                            @endif
                            <!-- Copyright Text End -->

                            <!-- Footer Menu Start -->
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="{{ route('about') }}">about us</a></li>
                                    <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                                    <li><a href="{{ route('cookie') }}">Cookie Policy</a></li>
                                    <li><a href="{{ route('risk-disclosure') }}">Risk Disclosure</a></li>
                                    <li><a href="{{ route('disclaimer') }}">Disclaimer</a></li>
                                    <li><a href="{{ route('contact') }}">contact us</a></li>
                                </ul>
                            </div>
                            <!-- Footer Menu End -->
                        </div>
                        <!-- Footer Copyright End -->
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->

        <style>
            /* Popup Container */
            .offer-popup {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 9999;
                animation: slideIn 0.6s ease;
            }

            /* Glass Card */
            .offer-content {
                display: flex;
                align-items: center;
                gap: 12px;
                background: rgba(25, 27, 54, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 12px;
                padding: 12px 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                border-left: 4px solid #f73b20;
                max-width: 380px;
            }

            /* Icon */
            .offer-icon {
                font-size: 60px;
                color: #f73b20;
                position: absolute;
            }

            /* Text */
            .offer-text h6 {
                font-size: 14px;
                margin: 0;
                color: #fff;
                font-weight: 600;
            }

            .offer-text p {
                font-size: 11px;
                margin: 0;
                color: #ccc;
            }

            .offer-text {
                margin-left: 90px;
            }

            /* Timer */
            .offer-timer {
                display: flex;
                gap: 6px;
                margin-top: 5px;
            }

            .offer-timer span {
                background: #fff;
                color: #000;
                font-size: 15px;
                padding: 10px;
                border-radius: 4px;
                text-align: center;
            }

            /* Button */
            .offer-btn {
                background: linear-gradient(45deg, #f73b20, #ff6a00);
                color: #fff;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 12px;
                text-decoration: none;
                white-space: nowrap;
                transition: 0.3s;
                margin-top: -50px;
                margin-left: -65px;
                margin-right: 10px;
            }

            .offer-btn:hover {
                transform: scale(1.05);
            }

            /* Close */
            .offer-close {
                position: absolute;
                top: 5px;
                right: 8px;
                color: #fff;
                cursor: pointer;
                font-size: 14px;
            }

            /* Animation */
            @keyframes slideIn {
                from {
                    transform: translateX(-100%);
                    opacity: 0;
                }

                to {
                    transform: translateX(0);
                    opacity: 1;
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
            window.onscroll = function() {
                var nav = document.getElementById('mainNav');
                if (window.pageYOffset > 50) {
                    nav.classList.add('sticky-active');
                } else {
                    nav.classList.remove('sticky-active');
                }
            };
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
