<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use function response;

class Lottery extends Controller
{
    public function getLotteryBoxes(Request $request)
    {
        try{
            $request->validate([
                'userId' => 'required|string|max:255',
            ]);
            $userId = $request->userId;
            $lotteries = \App\Models\Lottery::where('status',true)->take(4)->orderBy('price','ASC')->get();
            foreach ($lotteries as $lottery){
                $lotteryId = $lottery->lottery_id;
                $userLotteryHistory = \App\Models\UserLotteryHistory::where('lottery_id',$lotteryId)->where('user_id',$userId)->first();
                $lottery->start_time = DateTime::createFromFormat('Y-m-d H:i:s', $lottery->start_time)->getTimestamp() - (Carbon::now()->timestamp) ;
                $lottery->end_time = DateTime::createFromFormat('Y-m-d H:i:s', $lottery->end_time)->getTimestamp() - (Carbon::now()->timestamp) ;
                if($userLotteryHistory != null){
                    $lottery['result'] = $userLotteryHistory->result;
                    $lottery['join_times'] = $userLotteryHistory->join_times;
                }
                else{
                    $lottery['join_times'] = '0';
                    $lottery['result'] = 'isRunning';
                }
            }
            return response($lotteries,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }

    }
}
