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

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index']);

Route::middleware('guest')->prefix('/auth')->group(function() {
    Route::get('/', [\App\Http\Controllers\Auth\AuthController::class, 'index'])->name('auth');
    Route::prefix('/register')->name('register.')->group(function() {
        Route::get('/', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('show');
        Route::post('/', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('store');
    });
});



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return 'DASHBOARD';
    })->name('dashboard');
});
