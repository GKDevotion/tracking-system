<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Parent menus
        $dashboard = Menu::firstOrCreate(['slug' => 'dashboard'], [
            'name'       => 'Dashboard',
            'slug'       => 'dashboard',
            'icon'       => 'bi bi-speedometer2',
            'route'      => 'web.dashboard',
            'parent_id'  => null,
            'sort_order' => 1,
            'is_active'  => true,
        ]);

        $tracking = Menu::firstOrCreate(['slug' => 'tracking'], [
            'name'       => 'Tracking',
            'slug'       => 'tracking',
            'icon'       => 'bi bi-geo-alt',
            'route'      => 'web.tracking.index',
            'parent_id'  => null,
            'sort_order' => 2,
            'is_active'  => true,
        ]);

        $users = Menu::firstOrCreate(['slug' => 'users'], [
            'name'       => 'Users',
            'slug'       => 'users',
            'icon'       => 'bi bi-people',
            'route'      => 'web.users.index',
            'parent_id'  => null,
            'sort_order' => 3,
            'is_active'  => true,
        ]);

        $settings = Menu::firstOrCreate(['slug' => 'settings'], [
            'name'       => 'Settings',
            'slug'       => 'settings',
            'icon'       => 'bi bi-gear',
            'route'      => null,
            'parent_id'  => null,
            'sort_order' => 4,
            'is_active'  => true,
        ]);

        // Settings children
        $children = [
            ['name' => 'Role',            'slug' => 'settings-role',            'icon' => 'bi bi-shield',         'route' => 'roles.index',            'sort_order' => 1],
            ['name' => 'Menu',            'slug' => 'settings-menu',            'icon' => 'bi bi-list',           'route' => 'menus.index',            'sort_order' => 2],
            ['name' => 'Permission',      'slug' => 'settings-permission',      'icon' => 'bi bi-key',            'route' => 'permissions.index',      'sort_order' => 3],
            ['name' => 'Change Password', 'slug' => 'settings-change-password', 'icon' => 'bi bi-lock',           'route' => 'change.password.form',   'sort_order' => 4],
        ];

        foreach ($children as $child) {
            Menu::firstOrCreate(['slug' => $child['slug']], array_merge($child, [
                'parent_id' => $settings->id,
                'is_active' => true,
            ]));
        }
    }
}
