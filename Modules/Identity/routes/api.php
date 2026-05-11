<?php

use Illuminate\Support\Facades\Route;
use Modules\Identity\Http\Controllers\Api\AuthApiController;

Route::group(['prefix' => 'identity', 'as' => 'identity.'], function () {
    Route::post('/auth/login', [AuthApiController::class, 'login'])->name('login');
    Route::post('/auth/register', [AuthApiController::class, 'register'])->name('register');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthApiController::class, 'logout'])->name('logout');
        Route::get('/auth/me', [AuthApiController::class, 'me'])->name('me');
    });
});
