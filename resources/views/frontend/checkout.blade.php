@extends('frontend.layout')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/css/intlTelInput.css">

@section('content')
    <style>
        :root {
            --navy: #0f172a;
            --muted: #64748b;
            --border-soft: #e6ebf1;
            --panel-start: #eef4ff;
            --panel-end: #dbe8fe;
        }

        .checkout-container {
            margin: auto;
            margin-top: 110px;
            margin-bottom: 60px;
        }

        .checkout-shell {
            display: grid;
            grid-template-columns: 100% 1fr;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        /* ---------- LEFT PANEL ---------- */
        .side-panel {
            position: relative;
            background: linear-gradient(165deg, var(--panel-start), var(--panel-end));
            padding: 48px 36px 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-height: 100%;
        }

        .side-icon {
            width: 56px; height: 56px;
            background: #fff;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.15);
            color: var(--red-color) 	;
            margin-bottom: 28px;
        }

        .side-panel h1 {
            font-weight: 800;
            font-size: 2rem;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .side-underline {
            width: 46px; height: 4px;
            background: var(--red-color) 	;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .side-panel p.lead-text {
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .feature-card {
            background: rgba(255,255,255,0.75);
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }
        .feature-card + .feature-card { border-top: 1px solid rgba(15,23,42,0.06); border-radius: 0 0 14px 14px; }
        .feature-card:first-child { border-radius: 14px 14px 0 0; }
        .feature-stack { background: rgba(255,255,255,0.75); border-radius: 14px; box-shadow: 0 4px 14px rgba(15,23,42,0.04); }

        .feature-icon {
            width: 38px; height: 38px; min-width: 38px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .feature-icon.blue { background: #dbeafe; color: var(--red-color) 	; }
        .feature-icon.green { background: #d7f3e3; color: #16a34a; }

        .feature-card h6 { font-weight: 700; color: var(--navy); margin-bottom: 2px; font-size: 0.92rem; }
        .feature-card p { color: var(--muted); font-size: 0.82rem; margin: 0; line-height: 1.4; }

        .side-chart { margin-top: auto; opacity: 0.9; }

        /* ---------- RIGHT PANEL ---------- */
        .form-panel { padding: 48px 44px; }

        .section-block + .section-block { margin-top: 34px; padding-top: 30px; border-top: 1px solid var(--border-soft); }

        .section-heading { display: flex; align-items: center; gap: 12px; margin-bottom: 4px; }
        .section-heading .icon-badge {
            width: 40px; height: 40px;
            background: #eef4ff;
            color: var(--red-color) 	;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .section-heading h4 { font-weight: 700; color: var(--navy); margin: 0; font-size: 1.1rem; }
        .section-sub { color: var(--muted); font-size: 0.86rem; margin: 6px 0 18px 52px; }

        .form-label { font-weight: 500; color: var(--navy); font-size: 0.88rem; margin-bottom: 6px; }

        .input-icon-wrap { position: relative; }
        .input-icon-wrap svg {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; pointer-events: none;
        }
        .input-icon-wrap .form-control,
        .input-icon-wrap .form-select {
            padding-left: 42px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--border-soft);
            padding: 11px 14px;
            font-size: 0.95rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--red-color) 	;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }

        .comm-options { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 18px; }

        .comm-card {
            border: 1.5px solid var(--border-soft);
            border-radius: 12px;
            padding: 13px 16px;
            display: flex; align-items: center; gap: 10px;
            cursor: pointer;
            transition: 0.15s;
            font-weight: 500;
            color: var(--navy);
        }
        .comm-card:hover { border-color: #c7d7fb; }
        .comm-card input { accent-color: var(--red-color) 	; }
        .comm-card.active {
            border-color: var(--red-color) 	;
        }

        .comm-badge {
            width: 26px; height: 26px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; flex-shrink: 0;
        }
        .comm-badge.tg { background: #29a9eb; }
        .comm-badge.wa { background: #25d366; }

        .hidden { display: none; }

        .info-banner {
            background: #eef4ff;
            border-radius: 10px;
            padding: 12px 16px;
            display: flex; align-items: center; gap: 10px;
            color: #1e3a8a;
            font-size: 0.86rem;
            margin-top: 20px;
        }
        .info-banner svg { color: var(--red-color) 	; flex-shrink: 0; }

        .terms-row {
            display: flex; align-items: flex-start; gap: 10px;
            margin: 26px 0 18px;
            font-size: 0.9rem;
            color: var(--navy);
        }
        .terms-row input { margin-top: 4px; accent-color: var(--red-color) 	; }
        .terms-row a { color: var(--red-color) 	; text-decoration: none; font-weight: 500; }
        .terms-row a:hover { text-decoration: underline; }

        .btn-submit {
            padding: 14px; font-weight: 600; font-size: 1.05rem;
            border-radius: 12px; border: none;
            background: var(--red-color) 	;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: 0.2s;
        }
        .btn-submit:hover:not(:disabled) { background: var(--logo-color) 	; }
        .btn-submit:disabled { opacity: 0.75; }

        .privacy-note {
            text-align: center; color: var(--muted); font-size: 0.8rem;
            margin-top: 14px; display: flex; align-items: center; justify-content: center; gap: 6px;
        }

        .checkout-footer {
            display: flex; align-items: center; justify-content: center; gap: 20px;
            flex-wrap: wrap;
            margin-top: 22px;
            font-size: 0.85rem;
            color: var(--muted);
        }
        .checkout-footer a { color: var(--red-color) 	; text-decoration: none; font-weight: 500; }
        .checkout-footer a:hover { text-decoration: underline; }
        .checkout-footer .divider { width: 1px; height: 14px; background: var(--border-soft); }
        .checkout-footer .fline { display: flex; align-items: center; gap: 6px; }

        #statusMessage.alert { border-radius: 12px; }

        .iti{
            width: 100%;
        }
        @media (max-width: 860px) {
            .checkout-shell { grid-template-columns: 1fr; }
            .side-panel { padding: 36px 28px 28px; }
            .side-chart { display: none; }
            .form-panel { padding: 34px 24px; }
            .comm-options { grid-template-columns: 1fr; }
        }

        /* ---------- SUCCESS DETAILS ---------- */

        #statusMessage.alert-success {
            background: var(--logo-color);
            border: 1px solid var(--logo-color);
            color: #0f172a;
            border-radius: 12px;
            padding: 18px 20px;
        }

        #statusMessage .alert-heading {
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
        }

        .alert-heading-register{
            color: #0f172a;
            font-weight: 700;
            font-size: 1.05rem;
            padding: 10px 14px;
        }

        .alert-heading-username{
            color: var(--logo-color);
            padding: 10px 14px;
        }

        .checkout-success-details {
            margin-top: 14px;
            background: #fff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 10px;
            overflow: hidden;
        }

        .checkout-detail-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 10px 14px;
            font-size: 0.9rem;
        }

        .checkout-detail-row + .checkout-detail-row {
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        .checkout-detail-row span {
            color: #0f172a;
            font-size: 1rem;
        }

        .checkout-detail-row strong {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
            font-size: 1rem;
        }

        @media (max-width: 576px) {
            .checkout-detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 3px;
            }

            .checkout-detail-row strong {
                text-align: left;
            }
        }
    </style>

    <div class="container checkout-container animate__animated animate__fadeIn">
        <div class="checkout-shell">

            {{-- ================= LEFT PANEL ================= --}}
            <div class="side-panel d-none">

                <div class="side-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                </div>

                <h1>Get Started</h1>
                <div class="side-underline"></div>
                <p class="lead-text">Fill in your details below and we'll send you a secure link to complete your payment.</p>

                <div class="feature-stack mb-4">
                    <div class="feature-card">
                        <div class="feature-icon blue">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                        <div>
                            <h6>Instant Access</h6>
                            <p>Receive your trading signals quickly and securely.</p>
                        </div>
                    </div>
                    <div class="feature-card">

                        <div class="feature-icon blue">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>

                        <div>
                            <h6>Secure &amp; Reliable</h6>
                            <p>Your information is safe with us.</p>
                        </div>

                    </div>

                    <div class="feature-card">
                        <div class="feature-icon blue">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path></svg>
                        </div>
                        <div>
                            <h6>We're Here to Help</h6>
                            <p>Our support team is always ready to assist you.</p>
                        </div>
                    </div>

                </div>

                <div class="side-chart">
                    <svg viewBox="0 0 180 180" width="100%" height="180" preserveAspectRatio="none">
                        <rect x="30" y="120" width="10" height="35" rx="2" fill="#F04A34"/>
                        <rect x="55" y="100" width="10" height="55" rx="2" fill="#F04A34"/>
                        <rect x="80" y="80" width="10" height="75" rx="2" fill="#F04A34"/>
                        <rect x="105" y="95" width="10" height="60" rx="2" fill="#F04A34"/>
                        <rect x="130" y="60" width="10" height="95" rx="2" fill="#F04A34"/>
                        <rect x="155" y="40" width="10" height="115" rx="2" fill="#F04A34"/>
                        <polyline points="10,150 35,148 60,110 85,120 110,80 135,90 160,30" fill="none" stroke="#2563eb" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10" cy="150" r="4" fill="#F04A34"/>
                        <circle cx="60" cy="110" r="4" fill="#F04A34"/>
                        <circle cx="110" cy="80" r="4" fill="#F04A34"/>
                        <circle cx="160" cy="30" r="4" fill="#F04A34"/>
                        <path d="M0,175 C60,150 100,170 160,140 C220,170 260,150 320,160 L320,180 L0,180 Z" fill="#F04A34" opacity="0.08"/>
                    </svg>
                </div>
            </div>

            {{-- ================= RIGHT PANEL / FORM ================= --}}
            <div class="form-panel">
                <form id="infoForm" class="needs-validation" novalidate method="POST" action="{{ route('checkout.store') }}" autocomplete="off">
                    <input type="hidden" name="platform" id="optTelegram" value="telegram">
                    @csrf
                    <input type="hidden" name="plan" value="{{ request('plan') }}">

                    {{-- Personal Information --}}
                    <div class="section-block">
                        <div class="section-heading">
                            <div class="icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <h4>Personal Information</h4>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-4">
                                <div class="input-icon-wrap">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input type="text" class="form-control" name="first_name" placeholder="Enter your first name here" required>
                                </div>
                                <div class="invalid-feedback">Required</div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-icon-wrap">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input type="text" class="form-control" name="last_name" placeholder="Enter your last name here" required>
                                </div>
                                <div class="invalid-feedback">Required</div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-icon-wrap">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z" opacity="0"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 6-10 7L2 6"></path></svg>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                                    <span class="input-notification mt-1" style="color: var(--red-color)" for="email"></span>
                                </div>
                                <div class="invalid-feedback">Required / already used</div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-icon-wrap">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 0 20 15.3 15.3 0 0 1 0-20z"></path></svg>
                                    <select class="form-select" name="country_id" required>
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback">Required</div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-icon-wrap">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle><path d="M16 12v1.5a2.5 2.5 0 0 0 5 0V12a9 9 0 1 0-5.5 8.3"></path></svg>
                                    <input type="text" class="form-control" id="telegramUser" name="telegram_username" placeholder="Enter your telegram username" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-icon-wrap">
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Your Mobile Number" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="terms-row">
                        <input type="checkbox" id="agreeTerms" required>
                        <label for="agreeTerms">I agree to the <a href="{{ url('terms-and-conditions') }}">Terms &amp; Conditions</a> and <a href="{{ url('privacy-policy') }}">Privacy Policy</a>.</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-submit" id="submitBtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <span id="submitBtnText">Continue</span>
                    </button>

                    <div class="privacy-note">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        We respect your privacy. Your information will never be shared.
                    </div>
                </form>

                <div id="statusMessage" class="mt-4 alert hidden animate__animated animate__fadeIn"></div>
            </div>
        </div>

        <div class="checkout-footer">
            <span class="fline">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                By proceeding, you agree to our <a href="{{ url('terms-and-conditions') }}">&nbsp;Terms &amp; Conditions</a>
            </span>
            <span class="divider"></span>
            <span>Already have an account?
                <a href="support@wealthora.com">Contact Support</a>
            </span>
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
        const cardTelegram = document.getElementById('cardTelegram');
        const cardWhatsApp = document.getElementById('cardWhatsApp');

        function toggleComm() {
            if (tgRadio.checked) {
                tgField.classList.remove('hidden');
                tgInput.setAttribute('required', '');
                cardTelegram.classList.add('active');
                cardWhatsApp.classList.remove('active');
            } else {
                tgField.classList.add('hidden');
                tgInput.removeAttribute('required');
                cardWhatsApp.classList.add('active');
                cardTelegram.classList.remove('active');
            }
        }
        // tgRadio.addEventListener('change', toggleComm);
        // waRadio.addEventListener('change', toggleComm);
        // cardTelegram.addEventListener('click', () => { tgRadio.checked = true; toggleComm(); });
        // cardWhatsApp.addEventListener('click', () => { waRadio.checked = true; toggleComm(); });

        const form = document.getElementById('infoForm');
        const statusMsg = document.getElementById('statusMessage');
        const submitBtn = document.getElementById('submitBtn');
        const submitBtnText = document.getElementById('submitBtnText');

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
                    // if (!response.ok) throw new Error(data.message || 'Submission failed');
                    if (!response.ok){
                        displayErrors(data.errors);
                    } else {
                        return data;
                    }
                })
                .then((data) => {
                    statusMsg.classList.remove('hidden', 'alert-danger');
                    statusMsg.classList.add('alert-success');
                    statusMsg.innerHTML = `
                       
                        <h5 class="alert-heading mb-2">${data.message}</h5>
                        <div class="checkout-success-details">

                            <h3 class="alert-heading-username">Hi, ${data.username}</h3>
                            <h5 class="alert-heading-register mb-2">${data.register}</h5>

                            <div class="checkout-detail-row">
                                <span>Plan</span>
                                <strong>${data.plan_name}</strong>
                            </div>

                            <div class="checkout-detail-row">
                                <span>Amount</span>
                                <strong>${data.currency}${data.amount}</strong>
                            </div>

                            <div class="checkout-detail-row">
                                <span>Order ID</span>
                                <strong>${data.order_id}</strong>
                            </div>
                        </div>
                    `;
                    form.reset();
                    form.classList.remove('was-validated');
                    submitBtn.innerHTML = 'Submitted';
                    statusMsg.scrollIntoView({ behavior: 'smooth' });
                    setTimeout(() => {
                        $('#infoForm').hide();
                    }, 1000);
                })
                .catch((error) => {
                    statusMsg.classList.add('hidden');
                    // statusMsg.classList.add('alert-danger');
                    // statusMsg.innerHTML = `<h5 class="alert-heading">Submission Failed</h5><p>${error.message}</p>`;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> Continue`;
                });
        });

        function displayErrors(errorArray)
        {
            //hide all previous notifications
            $('.input-notification').hide();

            //setting error into form
            for(x in errorArray){
                console.log(x, errorArray[x][0]);
                $('.input-notification[for="'+x+'"]').text(errorArray[x][0]).show();
            }
        }

        // Function to strip '@' from the input value
        function removeAtSymbol(element) {
            let cleanValue = $(element).val().replace(/@/g, '');
            $(element).val(cleanValue);
        }

        // 1. Run on page load for the default selected value
        removeAtSymbol('#telegramUser');

        // 2. Run dynamically on key press / user typing
        $('#telegramUser').on('input', function() {
            removeAtSymbol(this);
        });
    </script>
@endsection
