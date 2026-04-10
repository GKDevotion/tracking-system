@extends('layouts.app')
@section('title','Pricing Plan Checkout')
@section('page-title','Pricing Plan Checkout Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-receipt text-primary"></i>
            <strong>Pricing Plan Checkout</strong>
            <span class="badge bg-primary rounded-pill">{{ $checkouts->total() }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search name/email...">
                <select name="plan" class="form-select form-select-sm">
                    <option value="">All Plans</option>
                    <option value="0" {{ request('plan') == '0' ? 'selected' : '' }}>Basic Plan</option>
                    <option value="1" {{ request('plan') == '1' ? 'selected' : '' }}>Advanced Trader</option>
                    <option value="2" {{ request('plan') == '2' ? 'selected' : '' }}>Institutional Trader</option>
                </select>
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Trade Signals</th>
                        <th>Payment Option</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($checkouts as $i => $checkout)
                        <tr>
                            <td>{{ $checkouts->firstItem() + $i }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:32px;height:32px;background:linear-gradient(135deg,#3b82f6,#8b5cf6);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.75rem;font-weight:700">
                                        {{ strtoupper(substr($checkout->full_name, 0, 2)) }}
                                    </div>
                                    <strong>{{ $checkout->full_name }}</strong>
                                </div>
                            </td>
                            <td>{{ $checkout->email }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    @if($checkout->plan == 0) Basic Plan
                                    @elseif($checkout->plan == 1) Advanced Trader
                                    @else Institutional Trader
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $checkout->trade_signals == 0 ? 'bg-success' : 'bg-primary' }}">
                                    {{ $checkout->trade_signals == 0 ? 'Telegram' : 'WhatsApp' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $checkout->payment_option == 0 ? 'USDT-Tether' : 'USDT-BEP20' }}
                                </span>
                            </td>
                            <td>{{ $checkout->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('web.pricing-plan-checkout.show', $checkout) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('web.pricing-plan-checkout.edit', $checkout) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No checkouts found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($checkouts->hasPages())
        <div class="card-footer">{{ $checkouts->links() }}</div>
    @endif
</div>
@endsection