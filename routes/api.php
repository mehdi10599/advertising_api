<?php

use App\Http\Controllers\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', 'App\Http\Controllers\TestController@test');

Route::group(['prefix' => 'app/v1'], function () {
    Route::post('/create_user/{userId}',[Users::class, 'createUser']);
});
