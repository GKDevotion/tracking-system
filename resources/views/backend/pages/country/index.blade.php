@extends('layouts.app')
@section('title','country List')
@section('page-title','country Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-file-text text-primary"></i>
            <strong>country</strong>
            <span class="badge bg-primary rounded-pill">{{ $dataArr->total() }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search country..." style="width:160px">
                <input type="date" name="created_at" value="{{ request('created_at') }}"
                       class="form-control form-control-sm" style="width:145px">
                <input type="date" name="updated_at" value="{{ request('updated_at') }}"
                       class="form-control form-control-sm" style="width:145px">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
                @if(request()->hasAny(['search','created_at','updated_at']))
                    <a href="{{ route('web.country.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </form>
            <a href="{{ route('web.country.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Country
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
                        <th width="150">Sort Name</th>
                        <th width="150">Symbol</th>
                        <th width="200">Short Description</th>
                        <th width="100">Status</th>
                        <th width="150">Created At</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataArr as $i => $country)
                        <tr>
                            <td>{{ $dataArr->firstItem() + $i }}</td>
                            <td>
                                @if($country->flag)
                                    <img src="{{ asset('storage/app/public/' . $country->flag) }}" width="100" height="100" style="object-fit:cover;" class="rounded">
                                @else
                                    <img src="{{ url('public/frontend/images/favicon.png') }}" width="100" height="100" style="object-fit:cover;" class="rounded">
                                @endif
                            </td>
                            <td><strong>{{ $country->name }}</strong></td>
                            <td>
                                <span>{{ $country->sortname ?? 'N/A' }}</span>
                            </td>
                             <td>{{ $country->symbol ?? 'N/A' }}</td>
                            <td>{{ Str::limit($country->sort_description, 100) }}</td>
                           
                            <td>
                                <span class="badge {{ $country->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $country->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($country->created_at)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('web.country.show', $country) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('web.country.edit', $country) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('web.country.destroy', $country) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this country?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No country found.</td></tr>
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