<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RandomNumbersController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/random', [RandomNumbersController::class, 'random']);
Route::get('/maybe-error-random', [RandomNumbersController::class, 'maybeErrorRandom']);
