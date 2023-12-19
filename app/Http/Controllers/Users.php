<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Users extends Controller
{
    public function createUser($userId)
    {
        return response(['message'=>'user:'.$userId.' created...!'],200);
    }
}
