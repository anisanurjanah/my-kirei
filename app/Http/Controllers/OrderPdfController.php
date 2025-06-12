<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

Carbon::setLocale('id');

class OrderPdfController extends Controller
{
    public function preview($orderNumber)
    {
        $order = Order::with(['customer', 'outlet', 'payment.payment_method', 'orderItems.menu'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.order-summary', compact('order'))->setPaper('a4', 'portrait');
        return $pdf->stream("order-{$orderNumber}.pdf");
    }
}
