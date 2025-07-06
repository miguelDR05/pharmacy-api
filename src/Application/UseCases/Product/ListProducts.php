<?php

namespace Application\UseCases\Product;

use Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListProducts
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}

    /**
     * Execute the use case to list all products with pagination.
     *
     * @param array $filters Optional filters for listing products
     * @return LengthAwarePaginator A paginated collection of Product entities
     */
    public function execute(array $filters = []): LengthAwarePaginator
    {
        // Here you could process the filters before passing them to the repository.
        // For now, calling getAll() which the repository handles pagination.

        $products = $this->productRepository->getAll();

        return $products;
    }
}