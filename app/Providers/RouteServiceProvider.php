<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        Route::bind('menu', function ($value) {
            return Menu::where('slug', $value)->firstOrFail();
        });
    }
}
