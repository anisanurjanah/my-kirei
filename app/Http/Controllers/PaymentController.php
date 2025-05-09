<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index($outlet_code, $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        $payment = Payment::where('order_id', $order->id)->first();

        return Inertia::render('PaymentPage', [
            'outlet_code' => $outlet_code,
            'customer' => Auth::guard('customer')->user(),
            'selectedPaymentMethod' => session('selected_payment_method', null),
            'payment' => $payment,
        ]);
    }

    public function handleCallback(Request $request, $order_number)
    {
        $payload = $request->all();

        if (isset($payload['transaction_status']) && $payload['transaction_status'] === 'settlement') {
            Payment::whereHas('order', function ($query) use ($order_number) {
                $query->where('order_number', $order_number);
            })->update([
                'payment_status' => 'Lunas',
            ]);
        }

        return response()->json(['message' => 'Callback handled'], 200);
    }
}
