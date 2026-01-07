<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transcation extends Model
{
    public function lender()
    {
        return $this->belongsTo(Lender::class, 'LenderID');
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class, 'BorrowerID');
    }
}
