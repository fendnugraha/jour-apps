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
            'waktu' => date('Y-m-d H:i:s'),
            'invoice' => 'JR.' . \date('YmdHis') . '.' . \mt_rand(0, 100),
            'description' => fake()->sentence(\mt_rand(6, 10)),
            'debt_code' => \mt_rand(1, 30),
            'cred_code' => \mt_rand(1, 30),
            'jumlah' => \round(\mt_rand(100000, 10000000), 2),
            'status' => 1,
            'user_id' => \mt_rand(1, 2),
            'warehouse_id' => 1
        ];
    }
}
