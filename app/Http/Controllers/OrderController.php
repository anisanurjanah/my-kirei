<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use Inertia\Inertia;
use Midtrans\Config;
use App\Models\Order;
use Midtrans\CoreApi;
use App\Models\Outlet;
use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($order_number)
    {
        // $order = Order::where('order_number', $order_number)->first();
        // $payment = Payment::where('order_id', $order->id)->first();

        // if (!$order) {
        //     abort(404);
        // }

        // return Inertia::render('OrderDetailPage', [
        //     'order' => $order,
        //     'payment' => $payment,
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateOrder($request);
        $items = $validatedData['items'];

        if (empty($items)) {
            return response()->json([
                'message' => 'Tidak ada item valid untuk diproses.'
            ], 422);
        }

        $validatedData['order_type'] = 'Dine In';
        $validatedData['order_status'] = 'Ditunda';

        DB::beginTransaction();

        try {
            $order = $this->createOrder($validatedData);
            $this->createOrderItems($order, $validatedData['items']);

            $response = $this->createMidtransTransaction($order, $validatedData['items'], $validatedData['payment_method_id']);
            $this->createInitialPayment($order, $validatedData['payment_method_id'], $response);

            // Direct ShopeePay
            // if (!empty($response->actions)) {
            //     foreach ($response->actions as $action) {
            //         if ($action->name === 'deeplink-redirect') {
            //             return redirect()->away($action->url);
            //         }
            //     }
            // }

            DB::commit();

            session()->forget(['selectedMenus', 'quantities']);
            return redirect()->to('/' . Str::slug($order->outlet->outlet_code) . '/payment-page/' . Str::slug($order->order_number));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal membuat pesanan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function validateOrder(Request $request)
    {
        return $request->validate([
            'outlet_code' => 'required|string',
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
            'sub_total' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0',
            'total_price' => 'required|integer|min:0',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);
    }

    private function createOrder(array $validatedData)
    {
        $outlet = Outlet::where('outlet_code', $validatedData['outlet_code'])->first();

        $subTotal = collect($validatedData['items'])->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return Order::create([
            'outlet_id' => $outlet->id,
            'customer_id' => $validatedData['customer_id'],
            'order_number' => $this->generateOrderNumber($validatedData),
            'order_date' => now(),
            'sub_total' => $subTotal,
            'discount' => $validatedData['discount'] ?? 0,
            'total_price' => $subTotal - ($validatedData['discount'] ?? 0),
            'order_type' => 'Dine In',
            'order_status' => 'Ditunda',
        ]);
    }

    private function createOrderItems(Order $order, array $items)
    {
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    }

    private function createInitialPayment(Order $order, int $paymentMethodId, $response)
    {
        $transaction_id = $response->transaction_id ?? null;
        $va_number = $response->va_numbers[0]->va_number ?? null;
        $bank = $response->va_numbers[0]->bank ?? null;
        $pdf_url = $response->pdf_url ?? null;
        $qr_code_url = null;
        $expiry_time = $response->expiry_time ? Carbon::parse($response->expiry_time) : null;

        if (isset($response->actions)) {
            foreach ($response->actions as $action) {
                if ($action->name === 'generate-qr-code') {
                    $qr_code_url = $action->url ?? null;
                    break;
                }
            }
        }

        Payment::create([
            'order_id' => $order->id,
            'payment_method_id' => $paymentMethodId,
            'payment_number' => $this->generatePaymentNumber($order),
            'payment_date' => now(),
            'transaction_id' => $transaction_id,
            'amount' => $order->total_price,
            'va_number' => $va_number,
            'bank' => $bank,
            'pdf_url' => $pdf_url,
            'qr_code_url' => $qr_code_url,
            'payment_status' => 'Ditunda',
            'expiry_time' => $expiry_time,
        ]);
    }

    private function createMidtransTransaction(Order $order, array $items, int $paymentMethodId)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $method = collect(config('payment_methods'))->firstWhere('id', $paymentMethodId);
        $methodConfig = is_string($method['midtrans_config'])
            ? json_decode($method['midtrans_config'], true)
            : $method['midtrans_config'];

        if (!isset($methodConfig['payment_type'])) {
            return redirect()->back()->withErrors(['Metode pembayaran tidak valid.']);
        }

        $totalItemPrice = array_reduce($items, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        $discount = $order->total_price - $totalItemPrice;

        $payload = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->customer->name,
                'phone' => $order->customer->phone,
            ],
            'item_details' => array_map(function ($item) {
                return [
                    'id' => $item['menu_id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'name' => 'Menu ' . $item['menu_id'],
                ];
            }, $items),
            'custom_expiry' => [
                'order_time' => now()->format('Y-m-d H:i:s O'),
                'expiry_duration' => 15,
                'unit' => 'minute'
            ]
        ];

        $payload['item_details'][] = [
            'id' => 'DISCOUNT-' . uniqid(),
            'price' => $discount,
            'quantity' => 1,
            'name' => 'Discount',
        ];

        if ($methodConfig['payment_type'] === 'shopeepay') {
            $payload['payment_type'] = 'shopeepay';
            $payload['shopeepay'] = [
                'callback_url' => url("/midtrans/callback/" . $order->order_number),
            ];
        }

        $payload = array_merge($payload, $methodConfig);
        $response = CoreApi::charge($payload);
        // dd($response);

        $updateData = [
            'transaction_id' => $response->transaction_id ?? null,
            'pdf_url' => $response->pdf_url ?? null,
            'expiry_time' => $response->expiry_time ?? null,
        ];

        // Virtual Account (Bank Transfer)
        if (!empty($response->va_numbers[0])) {
            $updateData['va_number'] = $response->va_numbers[0]->va_number ?? null;
            $updateData['bank'] = $response->va_numbers[0]->bank ?? null;
        }

        // Permata Virtual Account (Bank Transfer)
        if (!empty($response->permata_va_number)) {
            $updateData['va_number'] = $response->permata_va_number ?? null;
        }

        // GoPay dan QRIS
        if (!empty($response->actions)) {
            foreach ($response->actions as $action) {
                if ($action->name === 'generate-qr-code') {
                    $updateData['qr_code_url'] = $action->url ?? null;
                }
            }
        }

        Payment::where('order_id', $order->id)->update($updateData);
        return $response;
    }

    private function generateOrderNumber(array $validatedData)
    {
        $outlet = Outlet::where('outlet_code', $validatedData['outlet_code'])->first();
        $formattedDate = Carbon::parse($validatedData['order_date'])->format('Ymd');
        $randomNumber = mt_rand(100000, 999999);

        return $formattedDate . $outlet->outlet_code . $randomNumber;
    }

    private function generatePaymentNumber(Order $order)
    {
        $outlet = $order->outlet;
        $timestamp = now()->format('YmdHis');
        $randomNumber = mt_rand(1000, 9999);

        return 'PY' . $outlet->outlet_code . $timestamp . $randomNumber;
    }
}
