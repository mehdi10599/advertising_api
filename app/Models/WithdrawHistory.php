<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawHistory extends Model
{
    use HasFactory;
    protected $table = 'user_withdraw_history';
    protected $fillable = [
        'user_id',
        'helios_id',
        'golds',
        'gems',
        'ads',
        'payment_status',
        'payment_date',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class,'user_id','user_id');
    }

}
