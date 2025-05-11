<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransController;

Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook']);
