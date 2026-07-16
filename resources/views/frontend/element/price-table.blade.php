<div class="page-pricing">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title section-title-center">
                    <h3 class="wow fadeInUp">subscription plans</h3>
                    <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque">
                        Your Success Starts with the <span style="color: #46e546; -webkit-text-fill-color: #46e546 !important; text-shadow: 2px 3px 6px rgba(0, 0, 0, 0.18);">Right Plan</span>
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
                        .section-title h2 {
                            font-weight: 700;
                            color: var(--primary-color);
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
                                                    <strike class="me-2 text-black">
                                                        @if( (float)$val['discount_price'] > 0  )
                                                            <span>$</span>{{$val['discount_price']}}
                                                        @endif
                                                    </strike>
                                                </span>
                                                <?php endif; ?>

                                                <span style="font-size: 60px; text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.12);"><span style="font-size: 45px;">$</span>{{$val['price']}}</span>

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
                                            <a href="{{ url('purchase?plan=' . $val['link']) }}" class="btn-default get-pricing-btn-sound">
                                                Get Started Now
                                            </a>
                                            <audio id="pricingBtnSound" preload="auto">
                                                <source src="{{ url('public/frontend/audio/getChannel-click.mp3') }}" type="audio/mpeg">
                                            </audio>
                                        </div>
                                        <script>
                                            $(".get-pricing-btn-sound").on("click", function(e) {

                                                e.preventDefault();

                                                const sound = document.getElementById("pricingBtnSound");
                                                const url = this.href;

                                                sound.currentTime = 0;
                                                sound.play().catch(() => {});

                                                // Navigate after the sound starts
                                                setTimeout(function () {
                                                    window.location.href = url;
                                                }, 200); // Adjust to match your sound length
                                            });
                                        </script>
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
