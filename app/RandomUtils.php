<?php

namespace App;

class RandomUtils
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    static function generateNumbers($qty = 10)
    {
        return array_map(fn ($_) => mt_rand() / mt_getrandmax(), range(0, $qty - 1));
    }

    static function randomChance($percent)
    {
        return (mt_rand(1, 100) < $percent);
    }

    static function getValidRandomChance(int $chance = 20)
    {
        return max(0, min($chance, 100));
    }
}
