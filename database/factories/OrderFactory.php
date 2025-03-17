<?php

namespace Database\Factories;

use App\Models\Outlet;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $outlet = Outlet::inRandomOrder()->first();
        $customer = Customer::inRandomOrder()->first();
        $orderDate = Carbon::now()->format('Y-m-d');

        return [
            'outlet_id' => mt_rand(1, 5),
            'customer_id' => mt_rand(1, 10),
            'user_id' => mt_rand(2, 11),
            'order_date' => $orderDate,
            'total_price' => fake()->randomFloat(2, 10000, 1000000),
            'order_status' => fake()->randomElement(['Selesai', 'Dibatalkan']),
            'payment_status' => fake()->randomElement(['Lunas', 'Belum Lunas']),
            'slug' => Str::slug($outlet->name . '-' . $orderDate . '-' . $customer->name),
        ];
    }
}
