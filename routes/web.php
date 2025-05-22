<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminPriceController;
use App\Http\Controllers\AdminStockController;
use App\Http\Controllers\AdminOutletController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\AdminOrderItemController;
use App\Http\Controllers\AdminReportController;

// VIEWS
Route::get('/', [IndexController::class, 'index'])->middleware('guest');

Route::middleware(['guest', 'check.outlet.code'])->group(function () {
    Route::get('/{outlet_code}/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/{outlet_code}/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/{outlet_code}/login', [AuthController::class, 'login']);
    Route::post('/{outlet_code}/register', [AuthController::class, 'register']);
});

Route::middleware(['auth.customer', 'check.outlet.code'])->group(function () {
    Route::get('/{outlet_code}/menu-page', [MenuController::class, 'index'])->name('menu-page');
    Route::get('/{outlet_code}/cart-page', [CartController::class, 'index'])->name('cart-page');
    Route::get('/{outlet_code}/payment-page/{order_number}', [PaymentController::class, 'index'])->name('payment-page');
    Route::get('/{outlet_code}/payment-method-page', [PaymentMethodController::class, 'index'])->name('payment-method-page');
    Route::get('/{outlet_code}/orders/history', [OrderController::class, 'index'])->name('order-history-page');
    Route::get('/{outlet_code}/orders/{order_number}', [OrderController::class, 'show'])->name('order-detail-page');

    Route::resource('/{outlet_code}/orders', OrderController::class);

    Route::post('/{outlet_code}/payment-method-store', [PaymentMethodController::class, 'store']);
    Route::post('/{outlet_code}/logout', [AuthController::class, 'logout']);
});

// SESSION
Route::get('/check-session', function () {
    return response()->json([
        'authenticated' => Auth::guard('customer')->check()
    ]);
});

Route::post('/clear-payment-session', function () {
    session()->forget('selected_payment_method');
});


// DASHBOARD
Route::get('/login', [AdminLoginController::class, 'index'])->name('login')->middleware('guest');

Route::post('/login', [AdminLoginController::class, 'authenticate']);
Route::post('/logout', [AdminLoginController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Administrator
    Route::get('/dashboard', [AdminDashboardController::class, 'indexAdministrator']);

    Route::resource('/dashboard/users', AdminUserController::class);
    Route::resource('/dashboard/customers', AdminCustomerController::class);
    Route::resource('/dashboard/outlets', AdminOutletController::class);
    Route::resource('/dashboard/menus', AdminMenuController::class);
    Route::resource('/dashboard/stocks', AdminStockController::class);
    Route::resource('/dashboard/prices', AdminPriceController::class);
    Route::resource('/dashboard/orders', AdminOrderController::class);
    Route::resource('/dashboard/orderitems', AdminOrderItemController::class);
    Route::get('/dashboard/reports', [AdminReportController::class, 'index']);

    // Route::get('/get-users/{outletCode}', [AdminOrderController::class, 'getUsers']);
    Route::get('/get-menus/{outletCode}', [AdminOrderController::class, 'getMenus']);
    Route::get('/dashboard/orders-by-outlet', [AdminReportController::class, 'ordersByOutlet']);

    // Kasir, Produksi
    Route::get('/{outlet_code}/dashboard', [AdminDashboardController::class, 'index'])
        ->where('outlet_code', '[a-zA-Z0-9-_]+');

    Route::resource('/{outlet_code}/dashboard/menus', AdminMenuController::class);
    Route::resource('/{outlet_code}/dashboard/stocks', AdminStockController::class);
    Route::resource('/{outlet_code}/dashboard/prices', AdminPriceController::class);
    Route::resource('/{outlet_code}/dashboard/orders', AdminOrderController::class);
    Route::resource('/{outlet_code}/dashboard/orderitems', AdminOrderItemController::class);
    Route::get('/{outlet_code}/dashboard/reports', [AdminReportController::class, 'index']);
});
