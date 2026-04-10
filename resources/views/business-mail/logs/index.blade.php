@extends('layouts.app')

@section('title', 'Mail Logs')
@section('page-title', 'Mail Logs')
@section('breadcrumb')
    <li class="breadcrumb-item active">Mail Logs</li>
@endsection
@section('topbar-action')
    <a href="{{ route('web.bm-logs.export') }}" class="btn btn-sm btn-light">
        <i class="bi bi-download me-1"></i> Export CSV
    </a>
@endsection

@section('content')

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-label">Total sent</div>
                    <div class="stat-value text-success">{{ $stats['total_sent'] }}</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-envelope-check-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-label">Total failed</div>
                    <div class="stat-value text-danger">{{ $stats['total_failed'] }}</div>
                </div>
                <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-envelope-x-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-label">Bulk campaigns</div>
                    <div class="stat-value" style="color:#7c3aed">{{ $stats['bulk_campaigns'] }}</div>
                </div>
                <div class="stat-icon" style="background:#ede9fe;color:#7c3aed">
                    <i class="bi bi-send-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-label">Today sent</div>
                    <div class="stat-value text-primary">{{ $stats['today_sent'] }}</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bm-table">
        {{-- Filters --}}
        <div class="filter-bar">
            <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
                <select name="status" class="form-select" style="max-width:130px">
                    <option value="">All status</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                <select name="is_bulk" class="form-select" style="max-width:130px">
                    <option value="">All types</option>
                    <option value="1" {{ request('is_bulk') == '1' ? 'selected' : '' }}>Bulk</option>
                    <option value="0" {{ request('is_bulk') == '0' ? 'selected' : '' }}>Single</option>
                </select>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}"
                    style="max-width:150px" placeholder="From date">
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}"
                    style="max-width:150px" placeholder="To date">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('web.bm-mail-logs.index') }}" class="btn btn-sm btn-light">Reset</a>
            </form>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client / Company</th>
                    <th>Template</th>
                    <th>Sent To</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Response</th>
                    <th>Sent At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="text-muted">{{ $logs->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-medium">{{ $log->client->company_name ?? '—' }}</div>
                            <small class="text-muted">{{ $log->client->name ?? '' }}</small>
                        </td>
                        <td>{{ $log->template->name ?? '—' }}</td>
                        <td class="text-primary" style="font-size:.78rem">{{ $log->email_sent_to }}</td>
                        <td>
                            <span class="badge rounded-pill {{ $log->is_bulk ? 'badge-bulk' : 'badge-single' }}">
                                {{ $log->is_bulk ? 'Bulk' : 'Single' }}
                            </span>
                            @if ($log->campaign_id)
                                <br><small class="text-muted" style="font-size:.68rem">
                                    {{ substr($log->campaign_id, 0, 8) }}…
                                </small>
                            @endif
                        </td>
                        <td>
                            <span class="status-dot {{ $log->status }}">{{ ucfirst($log->status) }}</span>
                        </td>
                        <td style="max-width:200px;font-size:.78rem">
                            <span class="{{ $log->status === 'sent' ? 'text-success' : 'text-danger' }}"
                                title="{{ $log->response }}">
                                {{ Str::limit($log->response, 45) }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $log->sent_at?->format('d M Y, H:i') ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">No logs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="bm-pagination">
            <span class="page-info">Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of
                {{ $logs->total() }}</span>
            {{ $logs->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
