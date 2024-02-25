<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;
    protected $table = 'user_activity';
    protected $casts = [ 'amount' => 'string'];
    protected $fillable = [
        'user_id',
        'activity',
        'amount',
        'time',
    ];
}
