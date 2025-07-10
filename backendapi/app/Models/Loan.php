<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_duration',
        'request_reason',
        'request_amount',
        'interest_rate',
        'BorrowerID',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function lender()
    {
        return $this->belongsTo(Lender::class);
    }
}


