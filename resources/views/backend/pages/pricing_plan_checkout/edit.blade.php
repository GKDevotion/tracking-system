@extends('layouts.app')
@section('title','Edit Pricing Plan Checkout')
@section('page-title','Edit Pricing Plan Checkout')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-receipt text-primary"></i>
                <strong>Edit Checkout</strong>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('web.pricing-plan-checkout.update', $pricingPlanCheckout) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $pricingPlanCheckout->first_name) }}"
                                   class="form-control @error('first_name') is-invalid @enderror" required>
                            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $pricingPlanCheckout->last_name) }}"
                                   class="form-control @error('last_name') is-invalid @enderror" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name', $pricingPlanCheckout->full_name) }}"
                                   class="form-control @error('full_name') is-invalid @enderror" required>
                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $pricingPlanCheckout->email) }}"
                                   class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" name="country" value="{{ old('country', $pricingPlanCheckout->countryData->name) }}"
                                   class="form-control @error('country') is-invalid @enderror" required>
                            @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Trade Signals <span class="text-danger">*</span></label>
                            <select name="trade_signals" class="form-select @error('trade_signals') is-invalid @enderror" required>
                                <option value="0" {{ old('trade_signals', $pricingPlanCheckout->trade_signals) == 0 ? 'selected' : '' }}>Telegram</option>
                                <option value="1" {{ old('trade_signals', $pricingPlanCheckout->trade_signals) == 1 ? 'selected' : '' }}>WhatsApp</option>
                            </select>
                            @error('trade_signals')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Telegram Username</label>
                            <input type="text" name="tele_username" value="{{ old('tele_username', $pricingPlanCheckout->tele_username) }}"
                                   class="form-control @error('tele_username') is-invalid @enderror">
                            @error('tele_username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile_number" value="{{ old('mobile_number', $pricingPlanCheckout->mobile_number) }}"
                                   class="form-control @error('mobile_number') is-invalid @enderror" required>
                            @error('mobile_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Payment Option</label>
                            <select name="payment_option" class="form-select @error('payment_option') is-invalid @enderror">
                                <option value="">— Select —</option>
                                <option value="0" {{ old('payment_option', $pricingPlanCheckout->payment_option) == 0 ? 'selected' : '' }}>USDT-Tether</option>
                                <option value="1" {{ old('payment_option', $pricingPlanCheckout->payment_option) == 1 ? 'selected' : '' }}>USDT-BEP20</option>
                            </select>
                            @error('payment_option')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Update Checkout
                        </button>
                        <a href="{{ route('web.pricing-plan-checkout.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection