@extends('layouts.app')
@section('title', isset($banner) ? 'Edit Banner' : 'New Banner')
@section('page-title', isset($banner) ? 'Edit Banner' : 'New Banner')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <strong>{{ isset($banner) ? 'Edit Banner' : 'Create Banner' }}</strong>
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data"
                      action="{{ isset($banner) ? route('web.banners.update', $banner->id) : route('web.banners.store') }}">
                    
                    @csrf
                    @if(isset($banner))
                        @method('PUT')
                    @endif

                    <div class="row g-3">

                        {{-- Name --}}
                        <div class="col-12">
                            <label class="form-label">Banner Name *</label>
                            <input type="text" name="name"
                                   value="{{ old('name', $banner->name ?? '') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="col-12">
                            <label class="form-label">Banner Image *</label>
                            <input type="file" name="image_path"
                                   class="form-control @error('image_path') is-invalid @enderror">

                            @if(isset($banner) && $banner->image_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/app/public/' . $banner->image_path) }}"
                                         width="120" class="rounded">
                                </div>
                            @endif

                            @error('image_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option value="0" {{ old('type', $banner->type ?? 0) == 0 ? 'selected' : '' }}>All</option>
                                <option value="1" {{ old('type', $banner->type ?? 0) == 1 ? 'selected' : '' }}>Home</option>
                            </select>
                        </div>

                        {{-- Sort Order --}}
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order"
                                   value="{{ old('sort_order', $banner->sort_order ?? 0) }}"
                                   class="form-control">
                        </div>

                        {{-- Is News --}}
                        <div class="col-md-4">
                            <label class="form-label">Is News</label>
                            <select name="is_news" class="form-select">
                                <option value="0" {{ old('is_news', $banner->is_news ?? 0) == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('is_news', $banner->is_news ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        {{-- Is Click --}}
                        <div class="col-md-4">
                            <label class="form-label">Click Action</label>
                            <select name="is_click" class="form-select">
                                <option value="0" {{ old('is_click', $banner->is_click ?? 0) == 0 ? 'selected' : '' }}>Button</option>
                                <option value="1" {{ old('is_click', $banner->is_click ?? 0) == 1 ? 'selected' : '' }}>Image</option>
                                <option value="2" {{ old('is_click', $banner->is_click ?? 0) == 2 ? 'selected' : '' }}>Register Page</option>
                            </select>
                        </div>

                        {{-- Animate --}}
                        <div class="col-md-4">
                            <label class="form-label">Animate Image</label>
                            <select name="is_animate_image" class="form-select">
                                <option value="0" {{ old('is_animate_image', $banner->is_animate_image ?? 0) == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('is_animate_image', $banner->is_animate_image ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        {{-- Animate Class --}}
                        <div class="col-12">
                            <label class="form-label">Animation Class</label>
                            <textarea name="animate_class_name" rows="2"
                                      class="form-control">{{ old('animate_class_name', $banner->animate_class_name ?? '') }}</textarea>
                        </div>

                        {{-- Status --}}
                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" name="status" value="1"
                                       class="form-check-input"
                                       {{ old('status', $banner->status ?? 1) ? 'checked' : '' }}>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="col-12">
                            <button class="btn btn-primary">
                                {{ isset($banner) ? 'Update' : 'Create' }} Banner
                            </button>

                            <a href="{{ route('web.banners.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection