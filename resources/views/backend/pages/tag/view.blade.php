@extends('layouts.app')
@section('title','Tag Details')
@section('page-title','Tag Details')

@section('content')
    <div class="row g-4">
        {{-- Tag Details --}}
        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-tags text-primary"></i>
                        <strong>Tag Details</strong>
                    </div>
                    <div>
                        <a href="{{ route('web.blog-tag.edit', $tag) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('web.blog-tag.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Name</label>
                            <p class="mb-0">{{ $tag->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Slug</label>
                            <p class="mb-0">{{ $tag->slug }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <p class="mb-0">
                                <span class="badge {{ $tag->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $tag->status ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Created By</label>
                            <p class="mb-0">{{ $tag->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Created At</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($tag->created_at)->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Updated At</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($tag->updated_at)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
