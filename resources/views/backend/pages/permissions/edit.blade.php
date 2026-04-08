@extends('layouts.app')
@section('title','Set Permissions — '.$role->name)
@section('page-title','Permissions: '.$role->name)

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-key text-primary"></i>
            <strong>Set Permissions for: <span class="text-primary">{{ $role->name }}</span></strong>
        </div>
        <a href="{{ route('web.permissions.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('permissions.update', $role) }}">
            @csrf

            {{-- Select All row --}}
            <div class="mb-3">
                <div class="d-flex gap-3 flex-wrap">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll(true)">
                        <i class="bi bi-check-all me-1"></i>Select All
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="selectAll(false)">
                        <i class="bi bi-x-lg me-1"></i>Deselect All
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-start" style="min-width:180px">Menu</th>
                            <th style="width:100px">View</th>
                            <th style="width:100px">Insert</th>
                            <th style="width:100px">Edit</th>
                            <th style="width:100px">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $idx = 0; @endphp
                        @foreach($menus as $menu)
                            {{-- Parent row --}}
                            <tr class="table-light">
                                <td colspan="5">
                                    <strong>
                                        @if($menu->icon)<i class="{{ $menu->icon }} me-1"></i>@endif
                                        {{ $menu->name }}
                                    </strong>
                                </td>
                            </tr>

                            @php
                                $allMenus = collect([$menu])->merge($menu->children ?? collect());
                            @endphp

                            @foreach($allMenus as $m)
                                @php $perm = $permissions[$m->id] ?? null; @endphp
                                <tr>
                                    <td class="{{ $m->parent_id ? 'ps-4' : '' }}">
                                        <input type="hidden" name="permissions[{{ $idx }}][menu_id]" value="{{ $m->id }}">
                                        @if($m->icon)<i class="{{ $m->icon }} me-1 text-muted"></i>@endif
                                        {{ $m->name }}
                                    </td>
                                    @foreach(['can_view','can_insert','can_edit','can_delete'] as $ability)
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input perm-check"
                                                   name="permissions[{{ $idx }}][{{ $ability }}]"
                                                   value="1"
                                                   {{ ($perm && $perm->$ability) ? 'checked' : '' }}>
                                        </td>
                                    @endforeach
                                </tr>
                                @php $idx++; @endphp
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Save Permissions
                </button>
                <a href="{{ route('web.permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectAll(state) {
    document.querySelectorAll('.perm-check').forEach(cb => cb.checked = state);
}
</script>
@endpush
