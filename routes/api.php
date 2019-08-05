<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v0')->namespace('Api\V0')->group(function () {
    Route::apiResource('/products', 'ProductController');
    Route::apiResource('/categories', 'CategoryController');
});
