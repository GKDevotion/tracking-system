@extends('frontend.layout')

@section('content')
    <!-- Page Header Start -->
    <div class="page-header" style="background: url('{{url( 'public/frontend/images/about-us.jpg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="wow fadeInUp" data-cursor="-opaque">Contact US</h1>
                        <nav class="wow fadeInUp d-none" data-wow-delay="0.2s">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">contact us</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Page Contact Us Start -->
    <div class="page-contact-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <!-- Contact Us Content Start -->
                    <div class="contact-us-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">contact us</h3>
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">Have questions? let's
                                connect <span>and create together</span></h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Contact Form Start -->
                        <div class="contact-us-form wow fadeInUp" data-wow-delay="0.4s">
                            <form id="contactForm" action="{{ route('contact.submit') }}" method="POST"
                                class="wow fadeInUp" data-wow-delay="0.2s">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-md-6 mb-4">
                                        <label class="form-label">email address</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Enter Email Address" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-md-6 mb-4">
                                        <label class="form-label">phone number</label>
                                        <input type="text" name="mobile_number" class="form-control" id="mobile_number"
                                            placeholder="Enter Phone Number" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-md-12 mb-5">
                                        <label class="form-label">message</label>
                                        <textarea name="message" class="form-control" id="message" rows="4" placeholder="Enter Message"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn-default"><span>send message</span></button>
                                        <div id="msgSubmit" class="h3 hidden"></div>
                                    </div>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                            </form>
                        </div>
                        <!-- Contact Form End -->

                    </div>
                    <!-- Contact Us Content End -->
                </div>

                <div class="col-lg-5">
                    <!-- Contact Info Box Start -->
                    <div class="contact-info-box">
                        <!-- Contact info Title Start -->
                        <div class="contact-info-title">
                            <h3 class="wow fadeInUp">Get In Touch</h3>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Have a project in mind or just exploring options?
                                We'd love to hear from you</p>
                        </div>
                        <!-- Contact info Title End -->

                        <!-- Contact Info List Start -->
                        <div class="contact-info-list">

                            <!-- Contact Info Item Start -->
                            @if (getConfigurationField('CONTACT_EMAIL') != '-')
                                <div class="contact-info-item wow fadeInUp" data-wow-delay="0.4s">
                                    <div class="icon-box">
                                        <img src="public/frontend/images/icon-mail.svg" alt="">
                                    </div>

                                    <div class="contact-info-content">
                                        <h3>Email Address</h3>
                                        <p><a
                                                href="mailto:{{ getConfigurationField('CONTACT_EMAIL') }}">{{ getConfigurationField('CONTACT_EMAIL') }}</a>
                                        </p>
                                    </div>
                                </div>
                            @endif
                            <!-- Contact Info Item End -->

                            <!-- Contact Info Item Start -->
                            @if (getConfigurationField('CONTACT_PHONE') != '-')
                                <div class="contact-info-item wow fadeInUp" data-wow-delay="0.6s">
                                    <div class="icon-box">
                                        <img src="public/frontend/images/icon-phone.svg" alt="">
                                    </div>
                                    <div class="contact-info-content">
                                        <h3>Phone Number</h3>
                                        <p><a
                                                href="tel:{{ getConfigurationField('CONTACT_PHONE') }}">{{ getConfigurationField('CONTACT_PHONE') }}</a>
                                        </p>
                                    </div>
                                </div>
                            @endif
                            <!-- Contact Info Item End -->

                            <!-- Contact Info Item Start -->
                            @if (getConfigurationField('OFFICE_ADDRESS') != '-')
                                <div class="contact-info-item wow fadeInUp" data-wow-delay="0.8s">
                                    <div class="icon-box">
                                        <img src="public/frontend/images/icon-location.svg" alt="">
                                    </div>
                                    <div class="contact-info-content">
                                        <h3>Our Address</h3>
                                        <p>{!! getConfigurationField('OFFICE_ADDRESS') !!}</p>
                                    </div>
                                </div>
                            @endif
                            <!-- Contact Info Item End -->
                        </div>
                        <!-- Contact Info List End -->

                        <!-- Contact Social List Start -->
                        <div class="contact-social-list wow fadeInUp" data-wow-delay="1s">
                            <h3>Social Media:</h3>
                            <ul>
                                @if (getConfigurationField('SOCIAL_PINTEREST_LINK') != '-')
                                    <li>
                                        <a href="{{ getConfigurationField('SOCIAL_PINTEREST_LINK') }}" target="_blank"><i
                                                class="fa-brands fa-pinterest-p"></i></a>
                                    </li>
                                @endif
                                @if (getConfigurationField('SOCIAL_TWITTER_LINK') != '-')
                                    <li>
                                        <a href="{{ getConfigurationField('SOCIAL_TWITTER_LINK') }}" target="_blank"><i
                                                class="fa-brands fa-x-twitter"></i></a>
                                    </li>
                                @endif
                                @if (getConfigurationField('SOCIAL_FACEBOOK_LINK') != '-')
                                    <li>
                                        <a href="{{ getConfigurationField('SOCIAL_FACEBOOK_LINK') }}" target="_blank"><i
                                                class="fa-brands fa-facebook-f"></i></a>
                                    </li>
                                @endif
                                @if (getConfigurationField('SOCIAL_INSTAGRAM_LINK') != '-')
                                    <li>
                                        <a href="{{ getConfigurationField('SOCIAL_INSTAGRAM_LINK') }}" target="_blank"><i
                                                class="fa-brands fa-instagram"></i></a>
                                    </li>
                                @endif
                                @if (getConfigurationField('SOCIAL_TELEGRAM_LINK') != '-')
                                    <li>
                                        <a href="{{ getConfigurationField('SOCIAL_TELEGRAM_LINK') }}" target="_blank"><i
                                                class="fa-brands fa-telegram"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <!-- Contact Social List End -->
                    </div>
                    <!-- Contact Info Box End -->
                </div>

            </div>
        </div>
    </div>

    <script>
        function submitForm() {

            let $form = $("#contactForm");
            let $btn = $("#submitBtn"); // your submit button

            // prevent multiple clicks
            $btn.prop("disabled", true).text("Submitting...");

            $.ajax({
                type: "POST",
                url: $form.attr("action"),
                data: $form.serialize(),

                success: function(response) {

                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#f73b20"
                    });

                    $form[0].reset();

                },

                error: function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Something went wrong",
                        icon: "error",
                        confirmButtonColor: "#f73b20"
                    });
                },

                complete: function() {
                    // re-enable button after request finishes
                    $btn.prop("disabled", false).text("Submit");
                }
            });
        }
    </script>
    <!-- Page Contact Us End -->
@endsection
