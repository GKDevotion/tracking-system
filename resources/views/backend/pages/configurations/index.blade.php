@extends('layouts.app')
@section('title','Configurations')
@section('page-title','Configuration Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-gear text-primary"></i>
            <strong>Configurations</strong>
            <span class="badge bg-primary rounded-pill">{{ $configurations->total() }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search configurations...">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            </form>
            <a href="{{ route('web.configurations.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Configuration
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Sr</th> 
                        <th>Key</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($configurations as $i => $config)
                        <tr>
                            <td>{{ $configurations->firstItem() + $i }}</td> 
                            <td><strong>{{ $config->key }}</strong></td>
                            <td>{{ $config->value }}</td>
                            <td>
                                <a href="{{ route('web.configurations.edit', $config) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('web.configurations.destroy', $config) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this configuration?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No configurations found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($configurations->hasPages())
        <div class="card-footer">{{ $configurations->links() }}</div>
    @endif
</div>
@endsection