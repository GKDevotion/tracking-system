{{-- resources/views/business-mail/template/form.blade.php --}}
{{-- Used for both create and edit --}}
@extends('layouts.admin')

@section('title', isset($template) ? 'Edit Template' : 'Add Template')
@section('page-title', isset($template) ? 'Edit Template' : 'Add Template')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('web.bm-mail-template.index') }}" class="text-decoration-none text-muted">Mail Template</a>
    </li>
    <li class="breadcrumb-item active">{{ isset($template) ? 'Edit' : 'Add' }}</li>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card border-0 shadow-sm" style="border-radius:12px">
            <div class="card-header bg-white border-bottom fw-semibold px-4 py-3">
                <i class="bi bi-file-earmark-richtext me-2 text-primary"></i>
                {{ isset($template) ? 'Edit Mail Template' : 'New Mail Template' }}
            </div>
            <div class="card-body px-4 py-4">
                <form method="POST"
                      action="{{ isset($template) ? route('web.bm-mail-template.update', $template) : route('web.bm-mail-template.store') }}">
                    @csrf
                    @if(isset($template)) @method('PUT') @endif

                    <div class="row g-3">
                        {{-- Name --}}
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Template Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $template->name ?? '') }}"
                                   placeholder="e.g. Growth Offer" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Category --}}
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">— No category —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $template->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Slug --}}
                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                Slug
                                <small class="text-muted fw-normal">(auto-generated)</small>
                            </label>
                            <input type="text" name="slug" id="tmpl_slug"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   value="{{ old('slug', $template->slug ?? '') }}"
                                   placeholder="growth-offer">
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Status</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ old('status', $template->status ?? 1) == 1 ? 'selected' : '' }}>
                                    Enabled
                                </option>
                                <option value="0" {{ old('status', $template->status ?? 1) == 0 ? 'selected' : '' }}>
                                    Disabled
                                </option>
                            </select>
                        </div>

                        {{-- Subject --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">Email Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   value="{{ old('subject', $template->subject ?? '') }}"
                                   placeholder="Exclusive offer for {{company}}" required>
                            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Short description --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">Short Description</label>
                            <input type="text" name="short_description"
                                   class="form-control @error('short_description') is-invalid @enderror"
                                   value="{{ old('short_description', $template->short_description ?? '') }}"
                                   placeholder="Displayed in template list — keep it brief">
                            @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Mail body --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Mail Template (HTML)
                                <span class="text-danger">*</span>
                            </label>
                            <div class="alert alert-info py-2 mb-2" style="font-size:.8rem">
                                <i class="bi bi-info-circle me-1"></i>
                                Available placeholders:
                                <code>name</code>
                                <code>company</code>
                                <code>email</code>
                                <code>mobile</code>
                                <code>website</code>
                            </div>
                            <textarea name="mail_template" rows="12"
                                      class="form-control font-monospace @error('mail_template') is-invalid @enderror"
                                      style="font-size:.8rem" required
                                      placeholder="">{{ old('mail_template', $template->mail_template ?? '') }}</textarea>
                            @error('mail_template')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            {{ isset($template) ? 'Update Template' : 'Save Template' }}
                        </button>
                        <a href="{{ route('web.bm-mail-template.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.querySelector('[name="name"]');
        const slugInput = document.getElementById('tmpl_slug');

        if (nameInput && slugInput) {

            nameInput.addEventListener('input', function () {
                if (!slugInput.dataset.manual) {
                    slugInput.value = this.value.toLowerCase().trim()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                }
            });

            slugInput.addEventListener('input', function () {
                this.dataset.manual = this.value ? '1' : '';
            });
        }
    });
    </script>
@endpush
