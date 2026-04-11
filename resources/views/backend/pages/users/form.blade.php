@extends('layouts.app')
@section('title', $user->exists ? 'Edit User' : 'Create User')
@section('page-title', $user->exists ? 'Edit User' : 'Create User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-person text-primary"></i>
                <strong>{{ $user->exists ? 'Edit User' : 'New User' }}</strong>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ $user->exists ? route('web.sales-user.update', $user) : route('users.store') }}">
                    @csrf
                    @if($user->exists) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                                   class="form-control @error('full_name') is-invalid @enderror"
                                   placeholder="John Doe" required>
                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                   class="form-control @error('username') is-invalid @enderror"
                                   placeholder="john_doe" required>
                            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email ID <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="john@example.com" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="+91 99999 99999" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                                <option value="">— Select Role —</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active"  {{ old('status', $user->status ?? 'active') === 'active'   ? 'selected' : '' }}>Active</option>
                                <option value="inactive"{{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Password {{ $user->exists ? '(leave blank to keep current)' : '' }}
                                @if(!$user->exists)<span class="text-danger">*</span>@endif
                            </label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min 8 characters"
                                   {{ !$user->exists ? 'required' : '' }}>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Confirm Password {{ $user->exists ? '' : '<span class="text-danger">*</span>' }}</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Re-enter password"
                                   {{ !$user->exists ? 'required' : '' }}>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>{{ $user->exists ? 'Update' : 'Create' }} User
                        </button>
                        <a href="{{ route('web.sales-user.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
