<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderPdfController extends Controller
{
    public function preview($orderNumber)
    {
        $order = Order::with(['customer', 'outlet', 'payment.payment_method.method', 'orderItems.menu'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('pdf.order-summary', compact('order'));
    }
}
