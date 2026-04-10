<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PricingPlanCheckoutMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu = Menu::create([
            'name' => 'Pricing Plan Checkout',
            'slug' => 'pricing-plan-checkout',
            'icon' => 'bi bi-receipt',
            'route' => 'web.pricing-plan-checkout.index',
            'parent_id' => null,
            'sort_order' => 10,
            'is_active' => true,
        ]);

        // Add permissions for admin role
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            Permission::create([
                'role_id' => $adminRole->id,
                'menu_id' => $menu->id,
                'can_view' => true,
                'can_insert' => false,
                'can_edit' => true,
                'can_delete' => false,
            ]);
        }
    }
}
