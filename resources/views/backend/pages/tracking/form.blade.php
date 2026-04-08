@extends('layouts.app')
@section('title', isset($tracking) ? 'Edit Tracking' : 'New Tracking Entry')
@section('page-title', isset($tracking) ? 'Edit Tracking Entry' : 'New Tracking Entry')

@section('content')
<div class="row g-4">
    {{-- Form --}}
    <div class="col-lg-6 offset-3">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-geo-alt text-primary"></i>
                <strong>{{ isset($tracking) ? 'Edit Entry' : 'New Entry' }}</strong>
            </div>
            <div class="card-body p-4">
                <form method="POST"
                      action="{{ isset($tracking) ? route('web.tracking.update', $tracking) : route('web.tracking.store') }}">
                    @csrf
                    @if(isset($tracking)) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" value="{{ old('date', isset($tracking) ? $tracking->date->format('Y-m-d') : today()->format('Y-m-d')) }}" class="form-control @error('date') is-invalid @enderror" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Vendor <span class="text-danger">*</span></label>
                            <input type="text" name="vendor" value="{{ old('vendor', $tracking->vendor ?? '') }}" class="form-control @error('vendor') is-invalid @enderror" placeholder="Vendor name" required>
                            @error('vendor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">In Time <span class="text-danger">*</span></label>
                            <input type="time" name="in_time" value="{{ old('in_time', $tracking->in_time ?? '') }}" class="form-control @error('in_time') is-invalid @enderror" required>
                            @error('in_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Out Time</label>
                            <input type="time" name="out_time" value="{{ old('out_time', $tracking->out_time ?? '') }}" class="form-control @error('out_time') is-invalid @enderror">
                            @error('out_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror" placeholder="Brief notes about this visit...">{{ old('short_description', $tracking->short_description ?? '') }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Location --}}
                        <div class="col-12 d-none">
                            <label class="form-label">Location</label>
                            <div class="input-group mb-2">
                                <input type="text" id="addressDisplay"
                                       class="form-control"
                                       value="{{ old('address', $tracking->address ?? '') }}"
                                       placeholder="Click 'Get Location' or enter manually"
                                       readonly>
                                <button type="button" class="btn btn-outline-primary" onclick="getLocation()" id="locationBtn">
                                    <i class="bi bi-crosshair me-1"></i>Get Location
                                </button>
                            </div>
                            <input type="hidden" name="address"   id="addressInput" value="{{ old('address', $tracking->address ?? '') }}">
                            <input type="hidden" name="latitude"  id="latInput" value="{{ old('latitude', $tracking->latitude ?? '') }}">
                            <input type="hidden" name="longitude" id="lngInput" value="{{ old('longitude', $tracking->longitude ?? '') }}">
                            <div id="locationStatus" class="form-text"></div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>{{ isset($tracking) ? 'Update' : 'Save' }} Entry
                        </button>
                        <a href="{{ route('web.tracking.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Map Preview --}}
    <div class="col-lg-6 d-none">
        <div class="card h-100" style="min-height:400px">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-map text-primary"></i>
                <strong>Location Preview</strong>
            </div>
            <div class="card-body p-0" style="position:relative">
                <div id="mapPreview" style="height:400px;border-radius:0 0 12px 12px"></div>
                <div id="mapPlaceholder"
                     style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#94a3b8;background:#f8fafc;border-radius:0 0 12px 12px">
                    <i class="bi bi-map display-4 mb-3 opacity-25"></i>
                    <p class="mb-0">Your Current Location</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
    let map = null;
    let marker = null;

    // Init map if coordinates already exist
    window.addEventListener('DOMContentLoaded', () => {
        const lat = parseFloat(document.getElementById('latInput').value);
        const lng = parseFloat(document.getElementById('lngInput').value);
        if (lat && lng) {
            showMap(lat, lng, document.getElementById('addressDisplay').value);
        }
    });

    function getLocation() {
        const btn    = document.getElementById('locationBtn');
        const status = document.getElementById('locationStatus');

        if (!navigator.geolocation) {
            status.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Geolocation not supported.</span>';
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Locating...';
        status.innerHTML = '<span class="text-muted"><i class="bi bi-hourglass me-1"></i>Getting your location...</span>';

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;

                document.getElementById('latInput').value = lat;
                document.getElementById('lngInput').value = lng;

                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-crosshair me-1"></i>Get Location';

                // Reverse geocode using Nominatim (free, no API key)
                status.innerHTML = '<span class="text-info"><i class="bi bi-search me-1"></i>Fetching address...</span>';

                console.log( lat, lng );
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                    .then(r => r.json())
                    .then(data => {
                        const address = data.display_name || `${lat}, ${lng}`;
                        document.getElementById('addressDisplay').value = address;
                        document.getElementById('addressInput').value   = address;
                        status.innerHTML = '<span class="text-success"><i class="bi bi-check-circle me-1"></i>Location captured.</span>';
                        showMap(lat, lng, address);
                    })
                    .catch(() => {
                        const coords = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                        document.getElementById('addressDisplay').value = coords;
                        document.getElementById('addressInput').value   = coords;
                        status.innerHTML = '<span class="text-warning"><i class="bi bi-exclamation-circle me-1"></i>Address lookup failed — coordinates saved.</span>';
                        showMap(lat, lng, coords);
                    });
            },
            (err) => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-crosshair me-1"></i>Get Location';
                status.innerHTML = `<span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Error: ${err.message}</span>`;
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }

    function showMap(lat, lng, label) {
        document.getElementById('mapPlaceholder').style.display = 'none';

        if (!map) {
            map = L.map('mapPreview').setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
        } else {
            map.setView([lat, lng], 15);
        }

        if (marker) marker.remove();
        marker = L.marker([lat, lng])
            .addTo(map)
            .bindPopup(`<strong>Location</strong><br><small>${label}</small>`)
            .openPopup();
    }

    getLocation();
    </script>
@endpush
