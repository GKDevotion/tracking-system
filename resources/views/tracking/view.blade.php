@extends('layouts.app')
@section('title','Tracking Detail')
@section('page-title','Tracking Detail')

@section('content')
<div class="row g-4">
    {{-- Info Card --}}
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle text-primary"></i>
                    <strong>Entry Details</strong>
                </div>
                <span class="badge {{ $tracking->status === 'in' ? 'bg-success' : 'bg-secondary' }} px-3">
                    {{ strtoupper($tracking->status) }}
                </span>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:.875rem">
                    <tr>
                        <td class="text-muted fw-semibold" style="width:130px">Date</td>
                        <td>{{ \Carbon\Carbon::parse($tracking->date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Vendor</td>
                        <td><strong>{{ $tracking->vendor }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">In Time</td>
                        <td>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2">
                                <i class="bi bi-clock me-1"></i>{{ $tracking->in_time }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Out Time</td>
                        <td>
                            @if($tracking->out_time)
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2">
                                    <i class="bi bi-clock me-1"></i>{{ $tracking->out_time }}
                                </span>
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Recorded By</td>
                        <td>{{ $tracking->user->full_name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Created</td>
                        <td>{{ $tracking->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    @if($tracking->latitude && $tracking->longitude)
                    <tr>
                        <td class="text-muted fw-semibold">Coordinates</td>
                        <td>
                            <code style="font-size:.75rem">
                                {{ number_format($tracking->latitude, 6) }},
                                {{ number_format($tracking->longitude, 6) }}
                            </code>
                        </td>
                    </tr>
                    @endif
                    @if($tracking->address)
                    <tr>
                        <td class="text-muted fw-semibold">Address</td>
                        <td style="font-size:.82rem">{{ $tracking->address }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        @if($tracking->short_description)
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-chat-text text-primary"></i>
                <strong>Description</strong>
            </div>
            <div class="card-body" style="font-size:.875rem">
                {{ $tracking->short_description }}
            </div>
        </div>
        @endif

        <div class="d-flex gap-2">
            <a href="{{ route('web.tracking.edit', $tracking) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <a href="{{ route('web.tracking.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back to List
            </a>
        </div>
    </div>

    {{-- Map Card --}}
    <div class="col-lg-7">
        <div class="card h-100" style="min-height:450px">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-map text-primary"></i>
                <strong>Location Map</strong>
                @if($tracking->address)
                    <small class="text-muted ms-1">— {{ Str::limit($tracking->address, 50) }}</small>
                @endif
            </div>
            <div class="card-body p-0">
                @if($tracking->latitude && $tracking->longitude)
                    <div id="trackingMap" style="height:450px;border-radius:0 0 12px 12px"></div>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center text-muted"
                         style="height:450px">
                        <i class="bi bi-map display-4 mb-3 opacity-25"></i>
                        <p>No location data available for this entry.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($tracking->latitude && $tracking->longitude)
<script>
document.addEventListener('DOMContentLoaded', () => {
    const lat  = {{ $tracking->latitude }};
    const lng  = {{ $tracking->longitude }};
    const addr = @json($tracking->address ?? ($tracking->latitude . ', ' . $tracking->longitude));

    const map = L.map('trackingMap').setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const icon = L.divIcon({
        html: '<div style="background:#3b82f6;width:14px;height:14px;border-radius:50%;border:3px solid #fff;box-shadow:0 2px 8px rgba(59,130,246,.5)"></div>',
        className: '',
        iconSize: [14, 14],
        iconAnchor: [7, 7],
    });

    L.marker([lat, lng], { icon })
        .addTo(map)
        .bindPopup(`
            <strong>{{ $tracking->vendor }}</strong><br>
            <small>{{ \Carbon\Carbon::parse($tracking->date)->format('d M Y') }} — {{ $tracking->in_time }}</small><br>
            <small style="color:#64748b">${addr}</small>
        `)
        .openPopup();

    // Draw accuracy circle
    L.circle([lat, lng], { radius: 50, color: '#3b82f6', fillColor: '#93c5fd', fillOpacity: 0.15, weight: 1 }).addTo(map);
});
</script>
@endif
@endpush
