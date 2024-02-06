<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use function response;

class UserLotteryHistory extends Controller
{
    public function checkLotteryResult(Request $request)
    {
        try{
            $request->validate([
                'lotteryId' => 'required|string|max:255',
                'userId' => 'required|string|max:255',
            ]);
            $lotteryId = $request->lotteryId;
            $userId = $request->userId;
            $lottery = \App\Models\Lottery::where('lottery_id',$lotteryId)->first();
            $userLotteryHistory = \App\Models\UserLotteryHistory::where('lottery_id',$lotteryId)->where('user_id',$userId)->first();

            $lottery->end_time = DateTime::createFromFormat('Y-m-d H:i:s', $lottery->end_time)->getTimestamp();
            $lottery->start_time = DateTime::createFromFormat('Y-m-d H:i:s', $lottery->start_time)->getTimestamp();
            if($userLotteryHistory != null){
                if($userLotteryHistory->payment_date != null){
                    $userLotteryHistory->payment_date = DateTime::createFromFormat('Y-m-d H:i:s', $userLotteryHistory->payment_date)->getTimestamp();
                }
            }


            if(Carbon::now()->timestamp > $lottery->end_time ){
                $lotteryHasEnded = true;
            }
            else{
                $lotteryHasEnded = false;
            }

            return response([
                'lotteryHasEnded' => $lotteryHasEnded,
                'lottery'=>$lottery,
                'userLotteryHistory'=>$userLotteryHistory
            ],200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }

    }

    public function registerLotteryHeliosId(Request $request)
    {
        try{
            $request->validate([
                'lotteryId' => 'required|string|max:255',
                'userId' => 'required|string|max:255',
                'heliosId' => 'required|string|max:255',
            ]);
            $lotteryId = $request->lotteryId;
            $userId = $request->userId;
            $heliosId = $request->heliosId;
            $userLotteryHistory = \App\Models\UserLotteryHistory::where('lottery_id',$lotteryId)->where('user_id',$userId)->first();
//            dd($userLotteryHistory->helios_id,$heliosId);
            $userLotteryHistory->helios_id = $heliosId;
            $userLotteryHistory->save();

            return response(['message'=>'Helios id registered successfully'],200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }

    }

    public function createUserLotteryHistory(Request $request)
    {
        try{
            $request->validate([
                'lotteryId' => 'required|string|max:255',
                'userId' => 'required|string|max:255',
            ]);
            $lotteryId = $request->lotteryId;
            $userId = $request->userId;

            $lottery = \App\Models\Lottery::where('lottery_id',$lotteryId)->first();
            if(Carbon::now()->timestamp > DateTime::createFromFormat('Y-m-d H:i:s', $lottery->end_time)->getTimestamp() ){
                return response(['result'=>false,'message'=>'lottery has been ended'],200);
            }

            $user = \App\Models\Users::where('user_id',$userId)->first();
            if($user->status == false ){
                return response(['result'=>false,'message'=>'user has been banned'],200);
            }
            if($user->golds - $lottery->required_gold < 0 ){
                return response(['result'=>false,'message'=>'user has not required gold'],200);
            }

            $lottery->subscriber_count++;
            $lottery->save();

            $user->golds -= $lottery->required_gold;
            $user->save();

            $userLotteryHistory = \App\Models\UserLotteryHistory::where('lottery_id',$lotteryId)->where('user_id',$userId)->first();

            if($userLotteryHistory != null){
                $userLotteryHistory->join_times ++;
            }
            else{
                $userLotteryHistory = new \App\Models\UserLotteryHistory();
                $userLotteryHistory->user_id = $userId;
                $userLotteryHistory->lottery_id = $lotteryId;
                $userLotteryHistory->join_times = 1;
            }
            $userLotteryHistory->save();

            return response(['result'=>true,'message'=>'user lottery history created successfully'],200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }

    }

    public function getLotteryHistory(Request $request)
    {
        try{
            $request->validate([
                'userId' => 'required|string|max:255',
            ]);
            $userId = $request->userId;

            $userLotteryHistories = \App\Models\UserLotteryHistory::where('user_id',$userId)->get();

            if($userLotteryHistories != null){
                foreach ($userLotteryHistories as $userLotteryHistory){
                    $lottery = \App\Models\Lottery::where('lottery_id',$userLotteryHistory->lottery_id)->first();
                    $userLotteryHistory->price = $lottery->price;
                    $userLotteryHistory->required_gold = $lottery->required_gold;
                    $userLotteryHistory->subscriber_count = $lottery->subscriber_count;
                    $userLotteryHistory->status = $lottery->status;
                    if($userLotteryHistory->payment_date != null){
                        $userLotteryHistory->payment_date = DateTime::createFromFormat('Y-m-d H:i:s', $userLotteryHistory->payment_date)->getTimestamp() - (Carbon::now()->timestamp);
                    }
                    $userLotteryHistory->end_time = DateTime::createFromFormat('Y-m-d H:i:s', $lottery->end_time)->getTimestamp() - (Carbon::now()->timestamp);
                }
            }

            return response($userLotteryHistories,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }

    }


}
