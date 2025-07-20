<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\Price;
use App\Models\Stock;
use App\Models\Outlet;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $outlet = Outlet::find(1);
        // $outlet = Outlet::find(2);
        // $outlets = Outlet::all();
        $customer = Customer::inRandomOrder()->first();
        $paymentMethod = PaymentMethod::first();
        $menus = Menu::with('pricePromo')->where('outlet_id', $outlet->id)->get();

        // $menus = config('menus');
        $methods = config('payment_methods');

        $menusWithoutStock = Menu::doesntHave('stock')->get();
        $menusWithoutPrice = Menu::doesntHave('pricePromo')->get();

        // User
        // User::create([
        //     'name' => 'Administrator',
        //     'email' => 'admin@my-kirei.com',
        //     'username' => 'administrator',
        //     'password' => Hash::make('password'),
        //     'outlet_id' => null,
        // ]);

        // foreach ($outlets as $outletId) {
        //     foreach (['kasir', 'produksi'] as $role) {
        //         \App\Models\User::factory()->create([
        //             'role' => $role,
        //             'outlet_id' => $outletId,
        //         ]);
        //     }
        // }

        // Outlet
        // Outlet::create([
        //     'name' => 'Nutiluan',
        //     'outlet_code' => 'NTLN',
        //     'phone' => '6282126607411',
        //     'address' => 'Jl. Lebak 1 No.281, Bandung',
        // ]);

        // Outlet::create([
        //     'name' => 'Dreams',
        //     'outlet_code' => 'DRMS',
        //     'phone' => '6281320000225',
        //     'address' => 'Jl. Ir. H. Juanda No.286 -288, Bandung',
        // ]);

        // Menu
        // foreach ($outlets as $outletId) {
        //     \App\Models\Menu::factory(5)->create([
        //         'outlet_id' => $outletId,
        //     ]);
        // }

        // foreach ($menusWithoutStock as $menu) {
        //     \App\Models\Stock::factory()->create([
        //         'menu_id' => $menu->id,
        //     ]);
        // }

        // foreach ($menusWithoutPrice as $menu) {
        //     \App\Models\Price::factory()->create([
        //         'menu_id' => $menu->id,
        //     ]);
        // }

        // User::factory(10)->create();
        // Customer::factory(2)->create();

        // Outlet::factory(5)->create();

        // Menu::factory(25)->create();
        // Stock::factory(25)->create();
        // Price::factory(10)->create();

        // Order::all()->each(function ($order) {
        //     Payment::factory()->create([
        //         'order_id' => $order->id,
        //     ]);
        // });

        // Payment::factory(8)->create();
        // PaymentMethod::factory(7)->create();

        // Order::factory(4)->create();
        // OrderItem::factory(8)->create();

        // foreach ($methods as $method) {
        //     DB::table('payment_methods')->updateOrInsert(
        //         ['id' => $method['id']],
        //         [
        //             'type' => $method['type'],
        //             'icon' => $method['icon'],
        //             'method' => json_encode([
        //                 'name' => $method['method']['name'],
        //                 'icon' => $method['method']['icon'],
        //                 'image' => $method['method']['image'] ?? null,
        //             ]),
        //             'instruction' => $method['instruction'] ?? null,
        //             'details' => $method['details'] ?? null,
        //             'midtrans_config' => is_array($method['midtrans_config'])
        //                 ? json_encode($method['midtrans_config'])
        //                 : $method['midtrans_config'],
        //         ]
        //     );
        // }

        // foreach ($menus as $menu) {
        //     DB::table('menus')->insert([
        //         'outlet_id' => $menu['outlet_id'],
        //         'name' => $menu['name'],
        //         'description' => $menu['description'],
        //         'cost_price' => $menu['cost_price'],
        //         'price' => $menu['price'],
        //         'image' => $menu['image'],
        //         'slug' => $menu['slug'],
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]);
        // }

        // Validasi awal
        if (!$outlet || !$customer || !$paymentMethod || $menus->isEmpty()) {
            dump('Data master belum lengkap');
            return;
        }

        if ($menus->count() < 2) {
            dump('Menu promo aktif kurang dari 2, seeder dibatalkan');
            return;
        }

        // Seeder pesanan
        for ($i = 0; $i < 1; $i++) {
            $orderDate = Carbon::create(2025, 6, rand(1, 19), rand(8, 18));
            $orderItems = [];

            $selectedMenus = $menus->random(rand(2, 4));
            $subTotal = 0;
            $discount = 0;

            foreach ($selectedMenus as $menu) {
                $quantity = rand(1, 3);
                $normalPrice = $menu->price;
                // $promoPrice = $menu->pricePromo->price_promo ?? 0;

                $promo = $menu->pricePromo;
                $now = now();

                $isPromoActive = $promo && $promo->promo_start_date <= $now && $promo->promo_end_date >= $now;
                $appliedPrice = $isPromoActive ? $normalPrice - $promo->price_promo : $normalPrice;

                // $appliedPrice = min($appliedPrice, $normalPrice);

                $orderItems[] = [
                    'menu_id' => $menu->id,
                    'quantity' => $quantity,
                    'price' => $normalPrice,
                ];

                $subTotal += $appliedPrice * $quantity;
                if ($isPromoActive) {
                    $discount = $isPromoActive ? $normalPrice - ($normalPrice - $promo->price_promo) : 0;
                }
            }

            $afterDiscount = $subTotal - $discount;
            $ppn = $afterDiscount * 0.11;
            $total = $afterDiscount + $ppn;

            // Simulasi inputan
            $validatedData = [
                'outlet_id' => $outlet->id,
                'order_date' => $orderDate,
            ];

            // Buat Order
            $order = Order::create([
                'outlet_id' => $validatedData['outlet_id'],
                'customer_id' => $customer->id,
                'order_number' => $this->generateOrderNumber($validatedData),
                'order_date' => $orderDate,
                'sub_total' => $subTotal,
                'discount' => $discount,
                'ppn' => $ppn,
                'total_price' => $total,
                'order_type' => 'Dine In',
                'order_status' => 'Dalam Proses',
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            // Order Items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
            }

            // Payment
            Payment::create([
                'order_id' => $order->id,
                'payment_method_id' => $paymentMethod->id,
                'payment_number' => $this->generatePaymentNumber($order),
                'transaction_id' => null,
                'payment_date' => $orderDate->copy()->addMinutes(rand(1, 30)),
                'amount' => $total,
                'payment_status' => 'Lunas',
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);
        }
    }

    private function generateOrderNumber(array $validatedData)
    {
        $outlet = Outlet::find($validatedData['outlet_id']);
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
