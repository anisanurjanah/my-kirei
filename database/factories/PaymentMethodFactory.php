<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentMethods = config('payment_methods');
        $paymentMethod = $paymentMethods[array_rand($paymentMethods)];

        return [
            'id' => $paymentMethod['id'],
            'type' => $paymentMethod['type'],
            'icon' => $paymentMethod['icon'],
            'method' => [
                'name' => $paymentMethod['method']['name'],
                'icon' => $paymentMethod['method']['icon'],
            ],
        ];
        }
}
