php
<?php

namespace Domain\Entities;

// No extender de Model ni usar SoftDeletes aquí

class Product
{
    public function __construct(
        public ?int $id, // Puede ser null si es un producto nuevo
        public string $name,
        public ?string $barcode,
        public float $price,
        public int $category_id,
        public ?string $description, // Agregado
        public int $stock, // Agregado
        public ?string $expiration_date, // O usar un objeto DateTime si prefieres
        public ?float $purchase_price, // Agregado
        public bool $active, // Agregado
        public ?int $user_created,
        public ?int $user_updated,
        public ?string $created_at,
        public ?string $updated_at,
        // Considera agregar propiedades para relaciones si son cruciales en el dominio,
        // pero sin acoplamiento a Eloquent (ej: un objeto Category en lugar de belongsTo)
    ) {}

    // Métodos de negocio relevantes para la Entidad (ej: isLowStock si aplica aquí)
     public function isLowStock(int $minStock): bool
     {
         return $this->stock <= $minStock;
     }
}
