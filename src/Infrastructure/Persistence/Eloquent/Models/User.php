<?php

namespace Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'active',
        'user_created',
        'user_updated'
    ];

    protected $hidden = ['password', 'remember_token'];
}
