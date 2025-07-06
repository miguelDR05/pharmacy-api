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
        User::firstOrCreate(
            [
                'name' => 'admin',
                'email' => 'admin@farmacia.com',
                'password' => Hash::make('admin123'),
                'role_id' => 1
            ]
        );
    }
}
