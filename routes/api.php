<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RandomNumbersController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\InfoController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/info', [InfoController::class, 'info']);
Route::get('/random', [RandomNumbersController::class, 'random']);
Route::get('/page/{pageNumber}', [PageController::class, 'page']);
