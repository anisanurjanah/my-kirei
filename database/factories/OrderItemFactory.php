<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Order;
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
        $order = Order::inRandomOrder()->first();

        $menu = Menu::where('outlet_id', $order->outlet_id)
                    ->inRandomOrder()
                    ->first();

        return [
            'order_id' => $order->id,
            'menu_id' => $menu->id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $menu->price,
        ];
    }
}
