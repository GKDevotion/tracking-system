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

     <div class="container checkout-container animate__animated animate__fadeIn py-5">
         <div class="card p-4 p-md-5">
             <h2 class="text-center mb-4 fw-bold">Premium Plan Checkout</h2>

             <form id="unifiedForm" class="needs-validation" novalidate method="POST" action="{{ route('checkout.store') }}"
                 enctype="multipart/form-data">
                 @csrf
                 <input type="hidden" name="plan" value="{{ request('plan') }}">
                 <input type="hidden" name="payment_type" id="paymentType" value="trc20">

                 <div class="mb-4">
                     <h4 class="section-title">Personal Information</h4>
                     <div class="row g-3">
                         <div class="col-md-6">
                             <label class="form-label mb-0">First Name *</label>
                             <input type="text" class="form-control form-control-lg" id="firstName" name="first_name"
                                 required>
                             <div class="invalid-feedback">Required</div>
                         </div>
                         <div class="col-md-6">
                             <label class="form-label mb-0">Last Name *</label>
                             <input type="text" class="form-control form-control-lg" id="lastName" name="last_name"
                                 required>
                         </div>
                         <div class="col-md-6">
                             <label class="form-label mb-0">Email *</label>
                             <input type="email" class="form-control form-control-lg" id="email" name="email"
                                 required>
                         </div>
                         <div class="col-md-6">
                             <label class="form-label mb-0">Country *</label>
                             <select class="form-select " name="country" required>
                                 <option value="">Select Country</option>
                                 @foreach ($countries as $country)
                                     <option value="{{ $country->id }}"
                                         {{ old('country') == $country->id ? 'selected' : '' }}>
                                         {{ $country->name }}
                                     </option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                 </div>

                 <div class="mb-4 animate__animated animate__fadeInUp">
                     <h4 class="section-title">Receiving Signals</h4>
                     <p class="text-muted small">Where should we send your trading signals?</p>
                     <div class="d-flex gap-4 mb-3">
                         <div class="form-check">
                             <input class="form-check-input" type="radio" name="platform" id="optTelegram"
                                 value="telegram" checked>
                             <label class="form-check-label" for="optTelegram">Telegram</label>
                         </div>
                         <div class="form-check">
                             <input class="form-check-input" type="radio" name="platform" id="optWhatsApp"
                                 value="whatsapp">
                             <label class="form-check-label" for="optWhatsApp">WhatsApp</label>
                         </div>
                     </div>

                     <div class="row g-3">
                         <div class="col-md-6" id="tgField">
                             <label class="form-label mb-0">Telegram Username *</label>
                             <input type="text" class="form-control" id="telegramUser" name="telegram_username"
                                 placeholder="@username" required>
                         </div>
                         <div class="col-md-6">
                             <label class="form-label mb-0">Phone Number *</label>
                             <input  type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Your Mobile Number"
                                 required style="width: 570px;">
                         </div>
                     </div>
                 </div>

                 <?php
                if( isset( $_GET['plan'] ) && $_GET['plan'] != "free" ){
                    ?>
                 <div class="mb-4 animate__animated animate__fadeInUp">
                     <h4 class="section-title">Payment Option</h4>
                     <div class="row g-3 mb-4">
                         <div class="col-4">
                             <div class="row">
                                 <div class="col-md-12 mb-2">
                                     <div class="payment-card active" onclick="selectPayment('trc20', this)">
                                         <img src="https://www.forexgdp.com/wp-content/uploads/2024/12/USDT-tether-trc-20-token-logo.png"
                                             width="150" class="mb-2">
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="payment-card" onclick="selectPayment('bep20', this)">
                                         <img src="https://www.forexgdp.com/wp-content/uploads/2024/12/usdt-bep20-address.png"
                                             width="150" class="mb-2">
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-8">
                             <div class="qr-container text-center animate__animated animate__zoomIn" id="qrSection">
                                 <h5 id="networkTitle" class="fw-bold">USDT - TRC20 - Tron Network</h5>
                                 <img id="qrCodeImg" src="public/frontend/images/QR-Code-usdt-tron-trc20-address-gdp.png"
                                     alt="QR" class="my-3">
                                 <p class="text-primary fw-bold text-break" id="walletAddr">
                                     TGjYaSW5StCyejzv8KebpkjsjDaxtxnBdh</p>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="mb-4">
                     <h4 class="section-title">Confirm Payment</h4>
                     <label class="form-label mb-0 fw-bold">Upload Transaction Screenshot / PDF *</label>
                     <input type="file" class="form-control form-control-lg" id="proofFile" name="proof_file"
                         accept="image/*,.pdf" required>
                 </div>
                 <?php
                }?>

                 <button type="submit" class="btn btn-primary btn-lg w-100 btn-submit shadow" id="submitBtn">
                     Confirm & Complete Checkout
                 </button>
             </form>

             <div id="statusMessage" class="mt-4 alert hidden animate__animated animate__fadeIn"></div>
         </div>
     </div>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/js/intlTelInput.min.js"></script>
