@extends('layouts.app')
@section('title','Tracking')
@section('page-title','Tracking Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-geo-alt text-primary"></i>
            <strong>Tracking Entries</strong>
            <span class="badge bg-primary rounded-pill">{{ $trackings->total() }}</span>
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
                    <a href="{{ route('web.tracking.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </form>
            <a href="{{ route('web.tracking.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Entry
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Vendor</th>
                        <th>In Time</th>
                        <th>Out Time</th>
                        <th>Location</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trackings as $i => $t)
                        <tr>
                            <td>{{ $trackings->firstItem() + $i }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</td>
                            <td><strong>{{ $t->vendor }}</strong></td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle">{{ $t->in_time }}</span></td>
                            <td>
                                @if($t->out_time)
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">{{ $t->out_time }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($t->latitude && $t->longitude)
                                    <a href="{{ route('web.tracking.show', $t) }}" class="badge bg-primary-subtle text-primary border border-primary-subtle text-decoration-none">
                                        <i class="bi bi-pin-map me-1"></i>View Map
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $t->user->full_name ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $t->status === 'in' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ strtoupper($t->status) }}
                                </span>
                            </td>
                            <td>
                                @if($t->short_description)
                                    <span data-bs-toggle="tooltip" title="{{ $t->short_description }}">
                                        {{ Str::limit($t->short_description, 30) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('web.tracking.show', $t) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('web.tracking.edit', $t) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="text-center text-muted py-4">No tracking entries found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($trackings->hasPages())
        <div class="card-footer">{{ $trackings->links() }}</div>
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
