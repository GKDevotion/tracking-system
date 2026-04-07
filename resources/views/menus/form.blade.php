@extends('layouts.app')
@section('title', $menu->exists ? 'Edit Menu' : 'Create Menu')
@section('page-title', $menu->exists ? 'Edit Menu' : 'Create Menu')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-list-ul text-primary"></i>
                <strong>{{ $menu->exists ? 'Edit Menu' : 'New Menu' }}</strong>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ $menu->exists ? route('web.menus.update', $menu) : route('menus.store') }}">
                    @csrf
                    @if($menu->exists) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Menu Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $menu->name) }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="e.g. Dashboard" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $menu->sort_order ?? 0) }}"
                                   class="form-control" min="0">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Icon Class</label>
                            <input type="text" name="icon" value="{{ old('icon', $menu->icon) }}"
                                   class="form-control" placeholder="bi bi-speedometer2">
                            <div class="form-text">Bootstrap Icons class</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Route Name</label>
                            <input type="text" name="route" value="{{ old('route', $menu->route) }}"
                                   class="form-control" placeholder="dashboard">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Parent Menu</label>
                            <select name="parent_id" class="form-select">
                                <option value="">— None (Root Menu) —</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}"
                                        {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                       id="isActive" {{ old('is_active', $menu->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>{{ $menu->exists ? 'Update' : 'Create' }} Menu
                        </button>
                        <a href="{{ route('web.menus.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
