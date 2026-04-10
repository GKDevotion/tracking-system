 @extends('frontend.layout')

 @section('content') 

    <!-- Page Header Start -->
    <div class="page-header bg-section parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="wow fadeInUp" data-cursor="-opaque">Disc<span>losure</span></h1>
                        <nav class="wow fadeInUp" data-wow-delay="0.2s">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Disclosure</li>
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

        .hero{
            background:linear-gradient(135deg,#141e30,#243b55);
            color:white;
            padding:120px 0;
            text-align:center;
        }

        .hero h1{
            font-size:48px;
            font-weight:700;
        }

        .hero p{
            opacity:.8;
        }

        /* CARD */

        .disclaimer-card{
            background:rgba(255,255,255,0.85);
            backdrop-filter:blur(12px);
            padding:45px;
            border-radius:15px;
            box-shadow:0 20px 40px rgba(0,0,0,0.08);
            transition:.4s;
        }

        .disclaimer-card:hover{
            transform:translateY(-8px);
            box-shadow:0 25px 50px rgba(0,0,0,0.15);
        }

        /* WARNING BOX */

        .alert-disclaimer{
            background:#fdecea;
            border-left:5px solid #dc3545;
            padding:20px;
            border-radius:8px;
            margin-bottom:30px;
        }

        /* ICON */

        .icon-box{
            font-size:45px;
            color:#dc3545;
            margin-bottom:15px;
        }

        /* TEXT */

        p{
            line-height:1.7;
            color:#555;
        }

        /* FADE */

        .fade-in{
            opacity:0;
            transform:translateY(30px);
            transition:all .6s ease;
        }

        .fade-in.show{
            opacity:1;
            transform:translateY(0);
        }
    </style>

    <section class="py-5">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-9">

                    <div class="disclaimer-card fade-in text-center">

                        <div class="icon-box">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>

                        <div class="alert-disclaimer">

                            <strong>Important Notice:</strong>

                            The information provided on Wealthora should not be interpreted as financial or investment
                            advice.

                        </div>

                        <p>

                            The information, market insights, analysis, and trading signals provided by
                            <strong>Wealthora</strong> are intended strictly for educational and informational purposes.

                        </p>

                        <p>

                            Content shared through the Wealthora platform represents general market perspectives
                            based on analysis and should not be interpreted as financial, investment,
                            legal, or tax advice.

                        </p>

                        <p>

                            Trading signals and trade setups provided by Wealthora reflect analytical opinions
                            and are shared to illustrate potential market opportunities. They should not be
                            considered recommendations or guarantees of trading outcomes.

                        </p>

                        <p>

                            Users are solely responsible for evaluating any information provided and for making
                            their own independent trading decisions.

                        </p>

                        <p>

                            Wealthora shall not be held liable for any financial losses, damages, or consequences
                            resulting from the use of information, insights, or signals shared through the platform.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


 @endsection