<?php

use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
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
        Route::get('show', [EventController::class, 'show'])->name('show');
        Route::get('all', [EventController::class, 'showAll'])->name('show.all');
        Route::patch('update/{event}', [EventController::class, 'update'])->name('update');
        Route::delete('delete/{event}', [EventController::class, 'delete'])->name('delete');
    });

    Route::prefix('/ticket')->group(function () {
        Route::post('create', [TicketController::class, 'store'])->name('ticket.create');
    });
});
