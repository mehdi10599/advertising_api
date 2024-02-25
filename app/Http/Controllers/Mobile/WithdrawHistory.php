<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use function response;

class WithdrawHistory extends Controller
{
    public function sendWithdrawRequest(Request $request)
    {
        try{
            $request->validate([
                'userId' => 'required|string|max:255',
                'heliosId' => 'required|string|max:255',
                'golds' => 'digits_between:1,5',
                'gems' => 'digits_between:1,5',
                'ads' => 'digits_between:1,5',
            ]);
            $userId = $request->userId;
            $heliosId = $request->heliosId;
            $golds = $request->golds;
            $gems = $request->gems;
            $ads = $request->ads;
            $user = \App\Models\Users::where('user_id',$userId)->first();
            if($user->golds != $golds ||$user->gems != $gems ||$user->ads != $ads ){
                $user->status = false;
                $user->save();
                return response(['message'=>'user banned due to data conflict'],200);
            }
            else if($user->status == true){
                $user->golds = 0;
                $user->gems = 0;
                $user->ads = 0;
                $user->save();
                $withDrawHistory = new \App\Models\WithdrawHistory();
                $withDrawHistory->user_id = $userId;
                $withDrawHistory->helios_id = $heliosId;
                $withDrawHistory->golds = $golds;
                $withDrawHistory->gems = $gems;
                $withDrawHistory->ads = $ads;
                $withDrawHistory->save();
                $this->registerUserActivity($userId,$golds,$gems);
                return response(['message'=>'request registered successfully'],200);
            }
            else{
                return response(['message'=>'user has been banned'],200);
            }
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

    private function registerUserActivity($userId,$golds,$gems){
        $amount1 = $golds;
        $amount2 = $gems;
        $type = "withdraw gold";
        $time = Carbon::now();
        $userActivity = new UserActivity();
        $userActivity->user_id = $userId;
        $userActivity->amount = -1*$amount1;
        $userActivity->activity = $type;
        $userActivity->time = $time;
        $userActivity->save();

        $type = "withdraw gem";
        $userActivity = new UserActivity();
        $userActivity->user_id = $userId;
        $userActivity->amount = -1*$amount2;
        $userActivity->activity = $type;
        $userActivity->time = $time;
        $userActivity->save();
    }

    public function getWithdrawHistory(Request $request)
    {
        try{
            $request->validate([
                'userId' => 'required|string|max:255',
            ]);
            $userId = $request->userId;
            $userWithdrawHistories = \App\Models\WithdrawHistory::where('user_id',$userId)->where('payment_status',true)->get();
            foreach($userWithdrawHistories as $userWithdrawHistory){
                if($userWithdrawHistory->payment_date != null){
                    $userWithdrawHistory->payment_date = DateTime::createFromFormat('Y-m-d H:i:s', $userWithdrawHistory->payment_date)->getTimestamp() - (Carbon::now()->timestamp) ;
                }
            }

            return response($userWithdrawHistories,200);

        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }
}
