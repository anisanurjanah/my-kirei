<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outlet>
 */
class OutletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->word();

        return [
            'name' => $name,
            'outlet_code' => strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 4)),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
        ];
    }
}
