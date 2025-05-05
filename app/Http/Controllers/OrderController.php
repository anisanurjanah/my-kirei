<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\Payment;
use App\Models\OrderItem;
use Midtrans\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Midtrans\Config as MidtransConfig;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $itemsFromSession = session('selectedMenus');
        $quantitiesFromSession = session('quantities');

        if (!$itemsFromSession || !$quantitiesFromSession) {
            return response()->json([
                'message' => 'Data menu atau quantity tidak ditemukan di sesi.',
            ], 422);
        }

        $validatedData = $this->validateOrder($request);
        $items = $this->prepareItemsOrder($itemsFromSession, $quantitiesFromSession);

        if (empty($items)) {
            return response()->json([
                'message' => 'Tidak ada item valid untuk diproses.'
            ], 422);
        }

        $validatedData['items'] = $items;
        $validatedData['order_type'] = 'Dine In';
        $validatedData['order_status'] = 'Ditunda';

        DB::beginTransaction();

        try {
            $order = $this->createOrder($validatedData);
            $this->createOrderItems($order, $validatedData['items']);

            $snapUrl = $this->createMidtransTransaction($order, $validatedData['items'], $validatedData['payment_method_id']);

            $this->createInitialPayment($order, $validatedData['payment_method_id']);

            DB::commit();

            session()->forget(['customer', 'selectedMenus', 'quantities', 'totalPrice']);
            
            return response()->json([
                'message' => 'Pesanan berhasil dibuat.',
                'order_number' => $order->order_number,
                'order' => $order->load('orderItems'),
                'payment_url' => $snapUrl,
            ], 201);
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

    private function prepareItemsOrder($sessionItems, $sessionQuantities)
    {
        $items = [];
        foreach ($sessionItems as $menu) {
            $menuId = $menu['id'];
            $quantity = $sessionQuantities[$menuId] ?? 0;
            $price = isset($menu['price_promo']) ? (int)$menu['price_promo']['price_promo'] : (int)$menu['price'];

            if ($quantity > 0) {
                $items[] = [
                    'menu_id' => $menuId,
                    'quantity' => $quantity,
                    'price' => $price
                ];
            }
        }

        return $items;
    }

    private function validateOrder(Request $request)
    {
        return $request->validate([
            'outlet_code' => 'required|string',
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'sub_total' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0',
            'total_price' => 'required|integer|min:0',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);
    }

    private function generateOrderNumber(array $validatedData)
    {
        $outlet = Outlet::where('outlet_code', $validatedData['outlet_code'])->first();
        $formattedDate = Carbon::parse($validatedData['order_date'])->format('Ymd');
        $randomNumber = mt_rand(100000, 999999);

        return $formattedDate . Str::slug($outlet->outlet_code) . $randomNumber;
    }

    private function createOrder(array $validatedData)
    {
        $outlet = Outlet::where('outlet_code', $validatedData['outlet_code'])->first();
        $subTotal = collect($validatedData['items'])->sum(fn($item) => $item['quantity'] * $item['price']);

        return Order::create([
            'outlet_id' => $outlet->id,
            'customer_id' => $validatedData['customer_id'],
            'order_number' => $this->generateOrderNumber($validatedData),
            'order_date' => now(),
            'sub_total' => $subTotal,
            'discount' => $validatedData['discount'] ?? 0,
            'total_price' => $validatedData['total_price'],
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

    private function createMidtransTransaction(Order $order, array $items, int $paymentMethodId)
    {
        MidtransConfig::$serverKey = config('services.midtrans.server_key');
        MidtransConfig::$isProduction = config('services.midtrans.is_production');
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;

        $method = PaymentMethod::findOrFail($paymentMethodId);
        $methodConfig = json_decode($method->method, true);

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
        ];

        $payload = array_merge($payload, $methodConfig);

        return Snap::createTransaction($payload)->redirect_url;
    }

    private function createInitialPayment(Order $order, int $paymentMethodId)
    {
        Payment::create([
            'order_id' => $order->id,
            'payment_method_id' => $paymentMethodId,
            'payment_number' => 'PAY-' . strtoupper(Str::random(10)),
            'payment_date' => now(),
            'amount' => $order->total_price,
            'va_number' => null,
            'bank' => null,
            'pdf_url' => null,
            'payment_status' => 'Ditunda',
        ]);
    }
}
