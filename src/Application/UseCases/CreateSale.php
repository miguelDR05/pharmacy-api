<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Repositories\SaleRepositoryInterface;
use App\Domain\Entities\Sale;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateSaleUseCase
{
    public function __construct(
        private SaleRepositoryInterface $saleRepository,
        private ProductRepositoryInterface $productRepository
    ) {}

    public function execute(array $saleData): Sale
    {
        return DB::transaction(function () use ($saleData) {
            // Validar stock disponible
            foreach ($saleData['items'] as $item) {
                $product = $this->productRepository->findById($item['product_id']);

                if (!$product) {
                    throw new Exception("Producto no encontrado: {$item['product_id']}");
                }

                if ($product->stock < $item['quantity']) {
                    throw new Exception("Stock insuficiente para: {$product->name}");
                }
            }

            // Crear la venta
            $sale = $this->saleRepository->create([
                'user_id' => $saleData['user_id'],
                'customer_id' => $saleData['customer_id'] ?? null,
                'total' => $saleData['total'],
                'discount' => $saleData['discount'] ?? 0,
                'tax' => $saleData['tax'] ?? 0,
                'payment_method' => $saleData['payment_method'],
                'receipt_number' => $this->generateReceiptNumber(),
                'notes' => $saleData['notes'] ?? null,
            ]);

            // Crear los items y actualizar stock
            foreach ($saleData['items'] as $item) {
                $sale->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price'],
                ]);

                // Actualizar stock
                $this->productRepository->updateStock(
                    $item['product_id'],
                    -$item['quantity']
                );
            }

            return $sale->load('items.product');
        });
    }

    private function generateReceiptNumber(): string
    {
        return 'RCP-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }
}
