<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountTrace>
 */
class AccountTraceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_issued' => date('Y-m-d H:i'),
            'invoice' => 'JR.BK.' . \date('dmY') . '.' . \sprintf('%07d', \mt_rand(1, 9999)),
            'description' => fake()->sentence(\mt_rand(6, 10)),
            'debt_code' => $this->faker->randomElement(['60101-001', '60101-004', '60101-003']),
            'cred_code' => $this->faker->randomElement(['10100-001', '10100-002', '10200-001']),
            'amount' => \round(\mt_rand(1, 99), 2) * 1000,
            'status' => 1,
            'user_id' => \mt_rand(1, 2),
            'warehouse_id' => 1
        ];
    }
}
