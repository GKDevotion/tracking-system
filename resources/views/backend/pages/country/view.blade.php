@extends('layouts.app')
@section('title','Blog Details')
@section('page-title','Blog Details')

@section('content')
    <div class="row g-4">
        {{-- Blog Details --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-text text-primary"></i>
                        <strong>Blog Details</strong>
                    </div>
                    <div>
                        <a href="{{ route('web.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('web.blogs.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($blog->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/app/public/' . $blog->image) }}" class="img-fluid rounded" style="max-height: 400px; object-fit:cover;">
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-12">
                            <h3>{{ $blog->title }}</h3>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Category</label>
                            <p class="mb-0">
                                <span class="badge bg-info">{{ $blog->category->title ?? 'N/A' }}</span>
                            </p>
                        </div>

                        @if($blog->sub_category)
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sub Category</label>
                                <p class="mb-0">{{ $blog->sub_category->title }}</p>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Author</label>
                            <p class="mb-0">{{ $blog->user->name ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <p class="mb-0">
                                <span class="badge {{ $blog->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $blog->status ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>

                        @if($blog->short_description)
                            <div class="col-12">
                                <label class="form-label fw-bold">Short Description</label>
                                <p class="mb-0">{{ $blog->short_description }}</p>
                            </div>
                        @endif

                        @if($blog->description)
                            <div class="col-12">
                                <label class="form-label fw-bold">Description</label>
                                <div>
                                    {!! nl2br(e($blog->description)) !!}
                                </div>
                            </div>
                        @endif

                        @if($blog->keyword)
                            <div class="col-12">
                                <label class="form-label fw-bold">Keywords</label>
                                <p class="mb-0">{{ $blog->keyword }}</p>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Created At</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y, H:i') }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Updated At</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($blog->updated_at)->format('d M Y, H:i') }}</p>
                        </div>

                        @if($blog->tags->count())
                            <div class="col-12">
                                <label class="form-label fw-bold">Tags</label>
                                <div>
                                    @foreach($blog->tags as $tag)
                                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($blog->podcast_url)
                            <div class="col-12">
                                <label class="form-label fw-bold">Podcast URL</label>
                                <p class="mb-0">
                                    <a href="{{ $blog->podcast_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-link-45deg"></i> Listen Podcast
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if($blog->sort_url)
                            <div class="col-12">
                                <label class="form-label fw-bold">Source URL</label>
                                <p class="mb-0">
                                    <a href="{{ $blog->sort_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-link-45deg"></i> Visit Source
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <strong>Blog Information</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slug</label>
                        <code>{{ $blog->slug }}</code>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID</label>
                        <p class="mb-0">{{ $blog->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection