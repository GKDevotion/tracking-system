<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin',   'description' => 'Full system access',    'is_active' => true],
            ['name' => 'Manager', 'description' => 'Management level access', 'is_active' => true],
            ['name' => 'User',    'description' => 'Standard user access',   'is_active' => true],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
