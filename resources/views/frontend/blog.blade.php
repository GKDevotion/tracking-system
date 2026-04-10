@extends('frontend.layout')

@section('content')
    <style>
        /* Section */
        .news-analysis-section {
            padding: 100px 0;
        }
    </style>
    <section class="news-analysis-section">
        @include('frontend.element.blog')
    </section>
@endsection
