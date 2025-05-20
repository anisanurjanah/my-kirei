<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Events\NewOrderEvent;
use Illuminate\Support\Facades\Log;

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

    // public function handleCallback(Request $request, $order_number)
    // {
    //     $payload = $request->all();

    //     if (isset($payload['transaction_status']) && $payload['transaction_status'] === 'settlement') {
    //         Payment::whereHas('order', function ($query) use ($order_number) {
    //             $query->where('order_number', $order_number);
    //         })->update([
    //             'payment_status' => 'Lunas',
    //         ]);
    //     }

    //     return response()->json(['message' => 'Callback handled'], 200);
    // }

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

        $order = Order::where('order_number', $request['order_id'])->first();
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

                Log::info('Broadcasting NewOrderEvent for order', ['order_number' => $order->order_number]);
                $this->broadcastNewOrder($order);
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
