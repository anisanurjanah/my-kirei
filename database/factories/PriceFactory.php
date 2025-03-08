<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>
 */
class PriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 week');
        $endDate = (clone $startDate)->modify('+7 days');

        return [
            'menu_id' => Menu::whereDoesntHave('pricePromo')->inRandomOrder()->first()->id,
            'price_promo' => $this->faker->randomFloat(2, 100, 1900),
            'promo_start_date' => Carbon::instance($startDate)->format('Y-m-d'),
            'promo_end_date' => Carbon::instance($endDate)->format('Y-m-d'),
        ];
    }
}
