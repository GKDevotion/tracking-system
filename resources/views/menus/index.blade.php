@extends('layouts.app')
@section('title','Menus')
@section('page-title','Menu Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-list-ul text-primary"></i>
            <strong>Menus</strong>
            <span class="badge bg-primary rounded-pill">{{ $menus->total() }}</span>
        </div>
        <div class="d-flex gap-2">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search menus...">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            </form>
            <a href="{{ route('web.menus.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Menu
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
                        <th>Icon</th>
                        <th>Route</th>
                        <th>Parent</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $i => $menu)
                        <tr>
                            <td>{{ $menus->firstItem() + $i }}</td>
                            <td>
                                @if($menu->icon)<i class="{{ $menu->icon }} me-1 text-muted"></i>@endif
                                <strong>{{ $menu->name }}</strong>
                            </td>
                            <td><code style="font-size:.75rem">{{ $menu->icon ?? '—' }}</code></td>
                            <td><code style="font-size:.75rem">{{ $menu->route ?? '—' }}</code></td>
                            <td><span class="text-muted">{{ $menu->parent->name ?? 'Root' }}</span></td>
                            <td>{{ $menu->sort_order }}</td>
                            <td>
                                <span class="badge {{ $menu->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $menu->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $menu->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('web.menus.edit', $menu) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this menu?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">No menus found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($menus->hasPages())
        <div class="card-footer">{{ $menus->links() }}</div>
    @endif
</div>
@endsection
