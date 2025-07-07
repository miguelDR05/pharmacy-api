<?php

namespace Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'active',
        'status',
        'user_created',
        'user_updated',
    ];

    // Relación: una categoría tiene muchos productos
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
