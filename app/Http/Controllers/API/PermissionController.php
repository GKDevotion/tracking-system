<?php

namespace App\Http\Controllers\API;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends BaseApiController
{
    public function show(Role $role)
    {
        $menus       = Menu::where('is_active', true)->with('children')->whereNull('parent_id')->get();
        $permissions = Permission::where('role_id', $role->id)->with('menu')->get();

        return $this->success('Permissions retrieved.', [
            'role'        => $role,
            'menus'       => $menus,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'permissions'              => 'nullable|array',
            'permissions.*.menu_id'    => 'required|exists:menus,id',
            'permissions.*.can_view'   => 'boolean',
            'permissions.*.can_insert' => 'boolean',
            'permissions.*.can_edit'   => 'boolean',
            'permissions.*.can_delete' => 'boolean',
        ]);

        Permission::where('role_id', $role->id)->delete();

        if (!empty($data['permissions'])) {
            foreach ($data['permissions'] as $perm) {
                Permission::create([
                    'role_id'    => $role->id,
                    'menu_id'    => $perm['menu_id'],
                    'can_view'   => $perm['can_view']   ?? false,
                    'can_insert' => $perm['can_insert'] ?? false,
                    'can_edit'   => $perm['can_edit']   ?? false,
                    'can_delete' => $perm['can_delete'] ?? false,
                ]);
            }
        }

        return $this->success('Permissions updated.', Permission::where('role_id', $role->id)->with('menu')->get());
    }
}
