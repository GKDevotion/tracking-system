<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends BaseApiController
{
    public function index(Request $request)
    {
        $roles = Role::when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest()->paginate(10);

        return $this->paginated('Roles retrieved.', $roles);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string|max:255',
            'is_active'   => 'boolean',
        ]);

        $role = Role::create($data);
        return $this->success('Role created.', $role, 201);
    }

    public function show(Role $role)
    {
        return $this->success('Role retrieved.', $role);
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', Rule::unique('roles')->ignore($role->id)],
            'description' => 'nullable|string|max:255',
            'is_active'   => 'boolean',
        ]);

        $role->update($data);
        return $this->success('Role updated.', $role);
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return $this->error('Cannot delete role assigned to users.', 422);
        }

        $role->delete();
        return $this->success('Role deleted.');
    }
}
