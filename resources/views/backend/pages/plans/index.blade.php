@extends('layouts.app')
@section('title','Plans')
@section('page-title','Plan Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-card-text text-primary"></i>
            <strong>Subscription Plans</strong>
            <span class="badge bg-primary rounded-pill">{{ $plans->total() }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search plans...">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            </form>
            <a href="{{ route('web.plans.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Plan
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>CTA</th>
                        <th>Highlighted</th>
                        <th>Active</th>
                        <th>Sort Order</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $i => $plan)
                        <tr>
                            <td>{{ $plans->firstItem() + $i }}</td>
                            <td><strong>{{ $plan->name }}</strong></td>
                            <td>{{ $plan->price }}</td>
                            <td>{{ Str::limit($plan->description, 50) }}</td>
                            <td>{{ $plan->cta }}</td>
                            <td>
                                <span class="badge {{ $plan->is_highlighted ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $plan->is_highlighted ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $plan->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $plan->sort_order }}</td>
                            <td>
                                <a href="{{ route('web.plans.edit', $plan) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('web.plans.destroy', $plan) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this plan?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">No plans found.</td></tr>
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