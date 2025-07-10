<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Admin
        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'first_name' => 'admin',
            'last_name' => 'user',
            'password' => bcrypt('password'),
            'role' => 'Admin',
            'status' => 'Approved',
            'otp' => '6E32PK',
        ]);

        // Seed Borrower
        User::firstOrCreate(
            ['email' => 'borrower@example.com'],
            [
                'first_name' => 'borrower',
                'last_name' => 'user',
                'password' => Hash::make('password'),
                'role' => 'Borrower',
                'status' => 'Pending',
                'otp' => Str::random(6)
            ]
        );

        // Seed Lender
        User::firstOrCreate(
            ['email' => 'lender@example.com'],
            [
                'first_name' => 'lender',
                'last_name' => 'user',
                'password' => Hash::make('password'),
                'role' => 'Lender',
                'status' => 'Approved',
                'otp' => Str::random(6)
            ]
        );
    }
}
