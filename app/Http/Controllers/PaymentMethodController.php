<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function getPaymentMethods()
    {
        $methods = config('payment_methods');

        return response()->json($methods);
    }
}
