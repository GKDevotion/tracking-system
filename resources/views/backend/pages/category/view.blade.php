@extends('layouts.app')
@section('title','category Detail')
@section('page-title','category Detail')

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
                <span class="badge {{ $category->status === 'in' ? 'bg-success' : 'bg-secondary' }} px-3">
                    {{ strtoupper($category->status) }}
                </span>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:.875rem">
                    <tr>
                        <td class="text-muted fw-semibold" style="width:130px">Title</td>
                        <td>{{ $category->title }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Short Description</td>
                        <td><strong>{{ $category->short_description }}</strong></td>
                    </tr>
                      
                    <tr>
                        <td class="text-muted fw-semibold">Slug</td>
                        <td>{{ $category->slug }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Created</td>
                        <td>{{ $category->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    @if($category->latitude && $category->longitude)
                    <tr>
                        <td class="text-muted fw-semibold">Coordinates</td>
                        <td>
                            <code style="font-size:.75rem">
                                {{ number_format($category->latitude, 6) }},
                                {{ number_format($category->longitude, 6) }}
                            </code>
                        </td>
                    </tr>
                    @endif
                    @if($category->address)
                    <tr>
                        <td class="text-muted fw-semibold">Address</td>
                        <td style="font-size:.82rem">{{ $category->address }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        @if($category->short_description)
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-chat-text text-primary"></i>
                <strong>Description</strong>
            </div>
            <div class="card-body" style="font-size:.875rem">
                {{ $category->short_description }}
            </div>
        </div>
        @endif

        @if($category->image)
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-image text-primary"></i>
                <strong>Image</strong>
            </div>
            <div class="card-body d-flex justify-content-center">
                <img src="{{ asset('storage/app/public/' . $category->image) }}" class="img-fluid rounded" height="200px" width="200px" alt="category Image">
            </div>
        </div>
        @endif

        <div class="d-flex gap-2">
            <a href="{{ route('web.category.edit', $category) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <a href="{{ route('web.category.index') }}" class="btn btn-outline-secondary btn-sm">
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
                @if($category->address)
                    <small class="text-muted ms-1">— {{ Str::limit($category->address, 50) }}</small>
                @endif
            </div>
            <div class="card-body p-0">
                @if($category->latitude && $category->longitude)
                    <div id="categoryMap" style="height:450px;border-radius:0 0 12px 12px"></div>
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
@if($category->latitude && $category->longitude)
<script>
document.addEventListener('DOMContentLoaded', () => {
    const lat  = {{ $category->latitude }};
    const lng  = {{ $category->longitude }};
    const addr = @json($category->address ?? ($category->latitude . ', ' . $category->longitude));

    const map = L.map('categoryMap').setView([lat, lng], 15);

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
            <strong>{{ $category->vendor }}</strong><br>
            <small>{{ \Carbon\Carbon::parse($category->date)->format('d M Y') }} — {{ $category->in_time }}</small><br>
            <small style="color:#64748b">${addr}</small>
        `)
        .openPopup();

    // Draw accuracy circle
    L.circle([lat, lng], { radius: 50, color: '#3b82f6', fillColor: '#93c5fd', fillOpacity: 0.15, weight: 1 }).addTo(map);
});
</script>
@endif
@endpush
