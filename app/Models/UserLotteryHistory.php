<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLotteryHistory extends Model
{
    use HasFactory;
    public $table = 'user_lottery_history';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'lottery_id',
        'join_times',
        'result',
        'helios_id',
        'payment_status',
        'payment_date',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class,'user_id','user_id');
    }


}
