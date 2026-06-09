@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">
            <div class="stat-icon"><i class="bi bi-geo-alt-fill"></i></div>
            <div class="stat-value">{{ $totalTrackings }}</div>
            <div class="stat-label">Total Trackings</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#10b981,#059669)">
            <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
            <div class="stat-value">{{ $todayTrackings }}</div>
            <div class="stat-label">Today's Entries</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed)">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
            <div class="stat-icon"><i class="bi bi-building"></i></div>
            <div class="stat-value">{{ $totalVendors }}</div>
            <div class="stat-label">Total Vendors</div>
        </div>
    </div>
</div>

{{-- Chart --}}
<div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-bar-chart-line text-primary"></i>
            <strong>Tracking Overview</strong>
        </div>
        <div class="btn-group btn-group-sm" role="group">
            @foreach(['daily','weekly','monthly','yearly'] as $f)
                <a href="{{ route('web.dashboard', ['filter' => $f]) }}"
                   class="btn {{ $filter === $f ? 'btn-primary' : 'btn-outline-secondary' }}">
                    {{ ucfirst($f) }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="card-body">
        <div id="mainChart"></div>
    </div>
</div>

{{-- Latest 10 Entries --}}
<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-clock-history text-primary"></i>
        <strong>Latest 10 Tracking Entries</strong>
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
                        <th>User</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latest10 as $i => $t)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</td>
                            <td><strong>{{ $t->vendor }}</strong></td>
                            <td>{{ $t->in_time }}</td>
                            <td>{{ $t->out_time ?? '—' }}</td>
                            <td>{{ $t->user->full_name ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $t->status === 'in' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ strtoupper($t->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('web.tracking.show', $t) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No tracking entries yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const chartData = @json($chartData);

const options = {
    series: [{ name: 'Trackings', data: chartData.values }],
    chart: {
        type: 'bar',
        height: 300,
        toolbar: { show: false },
        fontFamily: 'Plus Jakarta Sans, sans-serif',
    },
    plotOptions: {
        bar: { borderRadius: 6, columnWidth: '50%' }
    },
    colors: ['#3b82f6'],
    xaxis: {
        categories: chartData.labels,
        labels: { style: { fontSize: '12px', colors: '#64748b' } }
    },
    yaxis: {
        labels: { style: { fontSize: '12px', colors: '#64748b' } }
    },
    grid: { borderColor: '#f1f5f9' },
    dataLabels: { enabled: false },
    tooltip: { theme: 'light' },
};

const chart = new ApexCharts(document.querySelector('#mainChart'), options);
chart.render();
</script>
@endpush
