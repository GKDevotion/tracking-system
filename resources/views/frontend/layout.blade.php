<!DOCTYPE html>
<html>

<head>
    <!-- Meta -->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    {{-- Dynamic SEO Meta Tags --}}
    @php
        $seo = \App\Models\SeoData::where('page_slug', request()->path())
                    ->where('status', 1)
                    ->first();
    @endphp

    <title>{{ $seo->meta_title ?? config('app.name') }}</title>

    <meta name="description" content="{{ $seo->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $seo->keywords ?? '' }}">
    <meta name="robots" content="{{ $seo->robots ?? 'index,follow' }}">
    <link rel="canonical" href="{{ $seo->canonical_url ?? url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $seo->og_title ?? $seo->meta_title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $seo->og_description ?? $seo->meta_description ?? '' }}">
    <meta property="og:image" content="{{ $seo->og_image ?? asset('default-og.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    {{-- Optional H1 Tag --}}
    <meta name="h1_tag" content="{{ $seo->h1_tag ?? '' }}">
    <meta name="author" content="ZCapital">

    <!-- Page Title -->
    <title>Wealthora - Growing your Future</title>

    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ url('public/frontend/images/favicon.png') }}" type="image/x-icon">

    <!-- Google Fonts Css-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ url('public/frontend/css/bootstrap.min.css') }}" media="screen">


    <!-- SlickNav Css -->
    <link rel="stylesheet" href="{{ url('public/frontend/css/slicknav.min.css') }}">

    <!-- Swiper Css -->
    <link rel="stylesheet" href="{{ url('public/frontend/css/swiper-bundle.min.css') }}">

    <!-- Font Awesome Icon Css-->
    <link rel="stylesheet" href="{{ url('public/frontend/css/all.min.css') }}" media="screen">

    <!-- Animated Css -->
    <link rel="stylesheet" href="{{ url('public/frontend/css/animate.css') }}">

    <!-- Magnific Popup Core Css File -->
    <!-- <link rel="stylesheet" href="{{ url('public/frontend/css/magnific-popup.css') }}"> -->

    <!-- Mouse Cursor Css File -->
    <!-- <link rel="stylesheet" href="{{ url('public/frontend/css/mousecursor.css') }}"> -->

    <!-- Main Custom Css -->
    <link rel="stylesheet" href="{{ url('public/frontend/css/custom.css?v=0.001') }}" media="screen">

    @if( env( 'APP_ENV' ) != 'local' )
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-00RBTNX5DY"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-00RBTNX5DY');
        </script>
    @endif
</head>

<body>

    @include('frontend.element.header-menu')

    @yield('content')

    @include('frontend.element.footer')

</body>

</html>
