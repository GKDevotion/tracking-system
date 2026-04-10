<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu = Menu::create([
            'name' => 'Subscription Plans',
            'slug' => 'subscription-plans',
            'icon' => 'bi bi-card-text',
            'route' => 'web.plans.index',
            'parent_id' => null,
            'sort_order' => 9,
            'is_active' => true,
        ]);

        // Add permissions for admin role
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            Permission::create([
                'role_id' => $adminRole->id,
                'menu_id' => $menu->id,
                'can_view' => true,
                'can_insert' => true,
                'can_edit' => true,
                'can_delete' => true,
            ]);
        }
    }
}
