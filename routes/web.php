<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminPriceController;
use App\Http\Controllers\AdminStockController;
use App\Http\Controllers\AdminOutletController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminOrderItemController;

Route::get('/', function () {
    return inertia('Home');
});

// Route::get('/dashboard/login', [AdminLoginController::class, 'index'])->name('login')->middleware('guest');

Route::get('/dashboard', function() {
    return view('dashboard.index');
});
// ->middleware('auth');

Route::resource('/dashboard/users', AdminUserController::class);

Route::resource('/dashboard/customers', AdminCustomerController::class);

Route::resource('/dashboard/outlets', AdminOutletController::class);
Route::resource('/dashboard/menus', AdminMenuController::class);
Route::resource('/dashboard/stocks', AdminStockController::class);
Route::resource('/dashboard/prices', AdminPriceController::class);

Route::resource('/dashboard/orders', AdminOrderController::class);
Route::get('/get-users/{outletCode}', [AdminOrderController::class, 'getUsers']);
Route::get('/get-menus/{outletCode}', [AdminOrderController::class, 'getMenus']);

Route::resource('/dashboard/orderitems', AdminOrderItemController::class);

// Route::post('/login', [LoginController::class, 'authenticate']);
// Route::post('/logout', [LoginController::class, 'logout']);
