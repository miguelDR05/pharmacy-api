<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;
    public function findByBarcode(string $barcode): ?Product;
    public function getAll(): LengthAwarePaginator;
    public function getLowStock(): LengthAwarePaginator;
    public function create(array $data): Product;
    public function update(int $id, array $data): Product;
    public function delete(int $id, int $userId): bool;
    public function updateStock(int $id, int $quantity): bool;
}
