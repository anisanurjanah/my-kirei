<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\Price;
use App\Models\Stock;
use App\Models\Outlet;
use App\Models\Customer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Administrator',
        //     'email' => 'admin@my-kirei.com',
        //     'username' => 'administrator',
        //     'password' => Hash::make('password'),
        //     'outlet_id' => 0,
        // ]);

        // User::factory(10)->create();
        // Customer::factory(10)->create();

        // Outlet::factory(5)->create();

        // Menu::factory(25)->create();
        // Stock::factory(25)->create();
        // Price::factory(10)->create();

        // Order::factory(10)->create();
        // OrderItem::factory(30)->create();
    }
}
