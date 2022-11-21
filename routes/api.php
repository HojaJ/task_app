<?php

use App\Http\Controllers\Api\TemperatureController;
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

Route::get('/cities', [TemperatureController::class, 'cities']);
Route::get('/humidity/{city}/{date}', [TemperatureController::class, 'chart']);
Route::get('/wind_speed/{city}/{date}', [TemperatureController::class, 'chart']);
Route::get('/temp/{city}/{date}', [TemperatureController::class, 'chart']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
