<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\UserLotteryHistory;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LotteryList extends Controller
{
    public function getAllLotteryBoxes()
    {
        try{
            $users = \App\Models\Lottery::get();

            return response($users,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

    public function getLotterySubscribers(Request $request)
    {
        try{
            $request->validate([
                'lotteryId' => 'required|string|max:255',
            ]);
            $lotteryId = $request->lotteryId;
            $users = [];
            $userLotterySubscribers = UserLotteryHistory::where('lottery_id',$lotteryId)->get();
            foreach ($userLotterySubscribers as $subscriber){
                $user = Users::where('user_id',$subscriber->user_id)->first();
                $user['join_times'] = $subscriber->join_times;
                $user['result'] = $subscriber->result;
                $users[] = $user;
            }

            return response($users,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

    public function getLotteryWinners( )
    {
        try{
            $users = [];
            $userLotteryWinners = UserLotteryHistory::where('result','win')->where('payment_status',false)->get();
            foreach ($userLotteryWinners as $winner){
                $user = Users::where('user_id',$winner->user_id)->first();
                $user['join_times'] = $winner->join_times;
                $user['helios_id'] = $winner->helios_id;
                $user['payment_status'] = $winner->payment_status;
                $user['lottery_id'] = $winner->lottery_id;
                $users[] = $user;
            }

            return response($users,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

    public function createLotteryBox(Request $request)
    {
        try{
            $request->validate([
                'lottery_id' => 'required|string|max:255',
                'price' => 'required|integer',
                'required_gold' => 'required|integer',
                'subscriber_count' => 'required|integer',
                'start_time' => 'required|String',
                'end_time' => 'required|String',
                'status' => 'required|bool',
            ]);
            $lottery_id = $request->lottery_id;
            $price = $request->price;
            $required_gold = $request->required_gold;
            $subscriber_count = $request->subscriber_count;
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            $status = $request->status;

            $lottery = Lottery::where('lottery_id',$lottery_id)->first();
            if($lottery == null){
                $newLottery = new Lottery();
                $newLottery ->lottery_id = $lottery_id;
                $newLottery ->price = $price;
                $newLottery ->required_gold = $required_gold;
                $newLottery ->subscriber_count = $subscriber_count;
                $newLottery ->start_time = $start_time;
                $newLottery ->end_time = $end_time;
                $newLottery ->status = $status;
                $newLottery->save();
                return response(['result'=>true],200);
            }
            else{
                return response(['result'=>false],200);
            }
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage(),'trace'=>$exception->getTrace()],500);
        }
    }

    public function changeUserLotteryResult(Request $request)
    {
        try{
            $request->validate([
                'lotteryId' => 'required|string|max:255',
                'userId' => 'required|string|max:255',
                'result' => 'required|string|max:255',
            ]);
            $lotteryId = $request->lotteryId;
            $userId = $request->userId;
            $result = $request->result;

            $lotteryHistory = UserLotteryHistory::where('lottery_id',$lotteryId)->where('user_id',$userId)->first();
            if($lotteryHistory != null){
                $lotteryHistory->result = $result;
                $lotteryHistory->save();
                return response(['result'=>true],200);
            }
            else{
                return response(['result'=>false],200);
            }
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage(),'trace'=>$exception->getTrace()],500);
        }
    }

    public function changeUserLotteryPayment(Request $request)
    {
        try{
            $request->validate([
                'lotteryId' => 'required|string|max:255',
                'userId' => 'required|string|max:255',
            ]);
            $lotteryId = $request->lotteryId;
            $userId = $request->userId;

            $lotteryHistory = UserLotteryHistory::where('lottery_id',$lotteryId)->where('user_id',$userId)->first();
            if($lotteryHistory != null){
                $lotteryHistory->payment_status = true;
                $lotteryHistory->payment_date = Carbon::now();
                $lotteryHistory->save();
                return response(['result'=>true],200);
            }
            else{
                return response(['result'=>false],200);
            }
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage(),'trace'=>$exception->getTrace()],500);
        }
    }
}
