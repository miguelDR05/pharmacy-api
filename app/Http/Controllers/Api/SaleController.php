<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\UseCases\CreateSaleUseCase;
use App\Domain\Repositories\SaleRepositoryInterface;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(
        private SaleRepositoryInterface $saleRepository,
        private CreateSaleUseCase $createSaleUseCase
    ) {}

    public function index(): JsonResponse
    {
        $sales = $this->saleRepository->getAll();

        return response()->json([
            'success' => true,
            'data' => SaleResource::collection($sales)
        ]);
    }

    public function store(SaleRequest $request): JsonResponse
    {
        try {
            $sale = $this->createSaleUseCase->execute($request->validated());

            return response()->json([
                'success' => true,
                'data' => new SaleResource($sale),
                'message' => 'Venta registrada exitosamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function dailySales(Request $request): JsonResponse
    {
        $date = $request->input('date', now()->toDateString());
        $sales = $this->saleRepository->getDailySales($date);
        $totalAmount = $this->saleRepository->getTotalSalesAmount($date);

        return response()->json([
            'success' => true,
            'data' => SaleResource::collection($sales),
            'meta' => [
                'date' => $date,
                'total_amount' => $totalAmount,
                'total_sales' => $sales->count()
            ]
        ]);
    }
}
