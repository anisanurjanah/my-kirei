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

        $subTotal = fake()->randomFloat(2, 10000, 1000000);
        $discount = fake()->randomFloat(2, 100, min(10000, $subTotal));
        $totalPrice = $subTotal - $discount;

        return [
            'outlet_id' => $outlet->id,
            'customer_id' => mt_rand(1, 10),
            'order_number' => now()->format('Ymd') . $outlet->outlet_code . mt_rand(100000, 999999),
            'order_date' => now()->toDateTimeString(),
            'sub_total' => $subTotal,
            'discount' => $discount,
            'total_price' => $totalPrice,
            'order_type' => fake()->randomElement(['Dine In', 'Take Away']),
            'order_status' => fake()->randomElement(['Ditunda', 'Dibatalkan', 'Selesai', 'Dalam Proses']),
        ];
    }
}
