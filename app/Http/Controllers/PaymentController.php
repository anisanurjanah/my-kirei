<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Helpers\WhatsappHelper;
use App\Models\Order;
use App\Models\Payment;
use App\Events\NewOrderEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index($outlet_code, $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        $payment = Payment::where('order_id', $order->id)->first();

        if (!$order) {
            abort(404);
        }

        $payment->refresh();
        $payment->load(['order', 'payment_method']);

        return Inertia::render('PaymentPage', [
            'outlet_code' => $outlet_code,
            'selectedPaymentMethod' => $payment->payment_method,
            'payment' => $payment,
        ]);
    }

    public function handleWebhook(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');

        $signatureKey = hash("sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $order = Order::with(['outlet', 'customer', 'payment'])->where('order_number', $request['order_id'])->first();
        if (!$order) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Update status
        $this->updateOrderAndPaymentStatus($order, $request->transaction_status);

        return response()->json(['status' => 'success']);
    }

    protected function updateOrderAndPaymentStatus($order, $transactionStatus)
    {
        switch ($transactionStatus) {
            case 'settlement':
            case 'capture':
                $order->update(['order_status' => 'Dalam Proses']);
                $order->payment->update(['payment_status' => 'Lunas']);

                $this->broadcastNewOrder($order);
                WhatsappHelper::sendOrderPdfToWhatsapp($order);
                break;

            case 'cancel':
            case 'expire':
                $order->update(['order_status' => 'Dibatalkan']);
                $order->payment->update(['payment_status' => 'Gagal']);
                break;

            case 'pending':
                $order->update(['order_status' => 'Ditunda']);
                $order->payment->update(['payment_status' => 'Ditunda']);
                break;
        }
    }

    protected function broadcastNewOrder($order)
    {
        event(new NewOrderEvent($order, null, 'administrator'));
        event(new NewOrderEvent($order, 'kasir', null, $order->outlet->outlet_code));
        event(new NewOrderEvent($order, 'produksi', null, $order->outlet->outlet_code));
    }
}
