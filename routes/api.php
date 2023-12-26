<?php

use App\Http\Controllers\Settings;
use App\Http\Controllers\UserLotteryHistory;
use App\Http\Controllers\Users;
use App\Http\Controllers\Lottery;
use App\Http\Controllers\WithdrawHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', 'App\Http\Controllers\TestController@test');

Route::group(['prefix' => 'app/v1'], function () {
    Route::post('/user_exist',[Users::class, 'userExist']);
    Route::post('/get_user_data',[Users::class, 'getUserData']);
    Route::post('/ban_user',[Users::class, 'banUser']);
    Route::post('/get_lottery_boxes',[Lottery::class, 'getLotteryBoxes']);
    Route::post('/check_lottery_result',[UserLotteryHistory::class, 'checkLotteryResult']);
    Route::post('/register_lottery_helios_id',[UserLotteryHistory::class, 'registerLotteryHeliosId']);
    Route::post('/get_settings',[Settings::class, 'getSettings']);
    Route::post('/send_withdraw_request',[WithdrawHistory::class, 'sendWithdrawRequest']);
    Route::post('/get_withdraw_history',[WithdrawHistory::class, 'getWithdrawHistory']);
    Route::post('/increase_golds_gems_ads',[Users::class, 'increaseGoldsGemsAds']);
    Route::post('/create_user_lottery_history',[UserLotteryHistory::class, 'createUserLotteryHistory']);
    Route::post('/get_lottery_history',[UserLotteryHistory::class, 'getLotteryHistory']);
});
