<!DOCTYPE html>
<html>

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="ZCapital">
    
    <!-- Page Title -->
    <title>Wealthora - Growing your Future</title>
    
    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ url('public/frontend/images/favicon.png') }}" type="image/x-icon">
    
    <!-- Google Fonts Css-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    
    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ url('public/frontend/css/bootstrap.min.css') }}" media="screen">
    
    
    <!-- SlickNav Css -->
    <link rel="stylesheet" href="{{ url('public/frontend/css/slicknav.min.css') }}">
    
    <!-- Swiper Css -->
    <link rel="stylesheet" href="{{ url('public/frontend/css/swiper-bundle.min.css') }}">
    
    <!-- Font Awesome Icon Css-->
    <link rel="stylesheet" href="{{ url('public/frontend/css/all.min.css') }}"  media="screen">
    
    <!-- Animated Css -->
    <link rel="stylesheet" href="{{ url('public/frontend/css/animate.css') }}">
    
    <!-- Magnific Popup Core Css File -->
    <!-- <link rel="stylesheet" href="{{ url('public/frontend/css/magnific-popup.css') }}"> -->
    
    <!-- Mouse Cursor Css File -->
    <!-- <link rel="stylesheet" href="{{ url('public/frontend/css/mousecursor.css') }}"> -->
    
    <!-- Main Custom Css -->
    <link rel="stylesheet" href="{{ url('public/frontend/css/custom.css') }}" media="screen">
</head>

<body>

@include('frontend.element.header-menu')

@yield('content')

@include('frontend.element.footer')

</body>
</html>