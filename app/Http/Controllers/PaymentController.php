<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index($outlet_code, $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        $payment = Payment::where('order_id', $order->id)->first();

        $payment->refresh();
        $payment->load('order');

        return Inertia::render('PaymentPage', [
            'outlet_code' => $outlet_code,
            'selectedPaymentMethod' => session('selected_payment_method', null),
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
        $payload = $request->all();

        // Verifikasi bahwa payload memang berasal dari Midtrans
        // (misalnya dengan mengecek signature key atau token)
        if ($this->verifyMidtransSignature($payload)) {
            // Cek status pembayaran
            $paymentStatus = $payload['transaction_status']; // Bisa 'capture', 'settlement', dll.
            $orderNumber = $payload['order_id']; // ID Pesanan yang dikirimkan dalam webhook

            // Cari pesanan yang terkait
            $order = Order::where('order_number', $orderNumber)->first();

            if ($order) {
                // Update status pembayaran berdasarkan status dari Midtrans
                $payment = $order->payment;
                if ($payment) {
                    if ($paymentStatus === 'settlement') {
                        // Pembayaran berhasil
                        $payment->update([
                            'payment_status' => 'Lunas',
                        ]);
                        $order->update([
                            'order_status' => 'Lunas',
                        ]);
                    } elseif ($paymentStatus === 'expire' || $paymentStatus === 'cancel') {
                        // Pembayaran gagal atau expired
                        $payment->update([
                            'payment_status' => 'Gagal',
                        ]);
                        $order->update([
                            'order_status' => 'Dibatalkan',
                        ]);
                    } else {
                        // Status lainnya, misalnya pending
                        $payment->update([
                            'payment_status' => 'Ditunda',
                        ]);
                        $order->update([
                            'order_status' => 'Ditunda',
                        ]);
                    }
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function verifyMidtransSignature($payload)
    {
        // Ambil data yang diperlukan dari payload
        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];
        $signatureKey = $payload['signature_key'];

        $serverKey = config('services.midtrans.server_key');
        $hashString = $orderId . "|" . $statusCode . "|" . $grossAmount . "|" . $serverKey;
        $generatedSignature = hash('sha512', $hashString);

        // Verifikasi signature
        return $generatedSignature === $signatureKey;
    }
}
