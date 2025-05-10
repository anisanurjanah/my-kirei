<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function handleNotification(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');

        // $signatureKey = hash("sha512",
        //     $request->order_id .
        //     $request->status_code .
        //     $request->gross_amount .
        //     $serverKey
        // );

        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        $mySignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($mySignature !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $order = Order::where('order_number', $request->order_id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $payment = $order->payment;
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        switch ($request->input('transaction_status')) {
            case 'settlement':
            case 'capture':
                $payment->payment_status = 'Lunas';
                $order->order_status = 'Selesai';
                break;
            case 'cancel':
            case 'expire':
                $payment->payment_status = 'Gagal';
                $order->order_status = 'Dibatalkan';
                break;
            case 'pending':
                $payment->payment_status = 'Ditunda';
                $order->order_status = 'Ditunda';
                break;
            default:
                return response()->json(['message' => 'Unhandled transaction status'], 400);
        }

        $payment->save();
        $order->save();

        return response()->json(['message' => 'Webhook processed successfully']);

        // $payload = json_decode($request->getContent(), true);

        // if (!$payload) {
        //     return response()->json(['error' => 'Invalid JSON'], 400);
        // }

        // $transaction = $payload['transaction_status'] ?? null;
        // $orderId = $payload['order_id'] ?? null;

        // $payment = Payment::where('order_id', $orderId)->first();

        // if (!$payment) {
        //     return response()->json(['error' => 'Payment not found'], 404);
        // }

        // if (in_array($transaction, ['settlement', 'capture'])) {
        //     $payment->payment_status = 'Lunas';
        //     $payment->save();
        // }

        // return response()->json(['message' => 'Notification handled']);
    }

    // public function handleNotification(Request $request)
    // {
    //     $notif = $request->all();
    //     $transaction = $notif['transaction_status'];
    //     $orderId = $notif['order_id'];

    //     $payment = Payment::where('order_id', $orderId)->first();

    //     if (!$payment) {
    //         abort(404);
    //     }

    //     if ($transaction === 'settlement' || $transaction === 'capture') {
    //         $payment->payment_status = 'Lunas';
    //         $payment->save();
    //     }

    //     return response()->json(['message' => 'Notification handled']);
    // }
}
