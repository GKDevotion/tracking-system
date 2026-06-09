@extends('layouts.app')
@section('title','User Details')
@section('page-title','User Details')

@section('content')
<div class="row g-4">
    {{-- User Info Card --}}
    <div class="col-lg-4">
        <div class="card text-center p-4">
            <div style="width:80px;height:80px;background:linear-gradient(135deg,#3b82f6,#8b5cf6);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.75rem;font-weight:800;margin:0 auto 1rem">
                {{ strtoupper(substr($user->full_name, 0, 2)) }}
            </div>
            <h5 class="fw-bold mb-0">{{ $user->full_name }}</h5>
            <p class="text-muted mb-3">@{{ $user->username }}</p>
            <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }} px-3 py-2 mb-4">
                {{ ucfirst($user->status) }}
            </span>

            <div class="text-start">
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-envelope text-primary"></i>
                    <span style="font-size:.875rem">{{ $user->email }}</span>
                </div>
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-phone text-primary"></i>
                    <span style="font-size:.875rem">{{ $user->phone }}</span>
                </div>
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-shield text-primary"></i>
                    <span style="font-size:.875rem">{{ $user->role->name ?? '—' }}</span>
                </div>
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-calendar text-primary"></i>
                    <span style="font-size:.875rem">{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('web.users.edit', $user) }}" class="btn btn-primary btn-sm flex-fill">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <a href="{{ route('web.users.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">Back</a>
            </div>
        </div>
    </div>

    {{-- Permissions Card --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-key text-primary"></i>
                <strong>Assigned Permissions</strong>
                <span class="badge bg-secondary rounded-pill">{{ $permissions->count() }}</span>
            </div>
            <div class="card-body p-0">
                @if($permissions->isEmpty())
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-key display-4 d-block mb-2 opacity-25"></i>
                        No permissions assigned to this role.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th class="text-center">View</th>
                                    <th class="text-center">Insert</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $perm)
                                    <tr>
                                        <td>
                                            @if($perm->menu->icon)<i class="{{ $perm->menu->icon }} me-1 text-muted"></i>@endif
                                            {{ $perm->menu->name ?? '—' }}
                                        </td>
                                        @foreach(['can_view','can_insert','can_edit','can_delete'] as $ability)
                                            <td class="text-center">
                                                @if($perm->$ability)
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                @else
                                                    <i class="bi bi-x-circle-fill text-danger opacity-25"></i>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
