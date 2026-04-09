@extends('layouts.app')
@section('title','Blogs List')
@section('page-title','Blogs Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-file-text text-primary"></i>
            <strong>Blogs</strong>
            <span class="badge bg-primary rounded-pill">{{ $dataArr->total() }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search blogs..." style="width:160px">
                <input type="date" name="created_at" value="{{ request('created_at') }}"
                       class="form-control form-control-sm" style="width:145px">
                <input type="date" name="updated_at" value="{{ request('updated_at') }}"
                       class="form-control form-control-sm" style="width:145px">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
                @if(request()->hasAny(['search','created_at','updated_at']))
                    <a href="{{ route('web.blogs.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </form>
            <a href="{{ route('web.blogs.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Blog
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50">Sr</th>
                        <th width="100">Image</th>
                        <th width="200">Title</th>
                        <th width="150">Category</th>
                        <th width="200">Short Description</th>
                        <th width="100">Status</th>
                        <th width="150">Created At</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataArr as $i => $blog)
                        <tr>
                            <td>{{ $dataArr->firstItem() + $i }}</td>
                            <td>
                                @if($blog->image)
                                    <img src="{{ asset('storage/app/public/' . $blog->image) }}" width="100" height="100" style="object-fit:cover;" class="rounded">
                                @else
                                    <img src="{{ url('public/frontend/images/favicon.png') }}" width="100" height="100" style="object-fit:cover;" class="rounded">
                                @endif
                            </td>
                            <td><strong>{{ $blog->title }}</strong></td>
                            <td>
                                <span>{{ $blog->category->title ?? 'N/A' }}</span>
                            </td>
                            <td>{{ Str::limit($blog->short_description, 100) }}</td>
                            <td>
                                <span class="badge {{ $blog->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $blog->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('web.blogs.show', $blog) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('web.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('web.blogs.destroy', $blog) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No blogs found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($dataArr->hasPages())
        <div class="card-footer">{{ $dataArr->links() }}</div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Enable Bootstrap tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
@endpush