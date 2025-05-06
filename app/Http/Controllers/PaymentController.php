<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Outlet;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index($outlet_code)
    {
        return Inertia::render('PaymentPage', [
            'outlet_code' => $outlet_code,
            'customer' => Auth::guard('customer')->user(),
            'selectedPaymentMethod' => session('selected_payment_method', null),
        ]);
    }
}
