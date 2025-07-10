<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowerTransaction extends Model
{
    protected $fillable = [
        'BorrowerID', 'type', 'amount', 'description'
    ];
    public function borrower(){
        return $this->belongsTo(Borrower::class);
    }
}
