<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Domain\Entities\User; // Usa tu namespace correcto
use Infrastructure\Persistence\Eloquent\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Asegúrate que exista el rol
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'sanctum',
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@farmacia.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
                'created_at' => 1,
                'updated_at' => 1,
            ]
        );

        $admin->assignRole('admin');
    }
}
