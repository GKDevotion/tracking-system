@extends('layouts.app')
@section('title','Roles')
@section('page-title','Role Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-shield text-primary"></i>
            <strong>Roles</strong>
            <span class="badge bg-primary rounded-pill">{{ $roles->total() }}</span>
        </div>
        <div class="d-flex gap-2">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search roles...">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            </form>
            <a href="{{ route('web.roles.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Role
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
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $i => $role)
                        <tr>
                            <td>{{ $roles->firstItem() + $i }}</td>
                            <td><strong>{{ $role->name }}</strong></td>
                            <td>{{ $role->description ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $role->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $role->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $role->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('web.roles.edit', $role) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this role?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No roles found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($roles->hasPages())
        <div class="card-footer">{{ $roles->links() }}</div>
    @endif
</div>
@endsection
