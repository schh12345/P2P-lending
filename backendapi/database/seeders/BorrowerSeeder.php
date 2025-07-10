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
            'status' => 'Inactive',
            'approval_status' => 'Pending',
            'phone_number' => fake()->phoneNumber,
            'password' => bcrypt('password'), // hash your passwords
            'income' => fake()->randomFloat(2, 1000, 30000),
            'credit_score' => fake()->numberBetween(0, 100),
            'identity_path' => 'documents/identity_' . $i . '.pdf',
            'employment_path' => 'documents/employment_' . $i . '.pdf',
            'employment_status' => fake()->randomElement(['full-time', 'part-time']),
        ]);
        }
    }
}
