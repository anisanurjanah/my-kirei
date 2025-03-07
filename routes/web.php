<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminOutletController;
use App\Http\Controllers\AdminStockController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard/login', [AdminLoginController::class, 'index'])->name('login')->middleware('guest');

Route::get('/dashboard', function() {
    return view('dashboard.index');
});
// ->middleware('auth');

Route::resource('/dashboard/users', AdminUserController::class);

Route::resource('/dashboard/outlets', AdminOutletController::class);

// Route::get('/dashboard/menus/checkSlug', [AdminMenuController::class, 'checkSlug']);
// ->middleware('auth');
Route::resource('/dashboard/menus', AdminMenuController::class);

Route::resource('/dashboard/stocks', AdminStockController::class);

// Route::post('/login', [LoginController::class, 'authenticate']);
// Route::post('/logout', [LoginController::class, 'logout']);
