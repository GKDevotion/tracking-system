@extends('layouts.app')
@section('title','Categories List')
@section('page-title','Categories Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-geo-alt text-primary"></i>
            <strong>Categories</strong>
            <span class="badge bg-primary rounded-pill">{{ $dataArr->total() }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search vendor..." style="width:160px">
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="form-control form-control-sm" style="width:145px">
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="form-control form-control-sm" style="width:145px">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
                @if(request()->hasAny(['search','date_from','date_to']))
                    <a href="{{ route('web.category.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </form>
            <a href="{{ route('web.category.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Entry
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Parent</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Updated At</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataArr as $i => $category)
                        <tr>
                            <td>{{ $dataArr->firstItem() + $i }}</td>
                            <td>{!! $category->image ? '<img src="' . asset('storage/app/public/' . $category->image) . '" width="100" height="100" style="object-fit:fill;">' : '<img src="' . url('public/img/devotion-group-favicon.png') . '" width="100" height="100" style="object-fit:fill;">' !!}</td>
                            <td><strong>{{ $category->title }}</strong></td>
                            <td>{{ $category->parent ? $category->parent->title : '-' }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <span class="badge {{ $category->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ strtoupper($category->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($category->updated_at)->format('d M Y') }}</td>
                          
                           
                            {{-- <td>
                                @if($category->short_description)
                                    <span data-bs-toggle="tooltip" title="{{ $category->short_description }}">
                                        {{ Str::limit($category->short_description, 30) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td> --}}

                            <td>
                                <a href="{{ route('web.category.show', $category) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('web.category.edit', $category) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('web.category.destroy', $category) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="text-center text-muted py-4">No category entries found.</td></tr>
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
