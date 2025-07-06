<?php

namespace Application\UseCases\Product;

use Domain\Repositories\ProductRepositoryInterface;
use Domain\Entities\Product as ProductEntity;

class CreateProduct
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}

    /**
     * Execute the use case to create a new product.
     *
     * @param array $data Data for creating the product (should ideally be a DTO)
     * @return ProductEntity The created product entity
     */
    public function execute(array $data): ProductEntity
    {
        // Considerar DTOs para mayor claridad y tipado en la entrada $data

        // Agregar lógica de negocio si es necesario (ej: generar SKU, validar disponibilidad de código de barras antes de repositorio si la regla es compleja)

        $product = $this->productRepository->create($data);

        return $product;
    }
}