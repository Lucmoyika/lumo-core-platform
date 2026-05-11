<?php

use Illuminate\Support\Facades\Route;
use Modules\Analytics\Http\Controllers\AnalyticsController;
use Modules\Analytics\Http\Middleware\EnsureAnalyticsContext;

Route::middleware(EnsureAnalyticsContext::class)->prefix('analytics')->as('analytics.')->group(function () {
    Route::get('/', [AnalyticsController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [AnalyticsController::class, 'portal'])->name('portal');
        Route::get('/erp', [AnalyticsController::class, 'erp'])->name('erp');
    });
});
