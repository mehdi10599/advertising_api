<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function response;

class Users extends Controller
{
    public function userExist(Request $request)
    {
        try{
            $request->validate([
                'userId' => 'required|string|max:255',
            ]);
            $userId = $request->userId;
            $result = \App\Models\Users::where('user_id',$userId)->first();
            if($result != null){
                return response(['userExist'=>true],200);
            }
            else{
                $this->createNewUser($userId);
                return response(['userExist'=>false],200);
            }
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }

    }

    private function createNewUser($userId)
    {
        $user = new \App\Models\Users();
        $user->user_id = $userId;
        $user->golds = 0;
        $user->gems = 0;
        $user->ads = 0;
        $user->location = '';
        $user->user_ip = '';
        $user->status = true;
        $user->save();
    }

    public function getUserData(Request $request)
    {
        try{
            $request->validate([
                'userId' => 'required|string|max:255',
            ]);
            $userId = $request->userId;
            $user = \App\Models\Users::where('user_id',$userId)->first();
            if($user == null){
                $newUser = new \App\Models\Users();
                $newUser->user_id = $userId;
                $newUser->save();
                $user = $newUser;
            }
            return response($user,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }

    }

    public function banUser(Request $request)
    {
        try{
            $request->validate([
                'userId' => 'required|string|max:255',
            ]);
            $userId = $request->userId;
            $user = \App\Models\Users::where('user_id',$userId)->first();
            $user->status = false;
            $user->save();
            return response(['message'=>'user banned'],200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }

    }

    public function increaseGoldsGemsAds(Request $request)
    {
        try{
            $request->validate([
                'userId' => 'required|string|max:255',
                'golds' => 'digits_between:1,5',
                'gems' => 'digits_between:1,5',
                'ads' => 'digits_between:1,5',
            ]);
            $userId = $request->userId;
            $golds = $request->golds;
            $gems = $request->gems;
            $ads = $request->ads;

            $user = \App\Models\Users::where('user_id',$userId)->first();
            if($user != null){
                $user->golds += $golds;
                $user->gems += $gems;
                $user->ads += $ads;
                $user->save();
                return response([true],200);
            }
            else{
                return response([false],200);
            }
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

}
