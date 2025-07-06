<?php

use Illuminate\Support\Facades\Route;
use Interface\Http\Controllers\AuthController;
use Domain\Services\AuthServiceInterface;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/test-binding', function (AuthServiceInterface $authService) {
    return get_class($authService);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // ➡️ aquí tus rutas protegidas...
});
