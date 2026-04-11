@extends('layouts.app')
@section('title', isset($country) ? 'Edit Country' : 'New Country')
@section('page-title', isset($country) ? 'Edit Country' : 'New Country')

@section('content')
    <div class="row g-4">
        {{-- Form --}}
        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-file-text text-primary"></i>
                    <strong>{{ isset($country) ? 'Edit Country' : 'New Country' }}</strong>
                </div>
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ isset($country) ? route('web.country.update', $country) : route('web.country.store') }}">
                        @csrf
                        @if (isset($country))
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            {{-- Title --}}
                        <div class=" row col-12">
                            <div class="col-6">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="titleInput"
                                    value="{{ old('name', $country->name ?? '') }}"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter country title"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="col-6">
                                <label class="form-label">Symbol</label>
                                <input type="text" id="symbol" name="symbol" rows="5"
                                    class="form-control @error('symbol') is-invalid @enderror" placeholder="Enter symbol" value="{{ old('symbol', $country->symbol ?? '') }}">

                                @error('symbol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row col-md-12">

                             <div class="col-6">
                                <label class="form-label">Sortname</label>
                                <input type="text" id="sortname" name="sortname" rows="5"
                                    class="form-control @error('sortname') is-invalid @enderror" placeholder="Enter sortname" value="{{ old('sortname', $country->sortname ?? '') }}">

                                @error('sortname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="col-6">
                                <label class="form-label">Country Code</label>
                                <input type="text" id="code" name="code" rows="5"
                                    class="form-control @error('code') is-invalid @enderror" placeholder="Enter country code" value="{{ old('code', $country->code ?? '') }}">

                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                            {{-- Short Description --}}
                            <div class="col-12">
                                <label class="form-label">Short Description</label>
                                <input type="text" name="sort_description" rows="3" class="form-control @error('sort_description') is-invalid @enderror"
                                    placeholder="Enter short description" value="{{ old('sort_description', $country->sort_description ?? '') }}">
                                @error('sort_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                         
                            {{-- Image Upload --}}
                            <div class="col-12">
                                <label class="form-label">Image</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror">

                                @if (isset($country) && $country->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/app/public/' . $country->image) }}" width="100"
                                            class="rounded">
                                    </div>
                                @endif

                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="col-12">
                                <label class="form-label">Flag</label>
                                <input type="file" name="flag"
                                    class="form-control @error('flag') is-invalid @enderror">

                                @if (isset($country) && $country->flag)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/app/public/' . $country->flag) }}" width="100"
                                            class="rounded">
                                    </div>
                                @endif

                                @error('flag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Status --}}
                            <div class="col-12">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" value="1"
                                        id="statusSwitch" {{ old('status', $country->status ?? 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusSwitch">
                                        Active
                                    </label>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>{{ isset($country) ? 'Update' : 'Create' }} Country
                                </button>
                                <a href="{{ route('web.country.index') }}" class="btn btn-secondary ms-2">
                                    <i class="bi bi-arrow-left me-1"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    
  
@endpush
