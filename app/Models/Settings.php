<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $casts = [ 'min_withdraw_gold' => 'string', 'min_withdraw_gem' => 'string', 'usa_token_prize' => 'string', 'europe_token_prize' => 'string', 'other_token_prize' => 'string' ];
}
