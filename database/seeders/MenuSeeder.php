<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Parent menus
        $dashboard = Menu::firstOrCreate(['slug' => 'dashboard'], [
            'name'       => 'Dashboard',
            'slug'       => 'dashboard',
            'icon'       => 'bi bi-speedometer2',
            'route'      => 'dashboard',
            'parent_id'  => null,
            'sort_order' => 1,
            'is_active'  => true,
        ]);

        // 2. Tracking Management
        $tracking = Menu::firstOrCreate(['slug' => 'tracking'], [
            'name'       => 'Tracking',
            'slug'       => 'tracking',
            'icon'       => 'bi bi-geo-alt',
            'route'      => 'tracking.index',
            'parent_id'  => null,
            'sort_order' => 2,
            'is_active'  => true,
        ]);

        // 3. Blog Management
        $blogs = Menu::firstOrCreate(['slug' => 'blog-management'], [
            'name'       => 'Blog MGT',
            'slug'       => 'blog-management',
            'icon'       => 'bi bi-people',
            'route'      => null,
            'parent_id'  => null,
            'sort_order' => 3,
            'is_active'  => true,
        ]);

            // User children
            $children = [
                ['name' => 'Tag',            'slug' => 'blog-tag',            'icon' => 'bi bi-shield',         'route' => 'tag.index',            'sort_order' => 1],
                ['name' => 'Category',            'slug' => 'blog-category',            'icon' => 'bi bi-list',           'route' => 'category.index',            'sort_order' => 2],
                ['name' => 'Blog',      'slug' => 'blog',      'icon' => 'bi bi-key',            'route' => 'blog.index',      'sort_order' => 3],
            ];

            foreach ($children as $child) {
                Menu::firstOrCreate(['slug' => $child['slug']], array_merge($child, [
                    'parent_id' => $blogs->id,
                    'is_active' => true,
                ]));
            }

        // 4. User Management
        $users = Menu::firstOrCreate(['slug' => 'user-management'], [
            'name'       => 'User MGT',
            'slug'       => 'user-management',
            'icon'       => 'bi bi-people',
            'route'      => null,
            'parent_id'  => null,
            'sort_order' => 4,
            'is_active'  => true,
        ]);

            // User children
            $children = [
                ['name' => 'Sales',            'slug' => 'users-sales',            'icon' => 'bi bi-shield',         'route' => 'sales.index',            'sort_order' => 1],
                ['name' => 'Manager',            'slug' => 'users-manager',            'icon' => 'bi bi-list',           'route' => 'users.index',            'sort_order' => 2],
                ['name' => 'Admin',      'slug' => 'users-admin',      'icon' => 'bi bi-key',            'route' => 'admins.index',      'sort_order' => 3],
            ];

            foreach ($children as $child) {
                Menu::firstOrCreate(['slug' => $child['slug']], array_merge($child, [
                    'parent_id' => $users->id,
                    'is_active' => true,
                ]));
            }

        // 4. Subscribe Management
        $users = Menu::firstOrCreate(['slug' => 'subscribe-management'], [
            'name'       => 'Subscribe MGT',
            'slug'       => 'subscribe-management',
            'icon'       => 'bi bi-people',
            'route'      => null,
            'parent_id'  => null,
            'sort_order' => 4,
            'is_active'  => true,
        ]);

            // User children
            $children = [
                ['name' => 'Pricing Plan',            'slug' => 'pricing-plan',            'icon' => 'bi bi-shield',         'route' => 'sales.index',            'sort_order' => 1],
                ['name' => 'Subscription Plans',            'slug' => 'subscription-plans',            'icon' => 'bi bi-list',           'route' => 'users.index',            'sort_order' => 2],
            ];

            foreach ($children as $child) {
                Menu::firstOrCreate(['slug' => $child['slug']], array_merge($child, [
                    'parent_id' => $users->id,
                    'is_active' => true,
                ]));
            }

        // 40. Setting
        $settings = Menu::firstOrCreate(['slug' => 'settings'], [
            'name'       => 'Settings',
            'slug'       => 'settings',
            'icon'       => 'bi bi-gear',
            'route'      => null,
            'parent_id'  => null,
            'sort_order' => 40,
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
