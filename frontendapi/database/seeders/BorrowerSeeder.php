<?php

namespace Database\Seeders;

use App\Models\Borrower;
use Illuminate\Database\Seeder;

class BorrowerSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 10) as $i) {
            Borrower::create([
                'first_name' => fake()->firstName,
                'last_name' => fake()->lastName,
                'email' => fake()->unique()->safeEmail,
                'status' => fake()->randomElement(['Active', 'Pending', 'Suspended', 'Inactive']),
                'phone_number' => fake()->phoneNumber,
                'amount' => fake()->randomFloat(2, 1000, 30000),
                'balance' => fake()->randomFloat(2, 0, 5000),
                'amount_to_pay' => fake()->randomFloat(2, 1000, 30000),
                'credit_score' => fake()->numberBetween(300, 850),
            ]);
        }
    }
}
