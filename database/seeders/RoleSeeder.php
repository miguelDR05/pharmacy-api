<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Infrastructure\Persistence\Eloquent\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin', 'description' => 'administrador']);
        Role::firstOrCreate(['name' => 'pharmacist', 'description' => 'Farmaseutica']);
        Role::firstOrCreate(['name' => 'cashier', 'description' => 'Cajera ']);
    }
}
