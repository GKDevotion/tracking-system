@extends('layouts.app')
@section('title','Users')
@section('page-title','User Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-people text-primary"></i>
            <strong>Users</strong>
            <span class="badge bg-primary rounded-pill">{{ $users->total() }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search name/email...">
                <select name="role_id" class="form-select form-select-sm">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            </form>
            <a href="{{ route('web.users.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add User
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $i }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:32px;height:32px;background:linear-gradient(135deg,#3b82f6,#8b5cf6);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.75rem;font-weight:700">
                                        {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                    </div>
                                    <strong>{{ $user->full_name }}</strong>
                                </div>
                            </td>
                            <td><code>{{ $user->username }}</code></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td><span class="badge bg-info text-dark">{{ $user->role->name ?? '—' }}</span></td>
                            <td>
                                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('web.users.show', $user) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('web.users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this user?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
        <div class="card-footer">{{ $users->links() }}</div>
    @endif
</div>
@endsection
