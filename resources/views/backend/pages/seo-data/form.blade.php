@extends('layouts.app')

@section('title', $seoData->exists ? 'Edit SEO Data' : 'Create SEO Data')
@section('page-title', $seoData->exists ? 'Edit SEO Data' : 'Create SEO Data')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-10">

        <div class="card border-0 shadow-sm">

            {{-- Header --}}
            <div class="card-header bg-white d-flex align-items-center gap-2">
                <i class="bi bi-search text-primary"></i>

                <strong>
                    {{ $seoData->exists ? 'Edit SEO Data' : 'New SEO Data' }}
                </strong>
            </div>

            {{-- Body --}}
            <div class="card-body p-4">

                <form method="POST"
                    action="{{ $seoData->exists ? route('web.seo-data.update', $seoData) : route('web.seo-data.store') }}">

                    @csrf

                    @if($seoData->exists)
                        @method('PUT')
                    @endif

                    <div class="row g-3">

                        {{-- Page Slug --}} 
                        <div class="col-md-6">

                            <label class="form-label">
                                Page Slug
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="page_slug" value="{{ old('page_slug', $seoData->page_slug) }}" class="form-control @error('page_slug') is-invalid @enderror" placeholder="Example: about, contact, forex-signal"> 
                            <small class="text-muted">Use "/" for home page.</small> 
                            @error('page_slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Meta Title --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Meta Title
                            </label>

                            <input type="text"
                                   name="meta_title"
                                   value="{{ old('meta_title', $seoData->meta_title) }}"
                                   class="form-control @error('meta_title') is-invalid @enderror"
                                   placeholder="Enter Meta Title">

                            @error('meta_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Meta Description --}}
                        <div class="col-12">

                            <label class="form-label">
                                Meta Description
                            </label>

                            <textarea name="meta_description"
                                      rows="4"
                                      class="form-control @error('meta_description') is-invalid @enderror"
                                      placeholder="Enter Meta Description">{{ old('meta_description', $seoData->meta_description) }}</textarea>

                            @error('meta_description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- JSON-LD Schema --}} 
                        <div class="col-12">

                            <label class="form-label">
                                JSON-LD Schema
                            </label>

                            <textarea name="json_ld"
                                    rows="6"
                                    class="form-control @error('json_ld') is-invalid @enderror"
                                    placeholder=''>{{ old('json_ld', $seoData->json_ld ? json_encode($seoData->json_ld, JSON_PRETTY_PRINT) : '') }}</textarea>

                            <small class="text-muted">Must be valid JSON. Leave blank if not needed.</small>

                            @error('json_ld')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Keywords --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Keywords
                            </label>

                            <textarea name="keywords"
                                      rows="3"
                                      class="form-control @error('keywords') is-invalid @enderror"
                                      placeholder="keyword1, keyword2, keyword3">{{ old('keywords', $seoData->keywords) }}</textarea>

                            @error('keywords')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- H1 Tag --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                H1 Tag
                            </label>

                            <input type="text"
                                   name="h1_tag"
                                   value="{{ old('h1_tag', $seoData->h1_tag) }}"
                                   class="form-control @error('h1_tag') is-invalid @enderror"
                                   placeholder="Enter H1 Tag">

                            @error('h1_tag')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- OG Title --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                OG Title
                            </label>

                            <input type="text"
                                   name="og_title"
                                   value="{{ old('og_title', $seoData->og_title) }}"
                                   class="form-control @error('og_title') is-invalid @enderror"
                                   placeholder="Open Graph Title">

                            @error('og_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- OG Description --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                OG Description
                            </label>

                            <input type="text"
                                   name="og_description"
                                   value="{{ old('og_description', $seoData->og_description) }}"
                                   class="form-control @error('og_description') is-invalid @enderror"
                                   placeholder="Open Graph Description">

                            @error('og_description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- OG Image --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                OG Image URL
                            </label>

                            <input type="text"
                                   name="og_image"
                                   value="{{ old('og_image', $seoData->og_image) }}"
                                   class="form-control @error('og_image') is-invalid @enderror"
                                   placeholder="https://example.com/image.jpg">

                            @error('og_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Canonical URL --}}
                        <div class="col-md-6 d-none">

                            <label class="form-label">
                                Canonical URL
                            </label>

                            <input type="text"
                                   name="canonical_url"
                                   value="{{ old('canonical_url', $seoData->canonical_url) }}"
                                   class="form-control @error('canonical_url') is-invalid @enderror"
                                   placeholder="https://example.com/page">

                            @error('canonical_url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Robots --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Robots Meta
                            </label>

                            <select name="robots"
                                    class="form-select @error('robots') is-invalid @enderror">

                                <option value="">Select Robots</option>

                                <option value="index, follow"
                                    {{ old('robots', $seoData->robots) == 'index, follow' ? 'selected' : '' }}>
                                    index, follow
                                </option>

                                <option value="noindex, nofollow"
                                    {{ old('robots', $seoData->robots) == 'noindex, nofollow' ? 'selected' : '' }}>
                                    noindex, nofollow
                                </option>

                            </select>

                            @error('robots')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Status
                            </label>

                            <div class="form-check form-switch mt-2">

                                <input type="hidden" name="status" value="0">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="status"
                                       value="1"
                                       {{ old('status', $seoData->status ?? 1) ? 'checked' : '' }}>

                                <label class="form-check-label">
                                    Active
                                </label>

                            </div>

                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2 mt-4">

                        <button type="submit" class="btn btn-primary">

                            <i class="bi bi-check-lg me-1"></i>

                            {{ $seoData->exists ? 'Update' : 'Create' }} SEO Data

                        </button>

                        <a href="{{ route('web.seo-data.index') }}"
                           class="btn btn-outline-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection