@extends('layouts.app')
@section('title', isset($tag) ? 'Edit Tag' : 'New Tag')
@section('page-title', isset($tag) ? 'Edit Tag' : 'New Tag')

@section('content')
    <div class="row g-4">
        {{-- Form --}}
        <div class="col-lg-6 offset-3">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-tags text-primary"></i>
                    <strong>{{ isset($tag) ? 'Edit Tag' : 'New Tag' }}</strong>
                </div>
                <div class="card-body p-4">
                    <form method="POST"
                        action="{{ isset($tag) ? route('web.tag.update', $tag) : route('web.tag.store') }}">
                        @csrf
                        @if (isset($tag))
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-12">
                                <label class="form-label">Tag Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="nameInput"
                                    value="{{ old('name', $tag->name ?? '') }}"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter tag name"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-12">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" value="1"
                                        id="statusSwitch" {{ old('status', $tag->status ?? 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusSwitch">
                                        Active
                                    </label>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>{{ isset($tag) ? 'Update' : 'Create' }} Tag
                                </button>
                                <a href="{{ route('web.tag.index') }}" class="btn btn-secondary ms-2">
                                    <i class="bi bi-arrow-left me-1"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-generate slug from name (optional, since we generate it in controller)
    document.getElementById('nameInput')?.addEventListener('input', function() {
        // Could add slug preview if needed
    });
</script>
@endpush