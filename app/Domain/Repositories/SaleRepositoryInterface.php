<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Sale;
use Illuminate\Pagination\LengthAwarePaginator;

interface SaleRepositoryInterface
{
    public function findById(int $id): ?Sale;
    public function getAll(): LengthAwarePaginator;
    public function getDailySales(string $date): LengthAwarePaginator;
    public function create(array $data): Sale;
    public function getTotalSalesAmount(string $date): float;
}
