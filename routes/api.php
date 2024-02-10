<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;

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


Route::group(['prefix' => 'redirects'], function () {
    Route::apiResource('/', RedirectController::class)->except(['update'])->parameters(['' => 'redirectCode']);
    Route::patch('/{redirect:code}', [RedirectController::class, 'update']);

    Route::get('/{redirect:code}/stats', function (Request $request) {
        return response('ok');
    });

    Route::get('/{redirect:code}/logs', [RedirectController::class, 'getRedirectLogs']);
});
