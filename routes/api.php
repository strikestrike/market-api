<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('store-customer-data'   , 'App\Http\Controllers\Api\CustomerController@store'    );
Route::post('login'   , 'App\Http\Controllers\Api\CustomerController@login'    );
Route::post('identify'   , 'App\Http\Controllers\Api\CustomerController@identify'    );
Route::get('notifications'   , 'App\Http\Controllers\Api\CustomerController@notifications'    );