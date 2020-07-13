<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;

class ApiController extends \Illuminate\Routing\Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    use ApiResponser;
}
