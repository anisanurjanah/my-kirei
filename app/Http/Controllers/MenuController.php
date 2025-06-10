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

        $queryMenus = Menu::with(['stock', 'pricePromo' => function ($query) {
            $query->where('promo_end_date', '>=', now());
        }])->where('outlet_id', $outlet->id);

        $recommendedMenus = (clone $queryMenus)
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(3)
            ->get();

        $promoMenus = (clone $queryMenus)
            ->whereHas('pricePromo', function ($query) {
                $query->where('promo_end_date', '>=', now());
            })
            ->get();

        $newMenus = (clone $queryMenus)
            ->where('created_at', '>=', now()->subMonth())
            ->take(2)
            ->get();

        $menus = $queryMenus->get();

        return Inertia::render('MenuPage', [
            'menus' => $menus,
            'recommendedMenus' => $recommendedMenus,
            'promoMenus' => $promoMenus,
            'newMenus' => $newMenus,
            'outlet_code' => $outlet_code,
            'customer' => Auth::guard('customer')->user(),
        ]);
    }
}
