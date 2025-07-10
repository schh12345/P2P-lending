<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    use HasApiTokens , Notifiable;


    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'phone_number',
        'bio',
        'profile_picture_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

/*class Admin extends Model
{
    public function lender()
        {
        return $this->hasMany(Lender::class);
    }
    public function borrower()
        {
        return $this->hasMany(Borrower::class);
    }
    public function loanRequest()
        {
        return $this->hasMany(loanRequest::class);
    }
}
*/



