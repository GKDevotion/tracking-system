@extends('frontend.layout')
@section('content')
    <style>
        :root {  
            --amber-tint: #fdf3e3;
            --amber-tint-strong: #fbe8c8;
            --navy: #111827;
            --navy-soft: #1f2937;
            --muted: #6b7280;
            --border-soft: #e9ecf1;
        }

        .checkout-container { margin: auto; margin-top: 100px; margin-bottom: 60px; }

        .checkout-shell {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            overflow: hidden;
            padding: 40px 44px;
        }

        /* ---------- HEADER ---------- */
        .pay-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 34px; }
        .pay-header .heading-row { display: flex; align-items: center; gap: 16px; }
        .pay-shield {
            width: 58px; height: 58px; border-radius: 50%;
            border: 1.5px solid var(--logo-color) 	;
            display: flex; align-items: center; justify-content: center;
            color: var(--logo-color) 	; flex-shrink: 0;
        }
        .pay-header h2 { font-weight: 800; color: var(--navy); margin: 0; font-size: 1.6rem; }
        .pay-header p { color: var(--muted); margin: 2px 0 0; font-size: 0.9rem; }
        .pay-badges { display: flex; align-items: center; gap: 14px; color: var(--muted); font-size: 0.85rem; }
        .pay-badges .fline { display: flex; align-items: center; gap: 6px; }
        .pay-badges svg { color: var(--logo-color) 	; }
        .pay-badges .divider { width: 1px; height: 14px; background: var(--border-soft); }

        .ref-badge { font-size: 13px; letter-spacing: .3px; color: var(--muted); margin-bottom: 30px; }

        /* ---------- LAYOUT ---------- */
        .pay-grid { display: grid; grid-template-columns: 1.55fr 1fr; gap: 44px; align-items: start; }

        /* ---------- STEP BLOCKS ---------- */
        .step-block { position: relative; padding-left: 44px; padding-bottom: 34px; border-left: 2px dashed var(--border-soft); margin-left: 17px; }
        .step-block:last-child { border-left: 2px dashed transparent; padding-bottom: 0; }
        .step-num {
            position: absolute; left: -18px; top: 0;
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--logo-color) 	; color: #fff; font-weight: 700; font-size: 0.95rem;
            display: flex; align-items: center; justify-content: center;
        }
        .step-block h5 { font-weight: 700; color: var(--navy); margin: 0 0 2px; font-size: 1.05rem; }
        .step-block .step-sub { color: var(--muted); font-size: 0.86rem; margin-bottom: 16px; }

        /* ---------- SELECT CARDS (payment type / crypto network) ---------- */
        .select-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .select-card {
            border: 1.5px solid var(--border-soft);
            border-radius: 14px;
            padding: 16px 18px;
            display: flex; align-items: flex-start; gap: 12px;
            cursor: pointer; transition: 0.15s;
            position: relative;
            background: #fff;
        }
        .select-card:hover { border-color: #f0d6a8; }
        .select-card.active { border-color: var(--logo-color) ; }
        .select-card input { margin-top: 3px; accent-color: var(--logo-color) 	; }
        .select-card .icon-circle {
            width: 42px; height: 42px; border-radius: 50%; flex-shrink: 0; 
            border:1px solid var(--logo-color);
            display: flex; align-items: center; justify-content: center;  color: var(--logo-color) 	;
        }
        .select-card .icon-circle img { width: 26px; height: 26px; object-fit: contain; }
        .select-card .label-title { font-weight: 700; color: var(--navy); font-size: 0.96rem; margin-bottom: 2px; }
        .select-card .label-sub { color: var(--muted); font-size: 0.82rem; }
        .select-card .pill {
            display: inline-block; margin-top: 6px; font-size: 0.72rem; font-weight: 600;
            padding: 2px 10px; border-radius: 20px;
        }
        .select-card .pill.amber { border: 1px solid var(--logo-color); color: var(--logo-color) 	; }
        .select-card .pill.gray { border: 1px solid var(--logo-color); color: var(--logo-color) 	; }

        /* ---------- UPLOAD ZONE ---------- */
        .upload-zone {
            border: 1.5px dashed #d7dce3;
            border-radius: 14px;
            padding: 34px 20px;
            text-align: center;
            background: #fafbfc;
            transition: 0.15s;
        }
        .upload-zone.dragover { border-color: var(--logo-color) 	; background: var(--amber-tint); }
        .upload-zone svg { color: var(--logo-color) 	; margin-bottom: 10px; }
        .upload-zone .browse-btn {
            border: 1.5px solid var(--logo-color) 	;
            color: var(--logo-color) 	;
            background: #fff;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 5px 14px;
            display: inline-block;
        }
        .upload-zone .file-hint { color: var(--muted); font-size: 0.78rem; margin-top: 8px; }
        .upload-zone .file-picked { margin-top: 12px; font-size: 0.85rem; color: var(--navy); font-weight: 600; }

        .info-banner {
            background: var(--amber-tint);
            border-radius: 10px;
            padding: 12px 16px;
            display: flex; align-items: center; gap: 10px;
            color: #7c4a03;
            font-size: 0.85rem;
            margin-top: 16px;
        }
        .info-banner svg { color: var(--logo-color) 	; flex-shrink: 0; }

        .terms-row {
            display: flex; align-items: center; gap: 10px;
            border: 1px solid var(--border-soft);
            border-radius: 10px;
            padding: 12px 16px;
            margin: 22px 0 16px;
            font-size: 0.9rem;
            color: var(--navy);
        }
        .terms-row input { accent-color: var(--logo-color) 	; }
        .terms-row a { color: var(--logo-color) 	; text-decoration: underline; font-weight: 600; }

        .btn-submit {
            padding: 15px; font-weight: 700; font-size: 1.02rem;
            border-radius: 12px; border: none;
            background: var(--navy);
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: 0.2s;
        }
        .btn-submit:hover:not(:disabled) { background: var(--navy-soft); }
        .btn-submit:disabled { opacity: 0.75; }

        .ssl-note {
            text-align: center; color: var(--muted); font-size: 0.8rem;
            margin-top: 14px; display: flex; align-items: center; justify-content: center; gap: 6px;
        }

        /* ---------- RIGHT COLUMN ---------- */
        .side-card {
            border: 1px solid var(--border-soft);
            border-radius: 16px;
            padding: 22px 24px;
            margin-bottom:20px;
        }
        .side-card + .side-card { margin-top: 22px; }

        .side-card-title { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .side-card-title .icon-badge {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--amber-tint-strong); color: var(--logo-color) 	;
            display: flex; align-items: center; justify-content: center;
        }
        .side-card-title h6 { font-weight: 700; color: var(--navy); margin: 0; font-size: 1rem; }

        .summary-row { display: flex; justify-content: space-between; font-size: 0.92rem; color: var(--muted); margin-bottom: 12px; }
        .summary-row strong { color: var(--logo-color) 	; font-weight: 700; }
        .summary-total {
            display: flex; justify-content: space-between; align-items: center;
            border-top: 1px solid var(--border-soft); padding-top: 14px; margin-top: 4px;
        }
        .summary-total span:first-child { font-weight: 700; color: var(--navy); }
        .summary-total span:last-child { font-weight: 800; color: var(--logo-color) 	; font-size: 1.15rem; }

        .qr-card { border-radius: 16px; overflow: hidden; border: 1px solid var(--border-soft); }
        .qr-card-header {
            background: var(--navy); color: #fff;
            padding: 14px 20px; font-weight: 700; font-size: 0.95rem;
            display: flex; align-items: center; gap: 10px;
        }
        .qr-card-body { padding: 22px 24px; }
        .qr-card-body .qr-sub { color: var(--muted); font-size: 0.85rem; margin-bottom: 16px; }
        .qr-wrap { text-align: center; margin-bottom: 18px; }
        .qr-wrap img { max-width: 190px; border: 1.5px solid var(--logo-color) 	; border-radius: 12px; padding: 10px; transition: transform 0.3s; }
        .qr-wrap img:hover { transform: scale(1.04); }

        .wallet-label { font-weight: 600; color: var(--navy); font-size: 0.88rem; margin-bottom: 6px; }
        .wallet-input-group { display: flex; border: 1px solid var(--border-soft); border-radius: 10px; overflow: hidden; }
        .wallet-input-group input {
            flex: 1; border: none; padding: 10px 12px; font-size: 0.83rem;
            color: var(--navy); background: #fff; outline: none; font-family: monospace;
        }
        .wallet-copy-btn {
            border: none; background: #f4f6f8; padding: 0 16px; color: var(--navy);
            display: flex; align-items: center; cursor: pointer;
        }
        .wallet-copy-btn:hover { background: var(--amber-tint); color: var(--logo-color) 	; }

        .why-crypto-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .why-item { display: flex; align-items: center; gap: 10px; }
        .why-item .icon-circle-sm {
            width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
            background: var(--amber-tint-strong); color: var(--logo-color) 	;
            display: flex; align-items: center; justify-content: center;
        }
        .why-item span { font-weight: 600; font-size: 0.82rem; color: var(--navy); line-height: 1.2; }

        .bank-box { background: #fafbfc; }
        .hidden { display: none !important; }

        .pay-footer {
            display: flex; align-items: center; justify-content: center; gap: 24px; flex-wrap: wrap;
            margin-top: 30px; padding-top: 22px; border-top: 1px solid var(--border-soft);
            color: var(--muted); font-size: 0.86rem;
        }
        .pay-footer .fline { display: flex; align-items: center; gap: 6px; }
        .pay-footer a { color: var(--navy); text-decoration: none; font-weight: 600; }

        #statusMessage.alert { border-radius: 12px; }

        @media (max-width: 960px) {
            .pay-grid { grid-template-columns: 1fr; }
            .select-cards { grid-template-columns: 1fr; }
            .checkout-shell { padding: 28px 22px; }
        }
    </style>

    <div class="container checkout-container animate__animated animate__fadeIn">
        <div class="checkout-shell">

            {{-- ================= HEADER ================= --}}
            <div class="pay-header">
                <div class="heading-row">
                    <div class="pay-shield">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <h2>Secure Checkout</h2>
                        <p>Complete your payment using your preferred method</p>
                    </div>
                </div>
                <div class="pay-badges">
                    <span class="fline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        100% Secure &amp; Encrypted
                    </span>
                    <span class="divider"></span>
                    <span>256-bit SSL Protection</span>
                </div>
            </div>

            <p class="ref-badge">Purchase Id: <strong>{{ $checkout->unique_id }}</strong></p>

            @if($alreadySubmitted)
                <div class="alert alert-info text-center">
                    @if($checkout->status === \App\Models\PricingPlanCheckout::STATUS_COMPLETED)
                        This plan didn't require payment — you're all set.
                    @else
                        We've already received your payment proof for this reference.
                        Our team will verify it and activate your plan within 1–2 hours.
                    @endif
                </div>
            @else
                <div class="pay-grid">

                    {{-- ================= LEFT: FORM ================= --}}
                    <div>
                        <form id="paymentForm" class="needs-validation" novalidate method="POST"
                              action="{{ route('checkout.payment.store', $checkout->payment_token) }}"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="payment_type" id="paymentType" value="crypto">
                            <input type="hidden" name="crypto_network" id="cryptoNetwork" value="trc20">

                            {{-- Step 1 --}}
                            <div class="step-block">
                                <div class="step-num">1</div>
                                <h5>Choose Payment Type</h5>
                                <p class="step-sub">Select how you would like to make the payment</p>

                                <div class="select-cards">
                                    <label class="select-card active" id="cardCrypto">
                                        <input type="radio" name="payment_method" id="paymentCrypto" value="crypto" checked>
                                        <span class="icon-circle">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.5 8.5h3a1.75 1.75 0 0 1 0 3.5h-3m0 0h3.5a1.75 1.75 0 0 1 0 3.5h-3.5m0-7V7m0 10v-1.5m2.5-8.5V7m0 10v-1.5"></path></svg>
                                        </span>
                                        <span>
                                            <span class="label-title d-block">Crypto</span>
                                            <span class="label-sub">Pay using cryptocurrency</span>
                                        </span>
                                    </label>

                                    <label class="select-card" id="cardBank">
                                        <input type="radio" name="payment_method" id="paymentBank" value="bank">
                                        <span class="icon-circle">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="21" x2="21" y2="21"></line><line x1="5" y1="21" x2="5" y2="10"></line><line x1="9" y1="21" x2="9" y2="10"></line><line x1="15" y1="21" x2="15" y2="10"></line><line x1="19" y1="21" x2="19" y2="10"></line><polygon points="12 3 21 8 3 8 12 3"></polygon></svg>
                                        </span>
                                        <span>
                                            <span class="label-title d-block">Bank Transfer</span>
                                            <span class="label-sub">Make payment via bank</span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            {{-- Step 2 --}}
                            <div class="step-block" id="cryptoSection">
                                <div class="step-num">2</div>
                                <h5>Select Payment Option</h5>
                                <p class="step-sub">Choose your preferred cryptocurrency</p>

                                <div class="select-cards mb-4">
                                    <label class="select-card active" id="cardTrc20" onclick="selectPayment('trc20', this)">
                                        <input type="radio" name="crypto_display" checked>
                                        <span class="icon-circle"><img src="https://www.forexgdp.com/wp-content/uploads/2024/12/USDT-tether-trc-20-token-logo.png" alt="USDT TRC20"></span>
                                        <span>
                                            <span class="label-title d-block">USDT – TRC20</span>
                                            <span class="label-sub d-block">Tether (TRC20)</span>
                                            <span class="pill amber">Recommended</span>
                                        </span>
                                    </label>

                                    <label class="select-card" id="cardBep20" onclick="selectPayment('bep20', this)">
                                        <input type="radio" name="crypto_display">
                                        <span class="icon-circle"><img src="https://www.forexgdp.com/wp-content/uploads/2024/12/usdt-bep20-address.png" alt="USDT BEP20"></span>
                                        <span>
                                            <span class="label-title d-block">USDT – BEP20</span>
                                            <span class="label-sub d-block">Tether (BEP20)</span>
                                            <span class="pill gray">Low Fees</span>
                                        </span>
                                    </label>
                                </div>

                                {{-- kept for compatibility: original QR block markup, hidden — data now driven by the sidebar QR card --}}
                                <div class="d-none">
                                    <h5 id="networkTitle">USDT - TRC20 - Tron Network</h5>
                                    <img id="qrCodeImg" src="{{ url('public/frontend/images/QR-Code-usdt-tron-trc20-address-gdp.png') }}" alt="QR">
                                    <p id="walletAddr">TGjYaSW5StCyejzv8KebpkjsjDaxtxnBdh</p>
                                </div>
                            </div>

                            <div id="bankSection" class="step-block hidden">
                                <div class="step-num">2</div>
                                <h5>Bank Account Details</h5>
                                <p class="step-sub">Transfer using the details below</p>
                                <div class="bank-box p-4 rounded border">
                                    <div class="row g-3">
                                        @if (getConfigurationField('BANK_NAME') && getConfigurationField('BANK_NAME') != '-')
                                            <div class="col-md-6">
                                                <label class="fw-bold d-block">{!! getConfigurationDisplayName('BANK_NAME') !!}</label>
                                                <p class="mb-0">{!! getConfigurationField('BANK_NAME') !!}</p>
                                            </div>
                                        @endif
                                        @if (getConfigurationField('ACCOUNT_HOLDER_NAME') && getConfigurationField('ACCOUNT_HOLDER_NAME') != '-')
                                            <div class="col-md-6">
                                                <label class="fw-bold d-block">{!! getConfigurationDisplayName('ACCOUNT_HOLDER_NAME') !!}</label>
                                                <p class="mb-0">{!! getConfigurationField('ACCOUNT_HOLDER_NAME') !!}</p>
                                            </div>
                                        @endif
                                        @if (getConfigurationField('ACCOUNT_NUMBER') && getConfigurationField('ACCOUNT_NUMBER') != '-')
                                            <div class="col-md-6">
                                                <label class="fw-bold d-block">{!! getConfigurationDisplayName('ACCOUNT_NUMBER') !!}</label>
                                                <p class="mb-0">{!! getConfigurationField('ACCOUNT_NUMBER') !!}</p>
                                            </div>
                                        @endif
                                        @if (getConfigurationField('IBAN') && getConfigurationField('IBAN') != '-')
                                            <div class="col-md-6">
                                                <label class="fw-bold d-block">{!! getConfigurationDisplayName('IBAN') !!}</label>
                                                <p class="mb-0">{!! getConfigurationField('IBAN') !!}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Step 3 --}}
                            <div class="step-block">
                                <div class="step-num">3</div>
                                <h5>Confirm Payment</h5>
                                <p class="step-sub">Upload your transaction proof</p>

                                <label class="upload-zone d-block" id="uploadZone" for="proofFile" style="cursor:pointer;">
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                    <div>Drag &amp; drop file here or <span class="browse-btn">Browse File</span></div>
                                    <div class="file-hint">Supports: PNG, JPG, PDF (Max. 2MB)</div>
                                    <div class="file-picked" id="filePicked"></div>
                                </label>
                                <input type="file" class="d-none" id="proofFile" name="proof_file" accept="image/*,.pdf" required>
                                <div class="invalid-feedback">Required, max 2MB (jpg, png, gif, pdf)</div>

                                <div class="info-banner">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                    <span>Please ensure the transaction is completed before uploading.</span>
                                </div>
                            </div>

                            <div class="terms-row">
                                <input type="checkbox" id="agreeTerms" required>
                                <label for="agreeTerms">I agree to the <a href="{{ url('terms-and-conditions') }}">Terms &amp; Conditions</a></label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-submit" id="submitBtn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <span id="submitBtnText">Confirm &amp; Complete Payment</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </button>

                            <div class="ssl-note">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                Your payment is protected with 256-bit SSL encryption
                            </div>
                        </form>

                        <div id="statusMessage" class="mt-4 alert hidden animate__animated animate__fadeIn"></div>
                    </div>

                    {{-- ================= RIGHT: SUMMARY / QR ================= --}}
                    <div id="sideColumn">
                        <div class="side-card">
                            <div class="side-card-title">
                                <span class="icon-badge">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                </span>
                                <h6>Payment Summary</h6>
                            </div>
                            <div class="summary-row">
                                <span>Amount to Pay</span>
                                <strong>{{ number_format($checkout->planDetails->price ?? 0, 2) }} USDT</strong>
                            </div>
                            <div class="summary-row">
                                <span>Network Fee</span>
                                <span>0.00 USDT</span>
                            </div>
                            <div class="summary-total">
                                <span>Total Payable</span>
                                <span>{{ number_format($checkout->planDetails->price ?? 0, 2) }} USDT</span>
                            </div>
                        </div>

                        <div class="qr-card" id="qrCard">
                            <div class="qr-card-header">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                <span id="qrCardTitle">Pay with USDT – TRC20</span>
                            </div>
                            <div class="qr-card-body">
                                <p class="qr-sub">Scan the QR code or copy the address below</p>
                                <div class="qr-wrap">
                                    <img id="qrCodeImgDisplay" src="{{ url('public/frontend/images/QR-Code-usdt-tron-trc20-address-gdp.png') }}" alt="QR">
                                </div>
                                <div class="wallet-label">Wallet Address</div>
                                <div class="wallet-input-group">
                                    <input type="text" id="walletAddrDisplay" readonly value="TGjYaSW5StCyejzv8KebpkjsjDaxtxnBdh">
                                    <button type="button" class="wallet-copy-btn" id="copyWalletBtn" title="Copy address">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    </button>
                                </div>
                                <div class="info-banner mt-3 mb-0">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                    <span id="qrWarningText">Please send only USDT (TRC20) to this address. Sending any other coin may result in permanent loss.</span>
                                </div>
                            </div>
                        </div>

                        <div class="side-card" id="whyCryptoCard">
                            <div class="side-card-title" style="margin-bottom:18px;">
                                <h6>Why pay with Crypto?</h6>
                            </div>
                            <div class="why-crypto-grid">
                                <div class="why-item">
                                    <span class="icon-circle-sm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg></span>
                                    <span>Fast &amp; Secure Transactions</span>
                                </div>
                                <div class="why-item">
                                    <span class="icon-circle-sm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg></span>
                                    <span>Lower Fees</span>
                                </div>
                                <div class="why-item">
                                    <span class="icon-circle-sm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 0 20 15.3 15.3 0 0 1 0-20z"></path></svg></span>
                                    <span>Global Payments</span>
                                </div>
                                <div class="why-item">
                                    <span class="icon-circle-sm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></span>
                                    <span>Privacy Focused</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pay-footer">
                    <span>Need help? Contact our support team.</span>
                    
                    <span class="fline">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 6-10 7L2 6"></path></svg>
                        <a href="mailto:support@wealthora.com">support@wealthora.com</a>
                    </span>
                </div>
            @endif
        </div>
    </div>

    @unless($alreadySubmitted)
    <script>
        const cardCrypto = document.getElementById('cardCrypto');
        const cardBank = document.getElementById('cardBank');
        const cryptoSection = document.getElementById('cryptoSection');
        const bankSection = document.getElementById('bankSection');
        const qrCard = document.getElementById('qrCard');
        const whyCryptoCard = document.getElementById('whyCryptoCard');

        function setPaymentMethod(value) {
            document.getElementById('paymentType').value = value;
            const isCrypto = value === 'crypto';
            cryptoSection.classList.toggle('hidden', !isCrypto);
            bankSection.classList.toggle('hidden', isCrypto);
            qrCard.classList.toggle('hidden', !isCrypto);
            whyCryptoCard.classList.toggle('hidden', !isCrypto);
            cardCrypto.classList.toggle('active', isCrypto);
            cardBank.classList.toggle('active', !isCrypto);
        }

        document.querySelectorAll('input[name="payment_method"]').forEach((radio) => {
            radio.addEventListener('change', function () { setPaymentMethod(this.value); });
        });
        cardCrypto.addEventListener('click', () => { document.getElementById('paymentCrypto').checked = true; setPaymentMethod('crypto'); });
        cardBank.addEventListener('click', () => { document.getElementById('paymentBank').checked = true; setPaymentMethod('bank'); });

        function selectPayment(network, element) {
            document.querySelectorAll('#cardTrc20, #cardBep20').forEach(card => card.classList.remove('active'));
            element.classList.add('active');
            document.getElementById('cryptoNetwork').value = network;

            const title = network === 'trc20' ? 'USDT - TRC20 - Tron Network' : 'USDT - BEP20 - Binance Smart Chain';
            const addr = network === 'trc20' ? 'TGjYaSW5StCyejzv8KebpkjsjDaxtxnBdh' : '0x1234567890abcdef1234567890abcdef12345678';
            const qr = network === 'trc20'
                ? "{{ url('public/frontend/images/QR-Code-usdt-tron-trc20-address-gdp.png') }}"
                : "{{ url('public/frontend/images/QR-Code-usdt-bep20-bnb-bsc-network-gdp.png') }}";

            document.getElementById('networkTitle').innerText = title;
            document.getElementById('walletAddr').innerText = addr;
            document.getElementById('qrCodeImg').src = qr;

            document.getElementById('qrCardTitle').innerText = 'Pay with USDT – ' + network.toUpperCase();
            document.getElementById('walletAddrDisplay').value = addr;
            document.getElementById('qrCodeImgDisplay').src = qr;
            document.getElementById('qrWarningText').innerText = `Please send only USDT (${network.toUpperCase()}) to this address. Sending any other coin may result in permanent loss.`;
        }

        document.getElementById('copyWalletBtn').addEventListener('click', function () {
            const input = document.getElementById('walletAddrDisplay');
            navigator.clipboard.writeText(input.value).then(() => {
                const original = this.innerHTML;
                this.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                setTimeout(() => { this.innerHTML = original; }, 1500);
            });
        });

        // File upload UX
        const proofFile = document.getElementById('proofFile');
        const uploadZone = document.getElementById('uploadZone');
        const filePicked = document.getElementById('filePicked');

        proofFile.addEventListener('change', function () {
            filePicked.textContent = this.files.length ? this.files[0].name : '';
        });
        ['dragenter', 'dragover'].forEach(evt => {
            uploadZone.addEventListener(evt, (e) => { e.preventDefault(); uploadZone.classList.add('dragover'); });
        });
        ['dragleave', 'drop'].forEach(evt => {
            uploadZone.addEventListener(evt, (e) => { e.preventDefault(); uploadZone.classList.remove('dragover'); });
        });
        uploadZone.addEventListener('drop', (e) => {
            if (e.dataTransfer.files.length) {
                proofFile.files = e.dataTransfer.files;
                filePicked.textContent = e.dataTransfer.files[0].name;
            }
        });

        const form = document.getElementById('paymentForm');
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
                        <h5 class="alert-heading">Submission Successful!</h5>
                        <p class="mb-0">Our team will verify your payment and activate your plan within 1-2 hours.</p>
                    `;
                    form.classList.add('hidden');
                    statusMsg.scrollIntoView({ behavior: 'smooth' });
                })
                .catch((error) => {
                    statusMsg.classList.remove('hidden', 'alert-success');
                    statusMsg.classList.add('alert-danger');
                    statusMsg.innerHTML = `<h5 class="alert-heading">Submission Failed!</h5><p>${error.message}</p>`;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> Confirm & Complete Payment`;
                });
        });
    </script>
    @endunless
@endsection