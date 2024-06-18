<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\RandomUtils;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['page', 'numbers'];

    protected $casts = [
        'numbers' => 'array'
    ];

    static function getPageNumbers($pageNumber)
    {
        $page = self::wherePage($pageNumber)->first();

        if (!is_null($page)) {
            return $page->numbers;
        }

        $pageNumberSize = config('app.random_page_numbers_size');

        $numbers = RandomUtils::generateNumbers($pageNumberSize);

        self::create(['page' => $pageNumber, 'numbers' => $numbers]);

        return $numbers;
    }
}
