<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function() {
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'resetPassword'])->name('password.update');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout']);
});




Route::get('/{any}', function () {
    return view('index');
})->where("any", ".*");
