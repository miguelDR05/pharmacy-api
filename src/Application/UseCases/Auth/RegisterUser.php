<?php

namespace Application\UseCases\Auth;

use Domain\Entities\User;
use Illuminate\Support\Facades\Hash;
use Infrastructure\Persistence\Eloquent\Models\Role;

class RegisterUser
{
    public function handle(array $data): User
    {
        $role = Role::where('name', $data['role'])->firstOrFail();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $role->id,
            'active' => true,
            'user_created' => 1,
            'user_updated' => 1,
        ]);

        $user->assignRole($role->name);
        return $user;
    }
}
