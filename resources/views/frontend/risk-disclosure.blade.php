 @extends('frontend.layout')

 @section('content') 

    <!-- Page Header Start -->
    <div class="page-header bg-section parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="wow fadeInUp" data-cursor="-opaque">Risk <span>Disclosure</span></h1>
                        <nav class="wow fadeInUp" data-wow-delay="0.2s">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Risk Disclosure</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <style>
        /* HERO */

        .hero {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: white;
            padding: 120px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
        }

        .hero p {
            opacity: .8;
        }

        /* CARD */

        .risk-card {
            background: #f4f7fb;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            transition: .4s;
        }

        .risk-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
        }

        /* WARNING BOX */

        .warning-box {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        /* ICON */

        .risk-icon {
            font-size: 45px;
            color: #ffc107;
            margin-bottom: 20px;
        }

        /* TEXT */

        p {
            color: #555;
            line-height: 1.7;
        }

        /* FADE ANIMATION */

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all .6s ease;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <section class="py-5">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-9">

                    <div class="risk-card fade-in text-center">

                        <div class="risk-icon">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>

                        <div class="warning-box">

                            <strong>High Risk Warning:</strong>

                            Trading in financial markets involves significant risk and may lead to loss of capital.

                        </div>

                        <p>

                            Trading in financial markets such as <strong>Forex, Cryptocurrencies, Stocks, Indices, and
                                Metals</strong>
                            involves a high level of risk and may not be suitable for all individuals.
                            Market conditions can change rapidly, and trading activities may result in financial losses.

                        </p>

                        <p>

                            Users should carefully evaluate their <strong>financial situation, trading experience,
                                and risk tolerance</strong> before participating in any trading activity.

                        </p>

                        <p>

                            All market insights, trading signals, and analytical content provided by
                            <strong>Wealthora</strong> are intended strictly for educational and informational purposes.

                        </p>

                        <p>

                            Past performance or examples of trade setups should not be interpreted
                            as guarantees of future results.

                        </p>

                        <p>

                            By using Wealthora services, users acknowledge that all trading decisions
                            are made independently and that they assume full responsibility for
                            any financial outcomes resulting from their trading activities.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


 @endsection