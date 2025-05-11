<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;

class OrderDetailController extends Controller
{
    public function index($outlet_code, $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();

        if (!$order) {
            abort(404);
        }

        return Inertia::render('OrderDetailPage', [
            'outlet_code' => $outlet_code,
            'selectedPaymentMethod' => session('selected_payment_method', null),
            'order' => $order,
            'payment' => $order->payment,
        ]);
    }
}
