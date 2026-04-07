@extends('layouts.guest')
@section('title', 'Verify OTP')

@section('content')
<h1 class="auth-title">Verify OTP</h1>
<p class="auth-subtitle">Enter the 6-digit code sent to<br><strong>{{ $email }}</strong></p>

@if(session('success'))
    <div class="alert alert-success mb-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('otp.verify') }}">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">

    <div class="mb-4">
        <label class="form-label">One-Time Password</label>
        <input type="text" name="otp" maxlength="6"
               class="form-control otp-input @error('otp') is-invalid @enderror"
               placeholder="• • • • • •" autocomplete="off" required autofocus>
        @error('otp')<div class="invalid-feedback text-center">{{ $message }}</div>@enderror
        <div class="text-muted text-center mt-2" style="font-size:.78rem">OTP expires in 10 minutes</div>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3">
        <i class="bi bi-shield-check me-2"></i>Verify OTP
    </button>

    <div class="text-center">
        <form method="POST" action="{{ route('otp.send') }}" class="d-inline">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="btn btn-link p-0" style="font-size:.85rem">
                <i class="bi bi-arrow-repeat me-1"></i>Resend OTP
            </button>
        </form>
    </div>
</form>
@endsection
