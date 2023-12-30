<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Home extends Controller
{
    public function getAllUsers()
    {
        try{
            $users = \App\Models\Users::get();

            return response($users,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }
    public function banUnbanUser(Request $request)
    {
        try{
            $request->validate([
                'userId' => 'required|string|max:255',
                'currentStatus' => 'required|bool',
            ]);
            $userId = $request->userId;
            $currentStatus = $request->currentStatus;
            $user = \App\Models\Users::where('user_id',$userId)->first();
            $user->status = !($currentStatus == '1');
            $user->save();
            return response($user,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }
}
