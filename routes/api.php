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

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/centrifugo/connect', [\App\Http\Controllers\CentrifugoProxyController::class, 'connect']);


    Route::middleware('teacher')->group(function () {
        Route::post('/teacher/invitations', [\App\Http\Controllers\Teacher\IndexController::class, 'createInvitation']);
    });

    Route::get('/rooms', [\App\Http\Controllers\RoomController::class, 'index']);
    Route::post('/rooms', [\App\Http\Controllers\RoomController::class, 'store']);
    Route::get('/rooms/{room}', [\App\Http\Controllers\RoomController::class, 'show']);
    Route::post('/rooms/{rooms}/publish', [\App\Http\Controllers\RoomController::class, 'publish']);
});
