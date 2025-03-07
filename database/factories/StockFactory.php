<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Stock;
use App\Models\Outlet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'menu_id' => Menu::whereDoesntHave('stock')->inRandomOrder()->first()->id,
            'current_stock' => fake()->numberBetween(0, 1000),
        ];
    }
}
