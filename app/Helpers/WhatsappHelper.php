<?php

namespace App\Helpers;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

Carbon::setLocale('id');

class WhatsappHelper
{
    public static function sendOrderPdfToWhatsapp($order)
    {
        try {
            $pdf = Pdf::loadView('pdf.order-summary', ['order' => $order]);
            $pdfPath = 'orders/order-' . $order->order_number . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdf->output());

            $token = config('services.wablas.token');
            $phone = self::normalizePhone($order->customer->phone);
            $documentPath = storage_path('app/public/' . $pdfPath);

            $base64File = base64_encode(File::get($documentPath));
            $fileName = 'order-' . $order->order_number . '.pdf';

            $payload = [
                'data' => [
                    [
                        'phone' => $phone,
                        'caption' => 'Berikut ringkasan pesanan Anda. Terima kasih!',
                        'document' => [
                            'filename' => $fileName,
                            'base64' => $base64File,
                        ],
                    ],
                ],
            ];

            Log::info('Wablas Phone:', ['phone' => $phone]);
            Log::info('Wablas Token:', ['token' => substr($token, 0, 10) . '...']); // jangan full token di log
            Log::info('Wablas Payload:', $payload);

            $response = Http::withToken($token)
                ->post('https://texas.wablas.com/api/v2/send-document', $payload);

            Log::info('Wablas Response:', ['status' => $response->status(), 'body' => $response->body()]);

            if (!$response->successful()) {
                Log::error('Gagal kirim WA PDF', ['response' => $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('Exception kirim WA PDF', ['message' => $e->getMessage()]);
        }
    }

    private static function normalizePhone($phone)
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }
}
