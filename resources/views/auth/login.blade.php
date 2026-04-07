@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<h1 class="auth-title">Welcome back</h1>
<p class="auth-subtitle">Sign in to your account to continue</p>

@if(session('success'))
    <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('login.post') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Email or Username</label>
        <input type="text" name="login" value="{{ old('login') }}"
               class="form-control @error('login') is-invalid @enderror"
               placeholder="Enter email or username" autofocus required>
        @error('login')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <input type="password" name="password" id="passwordField"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Enter password" required>
            <span class="input-group-text" onclick="togglePassword()">
                <i class="bi bi-eye" id="eyeIcon"></i>
            </span>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember" style="font-size:.82rem;color:#64748b">Remember me</label>
        </div>
        <a href="{{ route('forgot.password') }}" style="font-size:.82rem">Forgot password?</a>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
    </button>
</form>
@endsection

@push('scripts')
<script>
function togglePassword() {
    const field = document.getElementById('passwordField');
    const icon  = document.getElementById('eyeIcon');
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endpush
