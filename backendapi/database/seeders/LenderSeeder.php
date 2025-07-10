<?php

namespace Database\Seeders;

use App\Models\Lender;
use Illuminate\Database\Seeder;

class LenderSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 10) as $i) {
            Lender::create([
                'first_name' => fake()->firstName,
                'last_name' => fake()->lastName,
                //'status' => fake()->randomElement(['Suspended', 'Active', 'Inactive']),
                'approval_status' => 'Pending',
                'email' => fake()->unique()->safeEmail,
                'password' => fake()->password,
                'phone_number' => fake()->phoneNumber,
                'amount' => fake()->randomFloat(2, 1000, 30000),
                'credit_score' => fake()->randomFloat(2, 1000, 30000),

            ]);
        }
    }
}
