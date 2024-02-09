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
    Route::apiResource('/', RedirectController::class)->parameters(['' => 'redirectCode']);

    Route::get('/{redirect}/stats', function (Request $request) {
        return response('ok');
    });

    Route::get('/{redirect}/logs', function (Request $request) {
        return response('ok');
    });
});