<script>
    const input = document.querySelector("#phone");

    window.intlTelInput(input, {
        initialCountry: "in", // default India
        separateDialCode: true,
        preferredCountries: ["in", "us", "gb"],
    });

    // Data Configuration
    const paymentData = {
        'trc20': {
            title: 'USDT - TRC20 - Tron Network',
            addr: 'TGjYaSW5StCyejzv8KebpkjsjDaxtxnBdh',
            qr: 'public/frontend/images/QR-Code-usdt-tron-trc20-address-gdp.png'
        },
        'bep20': {
            title: 'USDT - BEP20 - BNB - BCS Network',
            addr: '0xb65Ec1860d11Ce558132B083A80018F8015d9A73',
            qr: 'public/frontend/images/QR-Code-usdt-bep20-bnb-bsc-network-gdp.png'
        }
    };

    // 1. Toggle Telegram/WhatsApp Logic
    const tgRadio = document.getElementById('optTelegram');
    const waRadio = document.getElementById('optWhatsApp');
    const tgField = document.getElementById('tgField');
    const tgInput = document.getElementById('telegramUser');

    function toggleComm() {
        if (tgRadio.checked) {
            tgField.classList.remove('hidden');
            tgInput.setAttribute('required', '');
        } else {
            tgField.classList.add('hidden');
            tgInput.removeAttribute('required');
        }
    }
    tgRadio.addEventListener('change', toggleComm);
    waRadio.addEventListener('change', toggleComm);

    // 2. Dynamic Payment & QR Logic
    function selectPayment(type, element) {
        // Active states
        document.querySelectorAll('.payment-card').forEach(el => el.classList.remove('active'));
        element.classList.add('active');

        // Set hidden input
        document.getElementById('paymentType').value = type;

        // Animation Refresh
        const qrSection = document.getElementById('qrSection');
        qrSection.classList.remove('animate__zoomIn');
        void qrSection.offsetWidth; // Trigger reflow
        qrSection.classList.add('animate__zoomIn');

        // Update Content
        document.getElementById('networkTitle').innerText = paymentData[type].title;
        document.getElementById('walletAddr').innerText = paymentData[type].addr;
        document.getElementById('qrCodeImg').src = `${paymentData[type].qr}`;
    }

    // 3. Form Submission & Mail Notification Simulation
    const form = document.getElementById('unifiedForm');
    const statusMsg = document.getElementById('statusMessage');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        // Visual Feedback
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Processing...`;

        // Send AJAX request
        const formData = new FormData(form);
        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusMsg.classList.remove('hidden', 'alert-danger', 'alert-success');
                    statusMsg.classList.add('alert-success');
                    statusMsg.innerHTML = `
                <h5 class="alert-heading">Submission Successful!</h5>
                <p>${data.message}</p>
                <hr>
                <p class="mb-0">Our team will verify your payment proof and activate your plan within 1-2 hours.</p>
            `;

                    // Reset form
                    form.reset();
                    form.classList.remove('was-validated');

                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.innerText = "Confirm & Complete Checkout";
                    submitBtn.classList.replace('btn-success', 'btn-primary');

                    // Scroll to message
                    statusMsg.scrollIntoView({
                        behavior: 'smooth'
                    });

                    // Hide message after 5 seconds
                    setTimeout(() => {
                        statusMsg.classList.add('hidden');
                    }, 5000);
                } else {
                    throw new Error(data.message || 'Submission failed');
                }
            })
            .catch(error => {
                statusMsg.classList.remove('hidden', 'alert-danger', 'alert-success');
                statusMsg.classList.add('alert-danger');
                statusMsg.innerHTML = `
            <h5 class="alert-heading">Submission Failed!</h5>
            <p>${error.message}</p>
        `;
                submitBtn.disabled = false;
                submitBtn.innerText = "Confirm & Complete Checkout";
            });
        });
    </script>
 @endsection
