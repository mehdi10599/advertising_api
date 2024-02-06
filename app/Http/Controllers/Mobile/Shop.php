<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Shop extends Controller
{
    public function getShopItems()
    {
        try{
            $result = \App\Models\Shop::all();
            return response($result,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }
}
