@extends('layouts.app')
@section('title','Create Configuration')
@section('page-title','Create Configuration')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-gear text-primary"></i>
                <strong>New Configuration</strong>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('web.configurations.store') }}">
                    @csrf

                    <div class="row g-3"> 

                        <div class="col-md-12">
                            <label class="form-label">Key <span class="text-danger">*</span></label>
                            <input type="text" name="key" value="{{ old('key') }}"
                                   class="form-control @error('key') is-invalid @enderror"
                                   placeholder="configuration_key" required>
                            @error('key')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Value</label>
                            <textarea name="value" rows="3"
                                      class="form-control @error('value') is-invalid @enderror"
                                      placeholder="Configuration value">{{ old('value') }}</textarea>
                            @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Display Name <span class="text-danger">*</span></label>
                            <input type="text" name="display_name" value="{{ old('display_name') }}"
                                   class="form-control @error('display_name') is-invalid @enderror"
                                   placeholder="Configuration Display Name" required>
                            @error('display_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Create Configuration
                        </button>
                        <a href="{{ route('web.configurations.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection