<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowerBalance extends Model
{
    protected $fillable = [
        'balance',
        'BorrowerID',

    ];
    public function Borrower() {
        $this->belongsTo(Borrower::class);
    }
}
