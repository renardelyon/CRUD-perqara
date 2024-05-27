<?php

use App\Http\Controllers\ItemController;
use App\Http\Middleware\JsonResponseMiddleware;
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

Route::middleware([JsonResponseMiddleware::class])->group(function () {
    Route::get('/items', [ItemController::class, 'getAllItem']);

    Route::post('/items', [ItemController::class, 'insertItem']);

    Route::post('/calculate-items', [ItemController::class, 'calculateItemQuantity']);
});
