<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    use HasFactory;
    public $table = 'lottery';
    protected $casts = [ 'price' => 'string', 'required_gold' => 'string', 'subscriber_count' => 'string', 'status' => 'string' ];
    protected $fillable = [
        'lottery_id',
        'price',
        'required_gold',
        'subscriber_count',
        'start_time',
        'end_time',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(Users::class,'user_lottery_history','user_id','lottery_id');
    }
}
