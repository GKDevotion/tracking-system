@extends('layouts.app')
@section('title','Banners List')
@section('page-title','Banner Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-file-text text-primary"></i>
            <strong>Banner</strong>
            <span class="badge bg-primary rounded-pill">{{ $dataArr->total() }}</span>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search banner..." style="width:160px">

                <input type="date" name="created_at" value="{{ request('created_at') }}"
                       class="form-control form-control-sm" style="width:145px">

                <input type="date" name="updated_at" value="{{ request('updated_at') }}"
                       class="form-control form-control-sm" style="width:145px">

                <button class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>

                @if(request()->hasAny(['search','created_at','updated_at']))
                    <a href="{{ route('web.banners.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </form>

            <a href="{{ route('web.banners.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Banner
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
                        <th>Type</th>
                        <th>Sort Order</th>
                        <th>Is News</th>
                        <th>Is Click</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($dataArr as $i => $banner)
                        <tr>
                            <td>{{ $dataArr->firstItem() + $i }}</td>

                            {{-- Image --}}
                            <td>
                                @if($banner->image_path)
                                    <img src="{{ asset('storage/app/public/' . $banner->image_path) }}"
                                         width="80" height="80"
                                         class="rounded"
                                         style="object-fit:cover;">
                                @else
                                    <img src="{{ asset('frontend/images/favicon.png') }}"
                                         width="80" height="80"
                                         class="rounded">
                                @endif
                            </td>

                            {{-- Title --}}
                            <td><strong>{{ $banner->name }}</strong></td>

                            {{-- Type --}}
                            <td>
                                @if($banner->type == 1)
                                    <span class="badge bg-info">Home</span>
                                @else
                                    <span class="badge bg-secondary">All</span>
                                @endif
                            </td>

                            {{-- Sort --}}
                            <td>{{ $banner->sort_order }}</td>

                            {{-- Is News --}}
                            <td>
                                <span class="badge {{ $banner->is_news ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $banner->is_news ? 'Yes' : 'No' }}
                                </span>
                            </td>

                            {{-- Is Click --}}
                            <td>
                                @if($banner->is_click == 0)
                                    <span class="badge bg-warning">Button</span>
                                @elseif($banner->is_click == 1)
                                    <span class="badge bg-info">Image</span>
                                @else
                                    <span class="badge bg-primary">Register</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="badge {{ $banner->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $banner->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- Created --}}
                            <td>{{ $banner->created_at->format('d M Y') }}</td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('web.banners.show', $banner->id) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('web.banners.edit', $banner->id) }}"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('web.banners.destroy', $banner->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Delete this banner?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                No banners found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($dataArr->hasPages())
        <div class="card-footer">
            {{ $dataArr->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
@endpush