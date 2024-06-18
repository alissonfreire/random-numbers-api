<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\RandomUtils;

class PageController extends Controller
{
    function page(Request $request, $pageNumber): Response
    {
        $pageNumber = $this->maybeCastPageNumber($pageNumber);

        if ($errorMsg = $this->validatePageNumber($pageNumber)) {
            return response($this->buildErrorResponse($errorMsg), 422);
        }

        $pageNumber = min($pageNumber, $this->maxPageSize());

        $numbers = Page::getPageNumbers($pageNumber);

        $successResponse = response(["page" => $pageNumber, "numbers" => $numbers]);

        if ($request->boolean('no_error')) {
            return $successResponse;
        }

        $chance = $request->input('chance', 20);

        if (RandomUtils::randomChance($chance)) {
            return response([
                "error" => "invalid return"
            ], 400);
        }

        return $successResponse;
    }

    function validatePageNumber($pageNumber)
    {
        if (!is_int($pageNumber) || (0 >= $pageNumber)) {
            return "pageNumber must be a positive integer number";
        }

        $max_page_size = $this->maxPageSize();

        if ($max_page_size < $pageNumber) {
            return "pageNumber must not be greater than {$max_page_size}";
        }

        return false;
    }

    function buildErrorResponse($errorMessage)
    {
        return [
            'message' => 'Validation error',
            'error' => $errorMessage
        ];
    }

    function maybeCastPageNumber($pageNumber)
    {
        if (is_string($pageNumber) && is_numeric($pageNumber)) {
            return (int) $pageNumber;
        }

        return $pageNumber;
    }

    function maxPageSize()
    {
        return (int) config('app.max_page_size');
    }
}
