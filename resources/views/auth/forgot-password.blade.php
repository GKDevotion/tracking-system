@extends('layouts.guest')
@section('title', 'Forgot Password')

@section('content')
<h1 class="auth-title">Forgot Password?</h1>
<p class="auth-subtitle">Enter your registered email to receive a 6-digit OTP</p>

<form method="POST" action="{{ route('otp.send') }}">
    @csrf
    <div class="mb-4">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="you@example.com" autofocus required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3">
        <i class="bi bi-send me-2"></i>Send OTP
    </button>

    <div class="text-center">
        <a href="{{ route('login') }}"><i class="bi bi-arrow-left me-1"></i>Back to Login</a>
    </div>
</form>
@endsection
