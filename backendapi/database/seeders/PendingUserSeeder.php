<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Borrower;
use App\Models\Lender;

class PendingUserSeeder extends Seeder
{
    public function run()
    {
        Borrower::factory()->count(5)->create([
            'status' => 'pending',
        ]);

        Lender::factory()->count(5)->create([
            'status' => 'pending',
        ]);
    }
}
