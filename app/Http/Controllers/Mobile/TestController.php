<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Routing\Controller as BaseController;
use function response;


class TestController extends BaseController
{
    public function test()
    {
        return response(['message' => ['test response']], 200);
    }
}
