<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RequestLoanSeeder extends Seeder
{
    public function run()
    {
        // Example: assuming you already have borrower IDs in the 'borrowers' table
        $borrowerIds = DB::table('borrowers')->pluck('id');

        if ($borrowerIds->isEmpty()) {
            // Optional: add fallback or error if no borrowers exist
            return;
        }

        foreach (range(1, 30) as $index) {
            DB::table('loanRequest')->insert([
                'borrower_id' => $borrowerIds->random(),
                'request_duration' => rand(6, 24) . ' months',
                'request_amount' => rand(500, 5000),
                'request_reason' => 'Loan for ' . Str::random(10),
                'status' => 'Pending',
                'approved_amount' => null,
                'approved_at' => null,
                'rejected_at' => null,
                'created_at' => Carbon::now()->subDays(rand(1, 60)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
