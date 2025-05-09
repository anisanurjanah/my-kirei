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
        $startDate = fake()->dateTimeBetween('-1 month', '+1 week');
        $endDate = (clone $startDate)->modify('+7 days');

        return [
            'price_promo' => fake()->randomFloat(2, 100, 1900),
            'promo_start_date' => Carbon::instance($startDate)->format('Y-m-d'),
            'promo_end_date' => Carbon::instance($endDate)->format('Y-m-d'),
        ];
    }
}
