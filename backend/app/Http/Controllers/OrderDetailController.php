<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index($order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        $payment = Payment::where('order_id', $order->id)->first();

        if (!$order) {
            abort(404);
        }

        return Inertia::render('OrderDetailPage', [
            'order' => $order,
            'payment' => $payment,
        ]);
    }
}
