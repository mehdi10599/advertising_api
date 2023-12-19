<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;


class TestController extends BaseController
{
    public function test()
    {
        return response(['message' => ['test response']], 200);
    }
}
