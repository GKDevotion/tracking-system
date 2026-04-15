@extends('frontend.layout')

@section('content')
    <style>
        .forex-signal {
            padding: 100px;
        }
    </style>
    <section class="forex-signal">
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
                                                <a href="contact.php" class="btn-default btn-default-red">get started
                                                    now</a>
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
                                <li><img src="frontend/images/icon-pricing-benefit-1.svg" alt="">Get 30 day free
                                    trial
                                </li>
                                <li><img src="frontend/images/icon-pricing-benefit-2.svg" alt="">No any hidden fee
                                    pay
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
    </section>
@endsection
