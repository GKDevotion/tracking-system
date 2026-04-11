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
            'route'      => 'dashboard.index',
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
                ['name' => 'Tag', 'slug' => 'blog-tag', 'icon' => 'bi bi-shield', 'route' => 'blog-tag.index', 'sort_order' => 1],
                ['name' => 'Category', 'slug' => 'blog-category', 'icon' => 'bi bi-list', 'route' => 'blog-category.index', 'sort_order' => 2],
                ['name' => 'Blog', 'slug' => 'blogs', 'icon' => 'bi bi-key', 'route' => 'blogs.index', 'sort_order' => 3],
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
                ['name' => 'Sales', 'slug' => 'sales-user', 'icon' => 'bi bi-shield', 'route' => 'sales-user.index', 'sort_order' => 1],
                ['name' => 'Manager', 'slug' => 'manager-user', 'icon' => 'bi bi-list', 'route' => 'manager-user.index', 'sort_order' => 2],
                ['name' => 'Admin', 'slug' => 'admin-user', 'icon' => 'bi bi-key', 'route' => 'admin-user.index', 'sort_order' => 3],
            ];

            foreach ($children as $child) {
                Menu::firstOrCreate(['slug' => $child['slug']], array_merge($child, [
                    'parent_id' => $users->id,
                    'is_active' => true,
                ]));
            }

        // 4. Subscribe Management
        $subscribe = Menu::firstOrCreate(['slug' => 'subscribe-management'], [
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
                ['name' => 'Payment History', 'slug' => 'pricing-plan', 'icon' => 'bi bi-shield', 'route' => 'pricing-plan-checkout.index', 'sort_order' => 1],
                ['name' => 'Plans', 'slug' => 'subscription-plans', 'icon' => 'bi bi-list', 'route' => 'plans.index', 'sort_order' => 2],
            ];

            foreach ($children as $child) {
                Menu::firstOrCreate(['slug' => $child['slug']], array_merge($child, [
                    'parent_id' => $subscribe->id,
                    'is_active' => true,
                ]));
            }

        // 5. Business Mail Management
        $business = Menu::firstOrCreate(['slug' => 'business-mail'], [
            'name'       => 'Business Mail',
            'slug'       => 'business-mail',
            'icon'       => 'bi bi-people',
            'route'      => null,
            'parent_id'  => null,
            'sort_order' => 5,
            'is_active'  => true,
        ]);

            // User children
            $children = [
                ['name' => 'Category', 'slug' => 'business-category', 'icon' => 'bi bi-shield', 'route' => 'bm-category.index', 'sort_order' => 1],
                ['name' => 'Mail Template', 'slug' => 'business-mail-template', 'icon' => 'bi bi-list', 'route' => 'bm-mail-template.index', 'sort_order' => 2],
                ['name' => 'Client', 'slug' => 'business-client', 'icon' => 'bi bi-shield', 'route' => 'bm-client.index', 'sort_order' => 1],
                ['name' => 'Mail Log', 'slug' => 'business-mail-log', 'icon' => 'bi bi-list', 'route' => 'bm-mail-logs.index', 'sort_order' => 2],
            ];

            foreach ($children as $child) {
                Menu::firstOrCreate(['slug' => $child['slug']], array_merge($child, [
                    'parent_id' => $business->id,
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
                ['name' => 'Configuration', 'slug' => 'configuration', 'icon' => 'bi bi-lock', 'route' => 'configurations.index',   'sort_order' => 1],
                ['name' => 'Role', 'slug' => 'settings-role', 'icon' => 'bi bi-shield', 'route' => 'roles.index', 'sort_order' => 2],
                ['name' => 'Menu', 'slug' => 'settings-menu', 'icon' => 'bi bi-list', 'route' => 'menus.index', 'sort_order' => 3],
                ['name' => 'Permission', 'slug' => 'settings-permission', 'icon' => 'bi bi-key', 'route' => 'permissions.index', 'sort_order' => 4],
                ['name' => 'Change Password', 'slug' => 'settings-change-password', 'icon' => 'bi bi-lock', 'route' => 'change.password.form', 'sort_order' => 5],
            ];

            foreach ($children as $child) {
                Menu::firstOrCreate(['slug' => $child['slug']], array_merge($child, [
                    'parent_id' => $settings->id,
                    'is_active' => true,
                ]));
            }
    }
}
