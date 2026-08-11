@extends('frontend.layout')
@section('content')
    <style>
        .checkout-container { margin: auto; margin-top: 100px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
        .section-title { border-left: 5px solid var(--red-color); padding-left: 15px; margin-bottom: 10px; color: #333; }

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
        .payment-card:hover { transform: translateY(-5px); border-color: var(--red-color); }
        .payment-card.active { border-color: var(--red-color); box-shadow: 0 5px 15px rgba(13,110,253,0.1); }

        .qr-container {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            border: 2px dashed #dee2e6;
            transition: all 0.4s ease;
        }
        #qrCodeImg { max-width: 180px; transition: transform 0.3s ease; }
        #qrCodeImg:hover { transform: scale(1.05); }

        .bank-box { background: #f8f9fa; }
        .hidden { display: none; }
        .btn-submit { padding: 15px; font-weight: 600; font-size: 1.1rem; transition: 0.3s; }
        .ref-badge { font-size: 13px; letter-spacing: .5px; }
    </style>

    <div class="container checkout-container animate__animated animate__fadeIn py-5">
        <div class="card p-4 p-md-5">
            <h2 class="text-center mb-1 fw-bold">Complete Your Payment</h2>
            <p class="text-center text-muted ref-badge mb-4">
                Purchase Id: <strong>{{ $checkout->unique_id }}</strong>
            </p>

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
                <form id="paymentForm" class="needs-validation" novalidate method="POST"
                      action="{{ route('checkout.payment.store', $checkout->payment_token) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="payment_type" id="paymentType" value="crypto">
                    <input type="hidden" name="crypto_network" id="cryptoNetwork" value="trc20">

                    <div class="mb-4">
                        <h4 class="section-title">Payment Type</h4>
                        <p class="text-muted small">Choose your preferred payment method</p>

                        <div class="d-flex gap-4 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="paymentCrypto" value="crypto" checked>
                                <label class="form-check-label" for="paymentCrypto">Crypto</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="paymentBank" value="bank">
                                <label class="form-check-label" for="paymentBank">Bank Transfer</label>
                            </div>
                        </div>

                        <div id="cryptoSection">
                            <h4 class="section-title">Payment Option</h4>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="payment-card active" onclick="selectPayment('trc20', this)">
                                                <img src="https://www.forexgdp.com/wp-content/uploads/2024/12/USDT-tether-trc-20-token-logo.png" width="150" class="mb-2">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="payment-card" onclick="selectPayment('bep20', this)">
                                                <img src="https://www.forexgdp.com/wp-content/uploads/2024/12/usdt-bep20-address.png" width="150" class="mb-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="qr-container text-center animate__animated animate__zoomIn" id="qrSection">
                                        <h5 id="networkTitle" class="fw-bold">USDT - TRC20 - Tron Network</h5>
                                        <img id="qrCodeImg" src="{{ url('public/frontend/images/QR-Code-usdt-tron-trc20-address-gdp.png') }}" alt="QR" class="my-3 img-fluid">
                                        <p class="text-primary fw-bold text-break" id="walletAddr">
                                            TGjYaSW5StCyejzv8KebpkjsjDaxtxnBdh
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="bankSection" style="display: none;">
                            <div class="bank-box p-4 rounded shadow-sm border">
                                <h5 class="fw-bold mb-4">Bank Account Details</h5>
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
                    </div>

                    <div class="mb-4">
                        <h4 class="section-title">Confirm Payment</h4>
                        <label class="form-label mb-0 fw-bold">Upload Transaction Screenshot / PDF *</label>
                        <input type="file" class="form-control form-control-lg" name="proof_file" accept="image/*,.pdf" required>
                        <div class="invalid-feedback">Required, max 2MB (jpg, png, gif, pdf)</div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 btn-submit shadow" id="submitBtn">
                        Confirm & Complete Checkout
                    </button>
                </form>

                <div id="statusMessage" class="mt-4 alert hidden animate__animated animate__fadeIn"></div>
            @endif
        </div>
    </div>

    @unless($alreadySubmitted)
    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach((radio) => {
            radio.addEventListener('change', function () {
                document.getElementById('paymentType').value = this.value;
                document.getElementById('cryptoSection').style.display = this.value === 'crypto' ? 'block' : 'none';
                document.getElementById('bankSection').style.display = this.value === 'crypto' ? 'none' : 'block';
            });
        });

        function selectPayment(network, element) {
            document.querySelectorAll('.payment-card').forEach(card => card.classList.remove('active'));
            element.classList.add('active');
            document.getElementById('cryptoNetwork').value = network;

            if (network === 'trc20') {
                document.getElementById('networkTitle').innerText = 'USDT - TRC20 - Tron Network';
                document.getElementById('walletAddr').innerText = 'TGjYaSW5StCyejzv8KebpkjsjDaxtxnBdh';
                document.getElementById('qrCodeImg').src = "{{ url('public/frontend/images/QR-Code-usdt-tron-trc20-address-gdp.png') }}";
            } else {
                document.getElementById('networkTitle').innerText = 'USDT - BEP20 - Binance Smart Chain';
                document.getElementById('walletAddr').innerText = '0x1234567890abcdef1234567890abcdef12345678';
                document.getElementById('qrCodeImg').src = "{{ url('public/frontend/images/QR-Code-usdt-bep20-bnb-bsc-network-gdp.png') }}";
            }
        }

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
                    submitBtn.innerText = "Confirm & Complete Checkout";
                });
        });
    </script>
    @endunless
@endsection
