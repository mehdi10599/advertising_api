<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $casts = [ 'golds' => 'string', 'gems' => 'string', 'ads' => 'string', 'status' => 'string' ];
    protected $fillable = [
        'user_id',
        'golds',
        'gems',
        'ads',
        'location',
        'user_ip',
        'status',
        'last_ad_seen',
    ];

    public function lotteries()
    {
        return $this->belongsToMany(Lottery::class,'user_lottery_history','lottery_id','user_id');
    }

    public function userLotteryHistories()
    {
        return $this->hasMany(UserLotteryHistory::class,'user_id','user_id');
    }

    public function withdrawHistories()
    {
        return $this->hasMany(WithdrawHistory::class,'user_id','user_id');
    }
}
