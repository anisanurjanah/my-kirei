<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::post('/midtrans/callback', [MidtransController::class, 'handleNotification']);
Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook']);
