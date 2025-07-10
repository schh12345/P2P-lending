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
                'status' => fake()->randomElement(['Active', 'Inactive', 'Suspended' , 'Pending']),
                'email' => fake()->unique()->safeEmail,
                'phone_number' => fake()->phoneNumber,
                'balance' => fake()->randomFloat(2, 10000, 100000),
            ]);
        }
    }
}
