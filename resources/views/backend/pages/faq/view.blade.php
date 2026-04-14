@extends('layouts.app')
@section('title','Banner Details')
@section('page-title','Banner Details')

@section('content')
<div class="row g-4">

    {{-- Banner Details --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <strong>Banner Details</strong>
                <div>
                    <a href="{{ route('web.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning">
                        Edit
                    </a>
                    <a href="{{ route('web.banners.index') }}" class="btn btn-sm btn-secondary">
                        Back
                    </a>
                </div>
            </div>

            <div class="card-body">

                {{-- Image --}}
                @if($banner->image_path)
                    <div class="mb-3">
                        <img src="{{ asset('storage/app/public/' . $banner->image_path) }}"
                             class="img-fluid rounded" style="max-height:300px; width:100%;">
                    </div>
                @endif

                <h4>{{ $banner->name }}</h4>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <span class="badge {{ $banner->status ? 'bg-success' : 'bg-secondary' }}">
                            {{ $banner->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="col-md-6">
                        <strong>Type:</strong>
                        {{ $banner->type == 1 ? 'Home' : 'All' }}
                    </div>

                    <div class="col-md-6 mt-2">
                        <strong>Sort Order:</strong>
                        {{ $banner->sort_order }}
                    </div>

                    <div class="col-md-6 mt-2">
                        <strong>Is News:</strong>
                        {{ $banner->is_news ? 'Yes' : 'No' }}
                    </div>

                    <div class="col-md-6 mt-2">
                        <strong>Click Action:</strong>
                        {{ $banner->is_click }}
                    </div>

                    <div class="col-md-6 mt-2">
                        <strong>Animate:</strong>
                        {{ $banner->is_animate_image ? 'Yes' : 'No' }}
                    </div>

                    @if($banner->animate_class_name)
                        <div class="col-12 mt-2">
                            <strong>Animation Class:</strong>
                            <p>{{ $banner->animate_class_name }}</p>
                        </div>
                    @endif

                    <div class="col-md-6 mt-2">
                        <strong>Created:</strong>
                        {{ $banner->created_at->format('d M Y') }}
                    </div>

                    <div class="col-md-6 mt-2">
                        <strong>Updated:</strong>
                        {{ $banner->updated_at->format('d M Y') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-light">
                <strong>Info</strong>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $banner->id }}</p>
                <p><strong>Slug:</strong> {{ $banner->slug }}</p>
            </div>
        </div>
    </div>

</div>
@endsection