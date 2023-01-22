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

    Route::prefix('/courses')->group(function () {
        Route::get('/', [\App\Http\Controllers\CourseController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\CourseController::class, 'store']);
        Route::get('/{course}', [\App\Http\Controllers\CourseController::class, 'show']);
        Route::post('/{course}', [\App\Http\Controllers\CourseController::class, 'update']);
        Route::post('/{course}/add-student', [\App\Http\Controllers\CourseController::class, 'addStudent']);
        Route::post('/{course}/remove-student', [\App\Http\Controllers\CourseController::class, 'removeStudent']);
        Route::get('/{course}/chat', [\App\Http\Controllers\CourseController::class, 'getChat']);
    });


    Route::post('/chats/{chat}/publish', [\App\Http\Controllers\ChatController::class, 'publish']);
});
