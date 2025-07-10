<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BorrowerFactory extends Factory
{
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'password' => bcrypt('password'),
            'status' => 'pending',
            'amount' => $this->faker->numberBetween(1000, 10000),
            'credit_score' => $this->faker->numberBetween(500, 800),
            'otp' => rand(1000, 9999),
        ];
    }
}
