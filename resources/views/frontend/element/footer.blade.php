        <!-- Footer Section Start -->
        <footer class="main-footer bg-section dark-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 d-none">
                        <!-- Footer Header Start -->
                        <div class="footer-header">
                            <!-- Section Title Start -->
                            <div class="section-title d-none">
                                <h2 class="wow fadeInUp text-white" data-cursor="-opaque">Partner with us and let your story be told in the voice it deserves.</h2>
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
                                <p>Perfect for beginners or casual users who want to explore. Perfect for beginners or casual users.</p>
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
                                <div class="footer-contact-item">
                                    <p>Phone Number</p>
                                    <a href="+(123) 654 789">+(123) 654 789</a>
                                </div>
                                <!-- Footer Contact Item End -->

                                <!-- Footer Contact Item Start -->
                                <div class="footer-contact-item">
                                    <p>Email Address</p>
                                    <a href="mailto:info@domainname.com">info@domainname.com</a>
                                </div>
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
                            <div class="footer-location-item">
                                <h3>Our Location</h3>
                                <p>4517 Washington Ave. manchester kentucky 39495</p>
                            </div>
                            <!-- Footer Location Item End -->

                            <!-- Footer Social Link Start -->
                            <div class="footer-social-links d-none">
                                <h3>Our Socials:</h3>
                                <ul>
                                    <li><a href="#"><i class="fa-brands fa-pinterest-p"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
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
                                    <input type="email" name="mail" class="form-control" id="mail" placeholder="Email Address*" required>
                                    <button type="submit" class="newsletter-btn"><img src="{{ url('public/frontend/images/arrow-white.svg') }}" alt=""></button>
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
                            <div class="footer-copyright-text">
                                <p>Copyright © 2025 All Rights Reserved.</p>
                            </div>
                            <!-- Copyright Text End -->

                            <!-- Footer Menu Start -->
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="about.php">about us</a></li>
                                    <li><a href="terms-conditions.php">Terms & Conditions</a></li>
                                    <li><a href="privacy-policy.php">Privacy Policy</a></li>
                                    <li><a href="cookie-policy.php">Cookie Policy</a></li>
                                    <li><a href="risk-disclousure.php">Risk Disclousure</a></li>
                                    <li><a href="disclaimer.php">Disclaimer</a></li>
                                    <li><a href="contact.php">contact us</a></li>
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
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
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
        <script src="{{ url('public/frontend/js/SmoothScroll.js') }}"></script>
        
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
    