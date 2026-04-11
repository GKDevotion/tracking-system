@extends('layouts.app')
@section('title','Tags List')
@section('page-title','Tags Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-tags text-primary"></i>
            <strong>Tags</strong>
            <span class="badge bg-primary rounded-pill">{{ $dataArr->total() }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search tags..." style="width:160px">
                <input type="date" name="created_at" value="{{ request('created_at') }}"
                       class="form-control form-control-sm" style="width:145px">
                <input type="date" name="updated_at" value="{{ request('updated_at') }}"
                       class="form-control form-control-sm" style="width:145px">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
                @if(request()->hasAny(['search','created_at','updated_at']))
                    <a href="{{ route('web.blog-tag.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </form>
            <a href="{{ route('web.blog-tag.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Tag
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataArr as $i => $tag)
                        <tr>
                            <td>{{ $dataArr->firstItem() + $i }}</td>
                            <td><strong>{{ $tag->name }}</strong></td>
                            <td>{{ $tag->slug }}</td>
                            <td>
                                <span class="badge {{ $tag->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $tag->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($tag->created_at)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('web.blog-tag.show', $tag) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('web.blog-tag.edit', $tag) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('web.blog-tag.destroy', $tag) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this tag?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No tags found.</td></tr>
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
