<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\RandomUtils;

class RandomNumbersController extends Controller
{
    function random(Request $request): Response
    {
        $qty = $request->input('qty', $this->randomNumbersQty());

        $numbers = RandomUtils::generateNumbers($qty);

        if ($request->boolean('no_error')) {
            return response(["numbers" => $numbers]);
        }

        $chance = $request->input('chance', $this->errorChance());

        if (RandomUtils::randomChance($chance)) {
            return response([
                "error" => "invalid return"
            ], 400);
        }

        return response(["numbers" => $numbers]);
    }

    function errorChance()
    {
        return config('app.error_chance');
    }

    function randomNumbersQty()
    {
        return config('app.random_numbers_qty');
    }
}
