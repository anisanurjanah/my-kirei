<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OutletController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/{outlet_code}/register', [AuthController::class, 'register']);

Route::post('/{outlet_code}/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::get('/customer', [AuthController::class, 'customer'])->middleware('auth:sanctum');

Route::get('/outlets', [OutletController::class, 'index']);
