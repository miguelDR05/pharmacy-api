<?php

namespace Infrastructure\Persistence\Eloquent\Repositories;

use Domain\Repositories\ProductRepositoryInterface;
use Infrastructure\Persistence\Eloquent\Models\Product as EloquentProductModel;
use Domain\Entities\Product as ProductEntity;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function __construct(private EloquentProductModel $eloquentProduct) {}

    public function findById(int $id): ?ProductEntity
    {
        $product = $this->eloquentProduct->find($id);
        if (!$product) {
            return null;
        }
        return $this->mapEloquentToEntity($product);
    }

    public function findByBarcode(string $barcode): ?ProductEntity
    {
        $product = $this->eloquentProduct->where('barcode', $barcode)->first();
        if (!$product) {
            return null;
        }
        return $this->mapEloquentToEntity($product);
    }

    public function getAll(): LengthAwarePaginator
    {
        $paginator = $this->eloquentProduct->paginate();
        $paginator->getCollection()->transform(function ($product) {
            return $this->mapEloquentToEntity($product);
        });
        return $paginator;
    }

    public function getLowStock(): LengthAwarePaginator
    {
        $paginator = $this->eloquentProduct->whereColumn('stock', '<=', 'min_stock')->paginate();
        $paginator->getCollection()->transform(function ($product) {
            return $this->mapEloquentToEntity($product);
        });
        return $paginator;
    }

    public function create(array $data): ProductEntity
    {
        $product = $this->eloquentProduct->create($data);
        return $this->mapEloquentToEntity($product);
    }

    public function update(int $id, array $data): ProductEntity
    {
        $product = $this->eloquentProduct->findOrFail($id);

        $product->update($data);
        return $this->mapEloquentToEntity($product);
    }

    public function delete(int $id, int $userId): bool // Implementación de eliminación lógica
    {
        try {
            $product = $this->eloquentProduct->findOrFail($id);
            $product->active = false; // Eliminación lógica
            $product->user_updated = $userId; // Registrar usuario
            $product->save();
            return true;
        } catch (ModelNotFoundException $e) {
            // Manejar el caso donde el producto no se encuentra
            // Considera lanzar una excepción de dominio en su lugar si prefieres
            return false;
        }
    }

    public function updateStock(int $id, int $quantity): bool // Considerar agregar $userId a la interfaz y aquí
    {
        try {
            $product = $this->eloquentProduct->findOrFail($id);
            $product->stock += $quantity;
            return $product->save();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    // Método de mapeo privado
    private function mapEloquentToEntity(EloquentProductModel $eloquentProduct): ProductEntity
    {
         return new ProductEntity(
            id: $eloquentProduct->id,
            name: $eloquentProduct->name,
            barcode: $eloquentProduct->barcode,
            price: $eloquentProduct->price,
            category_id: $eloquentProduct->category_id,
            description: $eloquentProduct->description,
            stock: $eloquentProduct->stock,
            expiration_date: $eloquentProduct->expiration_date ? $eloquentProduct->expiration_date->toDateString() : null,
            purchase_price: $eloquentProduct->purchase_price,
            active: $eloquentProduct->active,
            min_stock: $eloquentProduct->min_stock,
            user_created: $eloquentProduct->user_created,
            user_updated: $eloquentProduct->user_updated,
            created_at: $eloquentProduct->created_at?->toDateTimeString(),
            updated_at: $eloquentProduct->updated_at?->toDateTimeString(),
        );
    }
}
