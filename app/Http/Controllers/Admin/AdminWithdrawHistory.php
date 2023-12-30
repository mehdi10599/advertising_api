<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class AdminWithdrawHistory extends Controller
{
    public function getAllWithdrawHistories()
    {
        try{
            $results = \App\Models\WithdrawHistory::get();
            foreach($results as $userWithdrawHistory){
                if($userWithdrawHistory->payment_date != null){
                    $userWithdrawHistory->payment_date = DateTime::createFromFormat('Y-m-d H:i:s', $userWithdrawHistory->payment_date)->getTimestamp() - (Carbon::now()->timestamp) ;
                }
            }
            return response($results,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

    public function changeWithdrawStatus(Request $request)
    {
        try{
            $request->validate([
                'id' => 'required|integer',
            ]);
            $id = $request->id;
            $userWithdrawHistory = \App\Models\WithdrawHistory::where('id',$id)->first();
            if($userWithdrawHistory != null){
                $userWithdrawHistory->payment_status = true;
                $userWithdrawHistory->payment_date = Carbon::now();
                $userWithdrawHistory->save();

                return response(['result'=>true],200);
            }
            else{
                return response(['result'=>false],200);
            }

        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }
}
