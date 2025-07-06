<?php

namespace Application\UseCases\Product;

use Domain\Repositories\ProductRepositoryInterface;
use Domain\Entities\Product as ProductEntity;
use Domain\Exceptions\ProductNotFoundException;

class DeleteProduct
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}

    /**
     * Execute the use case to logically delete (deactivate) a product.
     *
     * @param int $productId The ID of the product to delete
     * @param int $userId The ID of the user performing the action
     * @return bool True if the product was successfully deactivated
     * @throws ProductNotFoundException If the product is not found or could not be deactivated
     */
    public function execute(int $productId, int $userId): bool
    {
        // Lógica de negocio: Marcar el producto como inactivo y registrar el usuario que lo hizo
        // El repositorio se encargará de la implementación específica en la base de datos.

        // Llamar al repositorio para realizar la eliminación lógica y actualizar el usuario
        $success = $this->productRepository->delete($productId, $userId);

        if (!$success) {
             // Esto podría indicar que el producto no fue encontrado o algún otro problema en el repo
             throw new ProductNotFoundException("Product with ID {$productId} could not be deactivated.");
        }

        return $success;
    }
}