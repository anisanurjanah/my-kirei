<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index($outlet_code)
    {
        $outlet = Outlet::where('outlet_code', $outlet_code)->first();

        return Inertia::render('PaymentPage', [

            'outlet_code' => $outlet_code,
            'customer' => Auth::guard('customer')->user(),
        ]);
    }
}
