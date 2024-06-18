<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InfoController extends Controller
{
    function info(Request $request): Response
    {
        return response([
            "error_chance" => config('app.error_chance'),
            "max_page_size" => config('app.max_page_size'),
            "random_numbers_qty" => config('app.random_numbers_qty')
        ]);
    }
}
