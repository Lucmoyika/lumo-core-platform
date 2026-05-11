<?php

use Illuminate\Support\Facades\Route;
use Modules\Logistics\Http\Controllers\LogisticsController;
use Modules\Logistics\Http\Middleware\EnsureLogisticsContext;

Route::middleware(EnsureLogisticsContext::class)->prefix('logistics')->as('logistics.')->group(function () {
    Route::get('/', [LogisticsController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [LogisticsController::class, 'portal'])->name('portal');
        Route::get('/erp', [LogisticsController::class, 'erp'])->name('erp');
    });
});
