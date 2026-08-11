@extends('frontend.layout')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/css/intlTelInput.css">
@section('content')
    <style>
        .checkout-container { margin: auto; margin-top: 100px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
        .section-title { border-left: 5px solid var(--red-color); padding-left: 15px; margin-bottom: 10px; color: #333; }
        .hidden { display: none; }
        .btn-submit { padding: 15px; font-weight: 600; font-size: 1.1rem; transition: 0.3s; }
    </style>

    <div class="container checkout-container animate__animated animate__fadeIn py-5">
        <div class="card p-4 p-md-5">
            <h2 class="text-center mb-4 fw-bold">Get Started</h2>
            <p class="text-center text-muted mb-4">
                Fill in your details below. We'll email you a secure link to complete payment.
            </p>

            <form id="infoForm" class="needs-validation" novalidate method="POST" action="{{ route('checkout.store') }}">
                @csrf
                <input type="hidden" name="plan" value="{{ request('plan') }}">

                <div class="mb-4">
                    <h4 class="section-title">Personal Information</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label mb-0">First Name *</label>
                            <input type="text" class="form-control form-control-lg" name="first_name" required>
                            <div class="invalid-feedback">Required</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label mb-0">Last Name *</label>
                            <input type="text" class="form-control form-control-lg" name="last_name" required>
                            <div class="invalid-feedback">Required</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label mb-0">Email *</label>
                            <input type="email" class="form-control form-control-lg" name="email" required>
                            <div class="invalid-feedback">Required / already used</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label mb-0">Country *</label>
                            <select class="form-select" name="country_id" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Required</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h4 class="section-title">Receiving Signals</h4>
                    <p class="text-muted small">Where should we send your trading signals?</p>

                    <div class="d-flex gap-4 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="platform" id="optTelegram" value="telegram" checked>
                            <label class="form-check-label" for="optTelegram">Telegram</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="platform" id="optWhatsApp" value="whatsapp">
                            <label class="form-check-label" for="optWhatsApp">WhatsApp</label>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6" id="tgField">
                            <label class="form-label mb-0">Telegram Username *</label>
                            <input type="text" class="form-control" id="telegramUser" name="telegram_username" placeholder="@username" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label mb-0">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Your Mobile Number" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 btn-submit shadow" id="submitBtn">
                    Continue
                </button>
            </form>

            <div id="statusMessage" class="mt-4 alert hidden animate__animated animate__fadeIn"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/js/intlTelInput.min.js"></script>
    <script>
        const phoneInput = document.querySelector("#phone");
        window.intlTelInput(phoneInput, {
            initialCountry: "in",
            separateDialCode: true,
            preferredCountries: ["in", "us", "gb"],
        });

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

        const form = document.getElementById('infoForm');
        const statusMsg = document.getElementById('statusMessage');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Processing...`;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(async (response) => {
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || 'Submission failed');
                    return data;
                })
                .then((data) => {
                    statusMsg.classList.remove('hidden', 'alert-danger');
                    statusMsg.classList.add('alert-success');
                    statusMsg.innerHTML = `
                        <h5 class="alert-heading">${data.message}</h5>
                        <p class="mb-0">Reference: <strong>${data.unique_id}</strong></p>
                    `;
                    form.reset();
                    form.classList.remove('was-validated');
                    submitBtn.innerText = "Submitted";
                    statusMsg.scrollIntoView({ behavior: 'smooth' });
                })
                .catch((error) => {
                    statusMsg.classList.remove('hidden', 'alert-success');
                    statusMsg.classList.add('alert-danger');
                    statusMsg.innerHTML = `<h5 class="alert-heading">Submission Failed</h5><p>${error.message}</p>`;
                    submitBtn.disabled = false;
                    submitBtn.innerText = "Continue";
                });
        });
    </script>
@endsection
