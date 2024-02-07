<?php

use App\Http\Controllers\Admin\AdminSettings;
use App\Http\Controllers\Admin\AdminShop;
use App\Http\Controllers\Admin\AdminWithdrawHistory;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Home;
use App\Http\Controllers\Admin\LotteryList;
use App\Http\Controllers\Mobile\Lottery;
use App\Http\Controllers\Mobile\Settings;
use App\Http\Controllers\Mobile\Shop;
use App\Http\Controllers\Mobile\UserLotteryHistory;
use App\Http\Controllers\Mobile\Users;
use App\Http\Controllers\Mobile\WithdrawHistory;
use Illuminate\Support\Facades\Route;


Route::get('/test', 'App\Http\Controllers\Mobile\TestController@test');

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
    Route::post('/get_shop_items',[Shop::class, 'getShopItems']);
});



Route::group(['prefix' => 'admin/v1'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    Route::post('/get_all_users', [Home::class, 'getAllUsers'])->middleware('auth:sanctum');
    Route::post('/ban_unban_user', [Home::class, 'banUnbanUser'])->middleware('auth:sanctum');
    Route::post('/get_all_lottery_boxes', [LotteryList::class, 'getAllLotteryBoxes'])->middleware('auth:sanctum');
    Route::post('/get_lottery_subscribers', [LotteryList::class, 'getLotterySubscribers'])->middleware('auth:sanctum');
    Route::post('/get_lottery_winners', [LotteryList::class, 'getLotteryWinners'])->middleware('auth:sanctum');
    Route::post('/create_lottery_box', [LotteryList::class, 'createLotteryBox'])->middleware('auth:sanctum');
    Route::post('/change_user_lottery_result', [LotteryList::class, 'changeUserLotteryResult'])->middleware('auth:sanctum');
    Route::post('/change_user_lottery_payment', [LotteryList::class, 'changeUserLotteryPayment'])->middleware('auth:sanctum');
    Route::post('/get_all_withdraw_histories', [AdminWithdrawHistory::class, 'getAllWithdrawHistories'])->middleware('auth:sanctum');
    Route::post('/change_withdraw_status', [AdminWithdrawHistory::class, 'changeWithdrawStatus'])->middleware('auth:sanctum');
    Route::post('/get_settings', [AdminSettings::class, 'getSettings'])->middleware('auth:sanctum');
    Route::post('/update_settings', [AdminSettings::class, 'updateSettings'])->middleware('auth:sanctum');
    Route::post('/get_shop_items', [AdminShop::class, 'getShopItems'])->middleware('auth:sanctum');
    Route::post('/update_shop_items_url', [AdminShop::class, 'updateShopItemUrl'])->middleware('auth:sanctum');
    Route::post('/update_shop_items_description', [AdminShop::class, 'updateShopItemDescription'])->middleware('auth:sanctum');
    Route::post('/delete_shop_items', [AdminShop::class, 'deleteShopItem'])->middleware('auth:sanctum');
    Route::post('/update_shop_items_image', [AdminShop::class, 'updateShopItemImage'])->middleware('auth:sanctum');
    Route::post('/create_shop_items', [AdminShop::class, 'createShopItem'])->middleware('auth:sanctum');
});
