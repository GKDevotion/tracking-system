@extends('layouts.app')
@section('title', 'Change Password')
@section('page-title', 'Change Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-lock text-primary"></i>
                <strong>Change Your Password</strong>
            </div>
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('web.change.password') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               placeholder="Enter current password" required>
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min 8 chars, uppercase, number, symbol" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control" placeholder="Re-enter new password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-2"></i>Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
