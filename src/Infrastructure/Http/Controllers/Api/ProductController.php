<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function index(): JsonResponse
    {
        $products = $this->productRepository->getAll();

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
            'meta' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
            ]
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product)
        ]);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->productRepository->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
            'message' => 'Producto creado exitosamente'
        ], 201);
    }

    public function update(ProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productRepository->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
            'message' => 'Producto actualizado exitosamente'
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->productRepository->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ]);
    }

    public function lowStock(): JsonResponse
    {
        $products = $this->productRepository->getLowStock();

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
            'message' => 'Productos con stock bajo'
        ]);
    }
}
