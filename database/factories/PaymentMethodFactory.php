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
        $randomMethod = $paymentMethods[array_rand($paymentMethods)];
        dd(config('payment_methods'));

        return [
            'type' => $randomMethod['type'],
            'icon' => $randomMethod['icon'],
            'method' => [
                'name' => $randomMethod['method']['name'],
                'icon' => $randomMethod['method']['icon'],
                'image' => $randomMethod['method']['image'],
            ],
            'instruction' => $randomMethod['instruction'],
            'details' => $randomMethod['details'],
            'midtrans_config' => $randomMethod['midtrans_config'],
        ];
    }
}
