<?php

use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\EventController;
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

Route::prefix('/user')->group(function () {
    Route::post('/create', [UserRegisterController::class, 'store'])->name('signup');
    Route::post('/login', [UserLoginController::class, 'store'])->name('login');
});

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::prefix('/event')->group(function () {
        Route::post('create', [EventController::class, 'store'])->name('create');
    });
});