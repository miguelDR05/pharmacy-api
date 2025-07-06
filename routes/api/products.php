php
<?php

use Illuminate\Support\Facades\Route;
use Interface\Http\Controllers\Api\ProductController;

Route::apiResource('products', ProductController::class);

// Si necesitas una ruta específica para actualizar stock (fuera del update general)
// Route::patch('/products/{product}/stock', [ProductController::class, 'updateStock']);