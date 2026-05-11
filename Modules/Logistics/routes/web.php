<?php

use Illuminate\Support\Facades\Route;
use Modules\Logistics\Http\Controllers\LogisticsController;

Route::prefix('logistics')->as('logistics.')->group(function () {
    Route::get('/', [LogisticsController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [LogisticsController::class, 'index'])->name('portal');
        Route::get('/erp', [LogisticsController::class, 'index'])->name('erp');
    });
});
