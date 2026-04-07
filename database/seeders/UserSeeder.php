<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();

        User::firstOrCreate(['email' => 'admin@mailinator.com'], [
            'full_name' => 'System Administrator',
            'username'  => 'admin',
            'email'     => 'admin@mailinator.com',
            'phone'     => '9999999999',
            'password'  => Hash::make('Admin@1234'),
            'role_id'   => $adminRole->id,
            'status'    => 'active',
        ]);
    }
}
