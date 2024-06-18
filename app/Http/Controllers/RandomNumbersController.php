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

        return response([
            "numbers" => RandomUtils::generateNumbers($qty)
        ]);
    }

    function maybeErrorRandom(Request $request): Response
    {
        $random = $this->random($request);
        $chance = RandomUtils::getValidRandomChance($request->input('chance', 20));

        if (RandomUtils::randomChance($chance)) {
            return response([
                "error" => "invalid return"
            ], 400);
        }

        return $random;
    }
}
