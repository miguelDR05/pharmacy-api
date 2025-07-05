<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Productos
    Route::apiResource('products', ProductController::class);
    Route::get('/products-low-stock', [ProductController::class, 'lowStock']);

    // Ventas
    Route::apiResource('sales', SaleController::class)->only(['index', 'store', 'show']);
    Route::get('/sales/daily', [SaleController::class, 'dailySales']);

    // Categorías
    Route::apiResource('categories', CategoryController::class);

    // Clientes
    Route::apiResource('customers', CustomerController::class);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});
