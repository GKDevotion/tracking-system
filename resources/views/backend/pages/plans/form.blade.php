@extends('layouts.app')
@section('title', $plan->exists ? 'Edit Plan' : 'Create Plan')
@section('page-title', $plan->exists ? 'Edit Plan' : 'Create Plan')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-card-text text-primary"></i>
                    <strong>{{ $plan->exists ? 'Edit Plan' : 'New Plan' }}</strong>
                </div>
                <div class="card-body p-4">
                    <form method="POST"
                        action="{{ $plan->exists ? route('web.plans.update', $plan) : route('web.plans.store') }}">
                        @csrf
                        @if ($plan->exists)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Plan Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $plan->name) }}"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Basic Plan"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="text" name="price" value="{{ old('price', $plan->price) }}"
                                    class="form-control @error('price') is-invalid @enderror" placeholder="$29 / Month"
                                    required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <input type = "text" name="description"
                                    value="{{ old('description', $plan->description) }}"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="800-1,000 Points / Month" required>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Features <span class="text-danger">*</span></label>

                                <textarea name="features" id="features" rows="5" class="form-control @error('features') is-invalid @enderror"
                                    placeholder="Enter each feature on a new line">{{ old('features', $plan->features ? implode("\n", $plan->features) : '') }}</textarea>

                                <small class="form-text text-muted">
                                    Use <b>&lt;b&gt;text&lt;/b&gt;</b> to make text bold.
                                </small>

                                @error('features')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Call to Action <span class="text-danger">*</span></label>
                                <input type="text" name="cta" value="{{ old('cta', $plan->cta) }}"
                                    class="form-control @error('cta') is-invalid @enderror" placeholder="Subscribe Now"
                                    required>
                                @error('cta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Link ( Plan Name ) <span class="text-danger">*</span></label>
                                <input type="text" name="link" value="{{ old('link', $plan->link) }}"
                                    class="form-control @error('link') is-invalid @enderror"
                                    placeholder="advanced" required>
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order"
                                    value="{{ old('sort_order', $plan->sort_order ?? 0) }}"
                                    class="form-control @error('sort_order') is-invalid @enderror" placeholder="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Is Highlighted</label>
                                <div class="form-check form-switch">
                                    <!-- Hidden field (default 0) -->
                                    <input type="hidden" name="is_highlighted" value="0">
                                    <!-- Checkbox -->
                                    <input class="form-check-input" type="checkbox" name="is_highlighted" value="1"
                                        {{ old('is_highlighted', $plan->is_highlighted) ? 'checked' : '' }}>

                                    <label class="form-check-label">Yes, highlight this plan</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Is Active</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', $plan->is_active ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>{{ $plan->exists ? 'Update' : 'Create' }} Plan
                            </button>
                            <a href="{{ route('web.plans.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>

     
    <script>
    let editorInstance;

    ClassicEditor
        .create(document.querySelector('#features'))
        .then(editor => {
            editorInstance = editor;
        });

    document.querySelector('form').addEventListener('submit', function(e) {
        const data = editorInstance.getData().trim();

        if (!data) {
            e.preventDefault();
            alert('Features field is required');
        }
    });
</script> --}}
@endpush
