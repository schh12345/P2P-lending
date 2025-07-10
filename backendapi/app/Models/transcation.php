<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transcation extends Model
{
    public function borrower()
        {
        return $this->hasMany(Borrower::class);
    }
    public function lender()
        {
        return $this->hasMany(Lender::class);
    }
}
