<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentMethod = PaymentMethod::inRandomOrder()->first();

        return [
            'order_id' => null,
            'payment_method_id' => $paymentMethod->id,
            'payment_number' => 'PAY' . now()->format('YmdHis') . mt_rand(1000, 9999),
            'payment_date' => now(),
            'amount' => $this->faker->randomFloat(2, 10000, 500000),
            'va_number' => $this->faker->randomNumber(9, true),
            'bank' => $paymentMethod->type === 'Bank Transfer' ? $this->faker->company() : null,
            'pdf_url' => $this->faker->url(),
            'payment_status' => $this->faker->randomElement(['Lunas', 'Belum Lunas', 'Kadaluarsa', 'Gagal', 'Ditunda']),
        ];
    }
}
