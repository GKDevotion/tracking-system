<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $menus     = Menu::all();

        foreach ($menus as $menu) {
            Permission::firstOrCreate(
                ['role_id' => $adminRole->id, 'menu_id' => $menu->id],
                [
                    'can_view'   => true,
                    'can_insert' => true,
                    'can_edit'   => true,
                    'can_delete' => true,
                ]
            );
        }
    }
}
