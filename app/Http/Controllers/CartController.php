<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Outlet;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index($outlet_code)
    {
        $outlet = Outlet::where('outlet_code', $outlet_code)->first();

        return Inertia::render('CartPage', [
            'menus' => Menu::with(['stock', 'pricePromo'])
                ->where('outlet_id', $outlet->id)
                ->get(),
            'outlet_code' => $outlet_code,
            'customer' => Auth::guard('customer')->user(),
            'selectedPaymentMethod' => session('selected_payment_method', null),
        ]);
    }
}
