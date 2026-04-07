@extends('layouts.guest')
@section('title', 'Reset Password')

@section('content')
<h1 class="auth-title">Reset Password</h1>
<p class="auth-subtitle">Create a strong new password for your account</p>

<form method="POST" action="{{ route('reset.password') }}">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="otp" value="{{ $otp }}">

    <div class="mb-3">
        <label class="form-label">New Password</label>
        <div class="input-group">
            <input type="password" name="password" id="newPass"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Min 8 chars, uppercase, number, symbol" required>
            <span class="input-group-text" onclick="toggleField('newPass','eye1')">
                <i class="bi bi-eye" id="eye1"></i>
            </span>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label">Confirm Password</label>
        <div class="input-group">
            <input type="password" name="password_confirmation" id="confirmPass"
                   class="form-control" placeholder="Re-enter new password" required>
            <span class="input-group-text" onclick="toggleField('confirmPass','eye2')">
                <i class="bi bi-eye" id="eye2"></i>
            </span>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-check-circle me-2"></i>Reset Password
    </button>
</form>
@endsection

@push('scripts')
<script>
function toggleField(id, iconId) {
    const f = document.getElementById(id);
    const i = document.getElementById(iconId);
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
@endpush
