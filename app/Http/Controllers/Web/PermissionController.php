<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::where('is_active', true)->get();
        return view('permissions.index', compact('roles'));
    }

    public function show(Role $role)
    {
        $menus       = Menu::whereNull('parent_id')->with('children')->where('is_active', true)->orderBy('sort_order')->get();
        $permissions = Permission::where('role_id', $role->id)->get()->keyBy('menu_id');

        return view('permissions.edit', compact('role', 'menus', 'permissions'));
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

        // Delete existing and re-insert
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

        return redirect()->route('permissions.show', $role)->with('success', 'Permissions updated successfully.');
    }
}
