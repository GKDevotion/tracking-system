@extends('frontend.layout')

@section('content')
    <style>
        .forex-signal {
            padding: 100px 0 0 0;
        }
    </style>
    <section class="forex-signal">
        <!-- Page Pricing Start -->
        @include('frontend.element.price-table')
        <!-- Page Pricing End -->
    </section>
@endsection
