<?php

use Illuminate\Support\Facades\Route;
use Modules\Analytics\Http\Controllers\AnalyticsController;

Route::prefix('analytics')->as('analytics.')->group(function () {
    Route::get('/', [AnalyticsController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [AnalyticsController::class, 'index'])->name('portal');
        Route::get('/erp', [AnalyticsController::class, 'index'])->name('erp');
    });
});
