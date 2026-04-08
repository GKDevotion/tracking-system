@extends('layouts.app')
@section('title', $role->exists ? 'Edit Role' : 'Create Role')
@section('page-title', $role->exists ? 'Edit Role' : 'Create Role')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-shield text-primary"></i>
                <strong>{{ $role->exists ? 'Edit Role' : 'New Role' }}</strong>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ $role->exists ? route('roles.update', $role) : route('roles.store') }}">
                    @csrf
                    @if($role->exists) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g. Manager" required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Brief description of this role">{{ old('description', $role->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                   id="isActive" {{ old('is_active', $role->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">Active</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>{{ $role->exists ? 'Update' : 'Create' }} Role
                        </button>
                        <a href="{{ route('web.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
