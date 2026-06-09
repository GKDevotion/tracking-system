@extends('layouts.app')
@section('title','Permissions')
@section('page-title','Permission Management')

@section('content')
<div class="row g-3">
    @forelse($roles as $role)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <div style="width:38px;height:38px;background:rgba(59,130,246,.1);border-radius:10px;display:flex;align-items:center;justify-content:center">
                                <i class="bi bi-shield text-primary"></i>
                            </div>
                            <strong>{{ $role->name }}</strong>
                        </div>
                        <small class="text-muted">{{ $role->description ?? 'No description' }}</small>
                    </div>
                    <a href="{{ route('permissions.show', $role) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-key me-1"></i>Set
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">No roles found. <a href="{{ route('web.roles.create') }}">Create a role first.</a></div>
        </div>
    @endforelse
</div>
@endsection
