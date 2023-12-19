<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'helios_id',
        'payment_status',
        'payment_date',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class,'user_id','user_id');
    }

}
