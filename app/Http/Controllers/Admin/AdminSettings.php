<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class AdminSettings extends Controller
{
    public function getSettings()
    {
        try{
            $result = Settings::first();

            return response($result,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

    public function updateSettings(Request $request)
    {
        try{
            $request->validate([
                'min_withdraw_gold' => 'required|integer',
                'min_withdraw_gem' => 'required|integer',
                'usa_token_prize' => 'required|integer',
                'europe_token_prize' => 'required|integer',
                'other_token_prize' => 'required|integer',
            ]);

            $settings = Settings::first();
            if($settings == null){
                $settings = new Settings();
            }
            $settings->min_withdraw_gold = $request->min_withdraw_gold;
            $settings->min_withdraw_gem = $request->min_withdraw_gem;
            $settings->usa_token_prize = $request->usa_token_prize;
            $settings->europe_token_prize = $request->europe_token_prize;
            $settings->other_token_prize = $request->other_token_prize;
            $settings->save();

            return response(['result'=>true],200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }
}
