<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminPriceController;
use App\Http\Controllers\AdminStockController;
use App\Http\Controllers\AdminOutletController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminOrderItemController;
use App\Http\Controllers\DashboardController;

// VIEWS
Route::middleware(['guest'])->group(function () {
    Route::get('/', [OutletController::class, 'index']);

    Route::get('/{outlet_code}/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/{outlet_code}/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/{outlet_code}/login', [AuthController::class, 'login']);
    Route::post('/{outlet_code}/register', [AuthController::class, 'register']);
});

Route::middleware(['auth.customer'])->group(function () {
    Route::get('/{outlet_code}/menu-page', [MenuController::class, 'index'])->name('menu-page');
    Route::get('/{outlet_code}/cart-page', [CartController::class, 'index'])->name('cart-page');

    Route::post('/{outlet_code}/logout', [AuthController::class, 'logout']);
});


// DASHBOARD
Route::get('/login', [AdminLoginController::class, 'index'])->name('login')->middleware('guest');

Route::post('/login', [AdminLoginController::class, 'authenticate']);
Route::post('/logout', [AdminLoginController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/{outlet}/dashboard', [DashboardController::class, 'index'])
        ->where('outlet', '[a-zA-Z0-9-_]+');

    Route::get('/dashboard', [DashboardController::class, 'indexAdministrator']);

    Route::resource('/dashboard/users', AdminUserController::class);
    Route::resource('/dashboard/customers', AdminCustomerController::class);
    Route::resource('/dashboard/outlets', AdminOutletController::class);
    Route::resource('/dashboard/menus', AdminMenuController::class);
    Route::resource('/dashboard/stocks', AdminStockController::class);
    Route::resource('/dashboard/prices', AdminPriceController::class);
    Route::resource('/dashboard/orders', AdminOrderController::class);
    Route::resource('/dashboard/orderitems', AdminOrderItemController::class);

    Route::get('/get-users/{outletCode}', [AdminOrderController::class, 'getUsers']);
    Route::get('/get-menus/{outletCode}', [AdminOrderController::class, 'getMenus']);
});
