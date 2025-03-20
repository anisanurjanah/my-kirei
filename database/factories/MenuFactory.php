<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'slug' => fake()->slug(mt_rand(3, 6)),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(1, 10000, 50000),
            'image' => asset('img/dimsum-placeholder.jpg'),
            'outlet_id' => mt_rand(1, 5)
        ];
    }
}
