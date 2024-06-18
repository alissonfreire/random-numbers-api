<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\RandomUtils;

class RandomNumbersController extends Controller
{
    function random(Request $request): Response
    {
        $qty = $request->input('qty', 10);

        $numbers = RandomUtils::generateNumbers($qty);

        if ($request->boolean('no_error')) {
            return response(["numbers" => $numbers]);
        }

        $chance = $request->input('chance', 20);

        if (RandomUtils::randomChance($chance)) {
            return response([
                "error" => "invalid return"
            ], 400);
        }

        return response(["numbers" => $numbers]);
    }
}
