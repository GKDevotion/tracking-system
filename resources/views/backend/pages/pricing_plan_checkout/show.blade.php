@extends('layouts.app')
@section('title','Pricing Plan Checkout Details')
@section('page-title','Pricing Plan Checkout Details')

@section('content')
<div class="row g-4">
    {{-- Checkout Info Card --}}
    <div class="col-lg-4">
        <div class="card text-center p-4">
            <div style="width:80px;height:80px;background:linear-gradient(135deg,#3b82f6,#8b5cf6);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.75rem;font-weight:800;margin:0 auto 1rem">
                {{ strtoupper(substr($pricingPlanCheckout->full_name, 0, 2)) }}
            </div>
            <h5 class="fw-bold mb-0">{{ $pricingPlanCheckout->full_name }}</h5>
            <p class="text-muted mb-3">{{ $pricingPlanCheckout->email }}</p>
            <span class="badge bg-info text-dark px-3 py-2 mb-4">
                @if($pricingPlanCheckout->plan == 0) Basic Plan
                @elseif($pricingPlanCheckout->plan == 1) Advanced Trader
                @else Institutional Trader
                @endif
            </span>

            <div class="text-start">
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-envelope text-primary"></i>
                    <span style="font-size:.875rem">{{ $pricingPlanCheckout->email }}</span>
                </div>
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-geo-alt text-primary"></i>
                    <span style="font-size:.875rem">{{ $pricingPlanCheckout->country }}</span>
                </div>
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-phone text-primary"></i>
                    <span style="font-size:.875rem">{{ $pricingPlanCheckout->mobile_number }}</span>
                </div>
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-chat-dots text-primary"></i>
                    <span style="font-size:.875rem">{{ $pricingPlanCheckout->trade_signals == 0 ? 'Telegram' : 'WhatsApp' }}</span>
                </div>
                @if($pricingPlanCheckout->tele_username)
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-at text-primary"></i>
                    <span style="font-size:.875rem">{{ $pricingPlanCheckout->tele_username }}</span>
                </div>
                @endif
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-credit-card text-primary"></i>
                    <span style="font-size:.875rem">{{ $pricingPlanCheckout->payment_option == 0 ? 'USDT-Tether' : 'USDT-BEP20' }}</span>
                </div>
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-calendar text-primary"></i>
                    <span style="font-size:.875rem">{{ $pricingPlanCheckout->created_at->format('d M Y') }}</span>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('web.pricing-plan-checkout.edit', $pricingPlanCheckout) }}" class="btn btn-primary btn-sm flex-fill">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <a href="{{ route('web.pricing-plan-checkout.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">Back</a>
            </div>
        </div>
    </div>

    {{-- Payment Proof Card --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-image text-primary"></i>
                <strong>Payment Proof</strong>
            </div>
            <div class="card-body">
                @if($pricingPlanCheckout->confirm_payment)
                    @php
                        $filePath = storage_path('app/public/' . $pricingPlanCheckout->confirm_payment);
                        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                    @endphp
                    @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ asset('storage/app/public/' . $pricingPlanCheckout->confirm_payment) }}" alt="Payment Proof" class="img-fluid rounded">
                    @elseif(strtolower($fileExtension) === 'pdf')
                        <iframe src="{{ asset('storage/app/public/' . $pricingPlanCheckout->confirm_payment) }}" width="100%" height="500px" class="border rounded"></iframe>
                        <br>
                        <a href="{{ asset('storage/app/public/' . $pricingPlanCheckout->confirm_payment) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-download me-1"></i>Download PDF
                        </a>
                    @else
                        <a href="{{ asset('storage/' . $pricingPlanCheckout->confirm_payment) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-file-earmark me-1"></i>View File
                        </a>
                    @endif
                @else
                    <p class="text-muted">No payment proof uploaded.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection