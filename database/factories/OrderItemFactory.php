<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => mt_rand(1, 10),
            'menu_id' => mt_rand(1, 25),
            'quantity' => mt_rand(1, 10),
            'price' => fake()->randomFloat(2, 10000, 50000),
        ];
    }
}
