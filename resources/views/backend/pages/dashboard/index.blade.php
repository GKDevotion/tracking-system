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

{{-- Stat cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <div class="stat-label">Total clients</div>
                <div class="stat-value text-primary">{{ $stats['total_clients'] }}</div>
                <div class="stat-sub">{{ $stats['clients_this_month'] }} added this month</div>
            </div>
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <div class="stat-label">Mails sent</div>
                <div class="stat-value text-success">{{ $stats['total_sent'] }}</div>
                <div class="stat-sub">Today: {{ $stats['today_sent'] }}</div>
            </div>
            <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="bi bi-envelope-check-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <div class="stat-label">Failed</div>
                <div class="stat-value text-danger">{{ $stats['total_failed'] }}</div>
                <div class="stat-sub">{{ $stats['failure_rate'] }}% failure rate</div>
            </div>
            <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                <i class="bi bi-envelope-x-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <div class="stat-label">Campaigns</div>
                <div class="stat-value text-purple" style="color:#7c3aed">{{ $stats['bulk_campaigns'] }}</div>
                <div class="stat-sub">Bulk sends total</div>
            </div>
            <div class="stat-icon" style="background:#ede9fe;color:#7c3aed">
                <i class="bi bi-send-fill"></i>
            </div>
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

{{-- latest Records Entries --}}
<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-clock-history text-primary"></i>
        <strong>Latest Record Tracking Entries</strong>
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
                    @forelse($latestRecords as $i => $t)
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

<div class="row g-3 mb-4">
    <div class="row g-3">
        {{-- Recent activity --}}
        <div class="col-lg-8">
            <div class="bm-table">
                <div class="d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                    <h6 class="mb-0 fw-semibold">Recent mail activity</h6>
                    <a href="{{ route('web.bm-mail-logs.index') }}" class="btn btn-sm btn-light">View all</a>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Client</th><th>Template</th><th>Type</th><th>Status</th><th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs as $log)
                        <tr>
                            <td>
                                <div class="fw-medium">{{ $log->client->company_name ?? '—' }}</div>
                                <small class="text-muted">{{ $log->client->name ?? '' }}</small>
                            </td>
                            <td>{{ $log->template->name ?? '—' }}</td>
                            <td>
                                <span class="badge rounded-pill {{ $log->is_bulk ? 'badge-bulk' : 'badge-single' }}">
                                    {{ $log->is_bulk ? 'Bulk' : 'Single' }}
                                </span>
                            </td>
                            <td>
                                <span class="status-dot {{ $log->status }}">
                                    {{ ucfirst($log->status) }}
                                </span>
                            </td>
                            <td class="text-muted">{{ $log->sent_at?->format('d M, H:i') ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No mail activity yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Quick actions + unsent --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3" style="border-radius:10px">
                <div class="card-header bg-white border-bottom fw-semibold" style="font-size:.85rem">
                    Quick actions
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('web.bm-client.index') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-envelope-arrow-up me-1"></i> Send mail to client
                    </a>
                    <button type="button" class="btn btn-sm" style="background:#ede9fe;color:#5b21b6;border:none"
                            onclick="window.location='{{ route('web.bm-client.index') }}?bulk=1'">
                        <i class="bi bi-send-fill me-1"></i> Launch bulk campaign
                    </button>
                    <a href="{{ route('web.bm-mail-template.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus me-1"></i> Add mail template
                    </a>
                    <a href="{{ route('web.bm-mail-logs.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-journal-text me-1"></i> View mail logs
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius:10px">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-semibold" style="font-size:.85rem">Unsent clients</span>
                        <span class="badge bg-warning text-dark">Action needed</span>
                    </div>
                    <div class="stat-value text-warning mb-1">{{ $stats['unsent_clients'] }}</div>
                    <div class="stat-sub mb-3">clients with sent = No</div>
                    <a href="{{ route('web.bm-client.index') }}?sent=0"
                    class="btn btn-warning btn-sm w-100 text-white">
                        <i class="bi bi-envelope-arrow-up me-1"></i> View unsent clients
                    </a>
                </div>
            </div>
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
