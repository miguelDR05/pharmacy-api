php
<?php

namespace Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'barcode',
        'price',
        'category_id',
        'description', // Agregado
        'stock', // Agregado
        'expiration_date', // Agregado
        'purchase_price', // Agregado
        'active', // Cambiado de is_active
        'user_created',
        'user_updated',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'purchase_price' => 'decimal:2', // Agregado el casteo
        'stock' => 'integer', // Agregado el casteo
        'expiration_date' => 'date', // Agregado el casteo
        'active' => 'boolean', // Cambiado de is_active
    ];


    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the sales for the product.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(SaleProducts::class);
    }
}
