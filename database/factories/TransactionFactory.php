<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sender_account_id' => Account::factory(), 
            'receiver_account_id' => Account::factory(),
            'transaction_type' => 'transfer',  
            'amount' => $this->faker->randomFloat(2, 1, 1000),  
            'currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP']),
            'exchange_rate' => $this->faker->randomFloat(4, 0.5, 1.5), 
            'final_amount' => $this->faker->randomFloat(2, 1, 1000), 
            'description' => $this->faker->sentence(),
        ];
    }
}
