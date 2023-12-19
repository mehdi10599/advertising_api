<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    use HasFactory;
    protected $fillable = [
        'lottery_id',
        'price',
        'required_gold',
        'required_gem',
        'subscriber_count',
        'start_time',
        'end_time',
    ];

    public function users()
    {
        return $this->belongsToMany(Users::class,'user_lottery_history','user_id','lottery_id');
    }
}
