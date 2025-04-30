<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\Price;
use App\Models\Stock;
use App\Models\Outlet;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $outlets = [1, 2];
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
        // Customer::factory(10)->create();

        // Outlet::factory(5)->create();

        // Menu::factory(25)->create();
        // Stock::factory(25)->create();
        // Price::factory(10)->create();

        Order::all()->each(function ($order) {
            Payment::factory()->create([
                'order_id' => $order->id,
            ]);
        });

        // Payment::factory(8)->create();
        // PaymentMethod::factory(7)->create();

        // Order::factory(8)->create();
        // OrderItem::factory(16)->create();
    }
}
