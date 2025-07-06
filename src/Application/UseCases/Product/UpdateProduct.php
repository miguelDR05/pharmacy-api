<?php

namespace Application\UseCases\Product;

use Domain\Repositories\ProductRepositoryInterface;
use Domain\Entities\Product as ProductEntity;

class UpdateProduct
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}

    /**
     * Execute the use case to update an existing product.
     *
     * @param int $id The ID of the product to update
     * @param array $data Data for updating the product (ideally a DTO)
     * @return ProductEntity The updated product entity
     */
    public function execute(int $id, array $data): ProductEntity
    {
        // Considerar DTOs para $data
        // Agregar lógica de negocio if necesario antes de actualizar

        $product = $this->productRepository->update($id, $data);

        return $product;
    }
}