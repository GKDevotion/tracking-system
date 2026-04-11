@extends('layouts.app')
@section('title', isset($category) ? 'Edit category' : 'New category Entry')
@section('page-title', isset($category) ? 'Edit category Entry' : 'New category Entry')

@section('content')
    <div class="row g-4">
        {{-- Form --}}
        <div class="col-lg-6 offset-3">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-geo-alt text-primary"></i>
                    <strong>{{ isset($category) ? 'Edit Entry' : 'New Entry' }}</strong>
                </div>
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ isset($category) ? route('web.blog-category.update', $category) : route('web.blog-category.store') }}">
                        @csrf
                        @if (isset($category))
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            {{-- Title --}}
                            <div class="col-md-6">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="titleInput"
                                    value="{{ old('title', $category->title ?? '') }}"
                                    class="form-control @error('title') is-invalid @enderror" placeholder="Enter title"
                                    required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-6">
                                <label class="form-label">Short Description</label>
                                <input type="text" name="short_description" id="shortDescriptionInput"
                                    value="{{ old('short_description', $category->short_description ?? '') }}"
                                    class="form-control @error('short_description') is-invalid @enderror" placeholder="Enter short description">
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Parent Category --}}
                            <div class="col-md-6">
                                <label class="form-label">Parent Category</label>
                                <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                    <option value="">-- None --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('parent_id', $category->parent_id ?? 0) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sort Order --}}
                            <div class="col-md-6">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order"
                                    value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                                    class="form-control @error('sort_order') is-invalid @enderror" placeholder="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Image Upload --}}
                            <div class="col-12">
                                <label class="form-label">Image</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror">

                                @if (isset($category) && $category->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/app/public/' . $category->image) }}" width="80" class="rounded">
                                    </div>
                                @endif

                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Location --}}
                            <div class="col-12 d-none">
                                <label class="form-label">Location</label>
                                <div class="input-group mb-2">
                                    <input type="text" id="addressDisplay" class="form-control"
                                        value="{{ old('address', $category->address ?? '') }}"
                                        placeholder="Click 'Get Location' or enter manually" readonly>
                                    <button type="button" class="btn btn-outline-primary" onclick="getLocation()"
                                        id="locationBtn">
                                        <i class="bi bi-crosshair me-1"></i>Get Location
                                    </button>
                                </div>
                                <input type="hidden" name="address" id="addressInput"
                                    value="{{ old('address', $category->address ?? '') }}">
                                <input type="hidden" name="latitude" id="latInput"
                                    value="{{ old('latitude', $category->latitude ?? '') }}">
                                <input type="hidden" name="longitude" id="lngInput"
                                    value="{{ old('longitude', $category->longitude ?? '') }}">
                                <div id="locationStatus" class="form-text"></div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>{{ isset($category) ? 'Update' : 'Save' }} Entry
                            </button>
                            <a href="{{ route('web.blog-category.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
            const btn = document.getElementById('locationBtn');
            const status = document.getElementById('locationStatus');

            if (!navigator.geolocation) {
                status.innerHTML =
                    '<span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Geolocation not supported.</span>';
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Locating...';
            status.innerHTML =
                '<span class="text-muted"><i class="bi bi-hourglass me-1"></i>Getting your location...</span>';

            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;

                    document.getElementById('latInput').value = lat;
                    document.getElementById('lngInput').value = lng;

                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-crosshair me-1"></i>Get Location';

                    // Reverse geocode using Nominatim (free, no API key)
                    status.innerHTML =
                        '<span class="text-info"><i class="bi bi-search me-1"></i>Fetching address...</span>';

                    console.log(lat, lng);
                    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                        .then(r => r.json())
                        .then(data => {
                            const address = data.display_name || `${lat}, ${lng}`;
                            document.getElementById('addressDisplay').value = address;
                            document.getElementById('addressInput').value = address;
                            status.innerHTML =
                                '<span class="text-success"><i class="bi bi-check-circle me-1"></i>Location captured.</span>';
                            showMap(lat, lng, address);
                        })
                        .catch(() => {
                            const coords = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                            document.getElementById('addressDisplay').value = coords;
                            document.getElementById('addressInput').value = coords;
                            status.innerHTML =
                                '<span class="text-warning"><i class="bi bi-exclamation-circle me-1"></i>Address lookup failed — coordinates saved.</span>';
                            showMap(lat, lng, coords);
                        });
                },
                (err) => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-crosshair me-1"></i>Get Location';
                    status.innerHTML =
                        `<span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Error: ${err.message}</span>`;
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000
                }
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
