<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Inertia\Inertia;
use App\Models\Outlet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index($outlet_code)
    {
        $outlet = Outlet::where('outlet_code', $outlet_code)->first();

        return Inertia::render('MenuPage', [
            // 'menus' => Menu::with(['stock', 'pricePromo'])
            // ->where('outlet_id', $outlet->id)
            // ->get(),
            'menus' => Menu::latest()->with(['stock', 'pricePromo' => function ($query) {
                $query->where('promo_end_date', '>=', now());
            }])->where('outlet_id', $outlet->id)->get(),
            'outlet_code' => $outlet_code,
            'customer' => Auth::guard('customer')->user(),
        ]);
    }
}
