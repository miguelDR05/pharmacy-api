<?php

namespace Application\UseCases\Product;

use Domain\Repositories\ProductRepositoryInterface;
use Domain\Entities\Product as ProductEntity;

class GetProduct
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}

    /**
     * Execute the use case to get a product by its ID.
     *
     * @param int $id The ID of the product
     * @return ProductEntity|null The product entity or null if not found
     */
    public function execute(int $id): ?ProductEntity
    {
        $product = $this->productRepository->findById($id);

        return $product;
    }
}