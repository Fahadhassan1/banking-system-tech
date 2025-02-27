<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'dob' => $this->faker->date(),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'account_number' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP']),
            'user_id' => \App\Models\User::factory(), 

        ];
    }
}
