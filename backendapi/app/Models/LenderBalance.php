<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LenderBalance extends Model
{
    protected $fillable = [
        'balance',
        'LenderID'

    ];
    public function Lender() {
        $this->belongsTo(Lender::class);
    }
}
