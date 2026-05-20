@extends('layouts.app')
@section('title','Forex Update')
@section('page-title','Forex Update')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-card-text text-primary"></i>
            <strong>Forex Updates</strong>
            <span class="badge bg-primary rounded-pill">{{ $plans->total() }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search plans...">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            </form>
            <a href="{{ route('web.forex-update.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Forex Update
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Signal Date</th>
                        <th>Pair</th>
                        <th>Order Type</th>
                        <th>Entry Price</th>
                        <th>Stop Loss</th>
                        <th>Take Profit</th>
                        <th>Profit</th>
                        <th>Live Proof URL</th>  
                        <th>Status</th>
                        <th>Sort Order</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $i => $plan)
                        <tr>
                            <td>{{ $plans->firstItem() + $i }}</td>
                            <td>{{ $plan->signal_date }}</td>
                            <td>{{ $plan->pair }}</td>
                            <td>{{ $plan->order_type ? 'Sell' : 'Buy' }}</td>
                            <td>{{ $plan->entry_price }}</td> 
                            <td>{{ $plan->stop_loss }}</td>
                            <td>{{ $plan->take_profit }}</td>
                            <td>{{ $plan->profit }}</td>
                            <td>{{ $plan->live_btn_url }}</td>
                            <td>{{ $plan->status == 1 ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $plan->sort_order }}</td>
                            <td>
                                <a href="{{ route('web.forex-update.edit', $plan) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('web.forex-update.destroy', $plan) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this Forex Update?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">No forex update found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($plans->hasPages())
        <div class="card-footer">{{ $plans->links() }}</div>
    @endif
</div>
@endsection