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
        Route::get('/', [\App\Http\Controllers\Course\CourseController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Course\CourseController::class, 'store']);
        Route::get('/{course}', [\App\Http\Controllers\Course\CourseController::class, 'show']);
        Route::post('/{course}', [\App\Http\Controllers\Course\CourseController::class, 'update']);
        Route::post('/{course}/add-student', [\App\Http\Controllers\Course\CourseController::class, 'addStudent']);
        Route::post('/{course}/remove-student', [\App\Http\Controllers\Course\CourseController::class, 'removeStudent']);
    });

    Route::get('/chats/{chat}', [\App\Http\Controllers\ChatController::class, 'show']);
    Route::post('/chats/{chat}/publish', [\App\Http\Controllers\ChatController::class, 'publish']);
    Route::get('/chats/{chat}/messages', [\App\Http\Controllers\ChatController::class, 'messages']);

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show']);
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update']);
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy']);
});


Route::post('courses/{course}/lessons', [\App\Http\Controllers\Course\LessonController::class, 'store']);
