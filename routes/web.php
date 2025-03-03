<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminOutletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard/login', [AdminLoginController::class, 'index'])->name('login')->middleware('guest');
// Route::post('/login', [LoginController::class, 'authenticate']);
// Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', function() {
    return view('dashboard.index');
});
// ->middleware('auth');

Route::resource('/dashboard/menus', AdminMenuController::class);
