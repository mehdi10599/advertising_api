<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use function response;

class Settings extends Controller
{
    public function getSettings()
    {
        try{
            $result = \App\Models\Settings::first();
            return response($result,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }
}
