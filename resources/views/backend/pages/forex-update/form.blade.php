@extends('layouts.app')
@section('title', $plan->exists ? 'Edit Forex Update' : 'Create Plan')
@section('page-title', $plan->exists ? 'Edit Forex Update' : 'Create Plan')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-card-text text-primary"></i>
                    <strong>{{ $plan->exists ? 'Edit Forex Update' : 'New Forex Update' }}</strong>
                </div>
                <div class="card-body p-4">
                    <form method="POST"
                        action="{{ $plan->exists ? route('web.forex-update.update', $plan) : route('web.forex-update.store') }}">
                        @csrf
                        @if ($plan->exists)
                            @method('PUT')
                        @endif

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Signal Date <span class="text-danger">*</span></label> 
                                <input type="date"
                                    name="signal_date"
                                    value="{{ old('signal_date', isset($plan) ? $plan->signal_date : '') }}"
                                    class="form-control @error('signal_date') is-invalid @enderror"
                                    required> 
                                @error('signal_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pair <span class="text-danger">*</span></label>
                                <input type="text" name="pair" value="{{ old('pair', $plan->pair) }}"
                                    class="form-control @error('pair') is-invalid @enderror" placeholder="Enter Pair"
                                    required>
                                @error('pair')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Order Type <span class="text-danger">*</span></label>
                                <select name="order_type"class="form-control @error('order_type') is-invalid @enderror"required>
                                    <option value="">Select Order Type</option>
                                    <option value="0"
                                    {{ old('order_type', $plan->order_type ?? '') == '0' ? 'selected' : '' }}>Buy
                                    </option>

                                    <option value="1"
                                        {{ old('order_type', $plan->order_type ?? '') == '1' ? 'selected' : '' }}>Sell
                                    </option>
                                </select> 
                                @error('order_type')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                @enderror
                            </div>
 
                            <div class="col-md-6">
                                <label class="form-label">Entry Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.0001" name="entry_price" value="{{ old('entry_price', $plan->entry_price) }}"
                                    class="form-control @error('entry_price') is-invalid @enderror" placeholder="Enter Your Entry Price"
                                    required>
                                @error('entry_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> 

                            <div class="col-md-6">
                                <label class="form-label">Stop Loss<span class="text-danger">*</span></label>
                                <input type="number" step="0.0001" name="stop_loss" value="{{ old('stop_loss', $plan->stop_loss) }}"
                                    class="form-control @error('stop_loss') is-invalid @enderror" placeholder="Enter Your Stop Loss"
                                    required>
                                @error('stop_loss')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> 

                            <div class="col-md-6">
                                <label class="form-label">Take Profit<span class="text-danger">*</span></label>
                                <input type="number" step="0.0001" name="take_profit" value="{{ old('take_profit', $plan->take_profit) }}"
                                    class="form-control @error('take_profit') is-invalid @enderror" placeholder="Enter Your Take Profit"
                                    required>
                                @error('take_profit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Profit<span class="text-danger">*</span></label>
                                <input type="number" step="0.0001" name="profit" value="{{ old('profit', $plan->profit) }}"
                                    class="form-control @error('profit') is-invalid @enderror" placeholder="Enter Your Profit"
                                    required>
                                @error('profit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order"
                                    value="{{ old('sort_order', $plan->sort_order ?? 0) }}"
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                    placeholder="0">

                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Live Proof Url <span class="text-danger">*</span></label>
                                <input type="text" name="live_btn_url" value="{{ old('live_btn_url', $plan->live_btn_url) }}"
                                    class="form-control @error('live_btn_url') is-invalid @enderror" placeholder="Enter Live Proof Btn Url"
                                    required>
                                @error('live_btn_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label class="form-label">Status</label> 
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="1" {{ old('status', $plan->status ?? 1) == 1 ? 'selected' : '' }}> Active </option> 
                                    <option value="0" {{ old('status', $plan->status ?? 1) == 0 ? 'selected' : '' }}> Inactive </option>
                                </select> 
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div> 

                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>{{ $plan->exists ? 'Update' : 'Create' }} Plan
                            </button>
                            <a href="{{ route('web.forex-update.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
