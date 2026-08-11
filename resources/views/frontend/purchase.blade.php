 @extends('frontend.layout')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/css/intlTelInput.css">
 @section('content')
     <style>
         .checkout-container {
             margin: auto;
             margin-top: 100px;
         }

         .card {
             border: none;
             border-radius: 15px;
             box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
             overflow: hidden;
         }

         .section-title {
             border-left: 5px solid var(--red-color);
             padding-left: 15px;
             margin-bottom: 10px;
             color: #333;
         }

         /* Payment Card Styles */
         .payment-card {
             border: 2px solid #eee;
             cursor: pointer;
             transition: all 0.3s ease;
             border-radius: 12px;
             text-align: center;
             padding: 10px;
             height: 100%;
             background: #fff;
         }

         .payment-card:hover {
             transform: translateY(-5px);
             border-color: var(--red-color);
         }

         .payment-card.active {
             border-color: var(--red-color);
             box-shadow: 0 5px 15px rgba(13, 110, 253, 0.1);
         }

         /* QR Container Animation */
         .qr-container {
             background: #f8f9fa;
             padding: 30px;
             border-radius: 15px;
             border: 2px dashed #dee2e6;
             transition: all 0.4s ease;
         }

         #qrCodeImg {
             max-width: 180px;
             transition: transform 0.3s ease;
         }

         #qrCodeImg:hover {
             transform: scale(1.05);
         }

         .hidden {
             display: none;
         }

         .btn-submit {
             padding: 15px;
             font-weight: 600;
             font-size: 1.1rem;
             transition: 0.3s;
         }

     </style>
 
     @include('frontend.checkout')
 

 @endsection
