@extends('layouts.app')

@section('title', isset($client) ? 'Edit Client' : 'Add Client')
@section('page-title', isset($client) ? 'Edit Client' : 'Add Client')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('web.bm-client.index') }}" class="text-decoration-none text-muted">Clients</a>
    </li>
    <li class="breadcrumb-item active">{{ isset($client) ? 'Edit' : 'Add' }}</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card border-0 shadow-sm" style="border-radius:12px">
                <div class="card-header bg-white border-bottom fw-semibold px-4 py-3">
                    <i class="bi bi-person-fill-add me-2 text-primary"></i>
                    {{ isset($client) ? 'Edit Client' : 'New Client' }}
                </div>
                <div class="card-body px-4 py-4">
                    <form method="POST"
                        action="{{ isset($client->exists) ? route('web.bm-client.update', $client) : route('web.bm-client.store') }}">
                        @csrf
                        @if($client->exists) @method('PUT') @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Contact Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $client->name ?? '') }}" placeholder="Rahul Shah" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company_name"
                                    class="form-control @error('company_name') is-invalid @enderror"
                                    value="{{ old('company_name', $client->company_name ?? '') }}"
                                    placeholder="Pramukh Fashion" required>
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $client->email ?? '') }}" placeholder="rahul@company.com"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Mobile Number</label>
                                <input type="text" name="mobile_number"
                                    class="form-control @error('mobile_number') is-invalid @enderror"
                                    value="{{ old('mobile_number', $client->mobile_number ?? '') }}"
                                    placeholder="98765 43210">
                                @error('mobile_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Website</label>
                                <input type="url" name="website"
                                    class="form-control @error('website') is-invalid @enderror"
                                    value="{{ old('website', $client->website ?? '') }}" placeholder="https://company.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Status</label>
                                <select name="status" class="form-select">
                                    <option value="1"
                                        {{ old('status', $client->status ?? 1) == 1 ? 'selected' : '' }}>Enabled</option>
                                    <option value="0"
                                        {{ old('status', $client->status ?? 1) == 0 ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium">Address</label>
                                <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror"
                                    placeholder="City, State, Country">{{ old('address', $client->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                {{ isset($client) ? 'Update Client' : 'Save Client' }}
                            </button>
                            <a href="{{ route('web.bm-client.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Mail log history for existing client --}}
            @if (isset($client) && $client->logs->count())
                <div class="bm-table mt-4">
                    <div class="px-3 py-2 border-bottom">
                        <h6 class="mb-0 fw-semibold">Mail History</h6>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Template</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Response</th>
                                <th>Sent at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($client->logs as $log)
                                <tr>
                                    <td>{{ $log->template->name ?? '—' }}</td>
                                    <td><span
                                            class="badge rounded-pill {{ $log->is_bulk ? 'badge-bulk' : 'badge-single' }}">{{ $log->is_bulk ? 'Bulk' : 'Single' }}</span>
                                    </td>
                                    <td><span class="status-dot {{ $log->status }}">{{ ucfirst($log->status) }}</span>
                                    </td>
                                    <td class="text-muted" style="font-size:.78rem">{{ Str::limit($log->response, 50) }}
                                    </td>
                                    <td class="text-muted">{{ $log->sent_at?->format('d M Y, H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
