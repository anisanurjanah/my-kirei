<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index($outlet_code)
    {
        $payment_method = PaymentMethod::all();

        return Inertia::render('PaymentMethodPage', [
            'outlet_code' => $outlet_code,
            'payment_method' => $payment_method,
            'selectedPaymentMethod' => session('selected_payment_method', null),
        ]);
    }

    public function store(Request $request)
    {
        $paymentMethodId = $request->input('payment_method_id');
        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);

        session()->put("selected_payment_method", $paymentMethod->toArray());
        return back();
    }

    public function getPaymentMethods()
    {
        $methods = config('payment_methods');

        return response()->json($methods);
    }
}
