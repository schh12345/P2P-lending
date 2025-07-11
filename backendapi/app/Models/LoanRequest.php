<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loanRequest extends Model
{
    use HasFactory;

    protected $table = 'loan_requests';
    protected $primaryKey = 'request_id';

    protected $fillable = [
        'borrower_id',
        'request_duration',
        'request_amount',
        'request_reason',
        'status',
        'approved_amount',
        'approved_by',
        'approval_notes',
        'approved_at',
        'rejected_by',
        'rejection_reason',
        'rejected_at'
    ];

    protected $casts = [
        'request_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class, 'BorrowerID', 'id');
    }

    // Relationship with approver (from users table)
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Relationship with rejector (from users table)
    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeMinAmount($query, $amount)
    {
        return $query->where('request_amount', '>=', $amount);
    }
}
