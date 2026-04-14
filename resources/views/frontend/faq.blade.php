@extends('frontend.layout')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400;600&display=swap');

        .faqs {
            padding: 100px;
        }

        .faq-title {
            font-family: 'Caveat', cursive;
            font-size: 3rem;
            font-weight: 600;
            color: #222;
        }

        .faq-subtitle {
            color: #666;
            font-size: 1rem;
        }

        .btn-tag {
            border: 1.5px solid #333;
            border-radius: 50px;
            background: transparent;
            color: #222;
            font-size: 0.875rem;
            padding: 6px 18px;
        }

        .btn-tag:hover {
            background: #f0f0f0;
        }

        .accordion-item {
            border: none;
            border-radius: 12px !important;
            margin-bottom: 12px;
            background: #f0f0f0;
            overflow: hidden;
        }

        .accordion-button {
            background: #f0f0f0;
            color: #222;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 12px !important;
            box-shadow: none !important;
        }

        .accordion-button:not(.collapsed) {
            background: #f0f0f0;
            color: #222;
            border-radius: 12px 12px 0 0 !important;
        }

        .accordion-button::after {
            filter: none;
        }

        .accordion-body {
            background: #f0f0f0;
            color: #444;
            font-size: 0.95rem;
            padding-top: 0;
        }

        .accordion {
            --bs-accordion-border-color: transparent;
        }
    </style>

    <section class="faqs">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h1 class="faq-title">Frequently Asked Questions</h1>
                <p class="faq-subtitle mt-2">If you can't find an answer that you're looking for, feel free to drop us a
                    line.</p>
                <div class="d-flex justify-content-center gap-2 mt-4 flex-wrap">
                    <button class="btn btn-tag">About the company</button>
                    <button class="btn btn-tag">Contact support</button>
                    <button class="btn btn-tag">Visit help center</button>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-9">
                    <div class="accordion" id="faqAccordion">

                        @foreach ($faqs as $key => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $key }}">
                                    <button class="accordion-button {{ $key != 0 ? 'collapsed' : '' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq{{ $key }}"
                                        aria-expanded="{{ $key == 0 ? 'true' : 'false' }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>

                                <div id="faq{{ $key }}"
                                    class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
