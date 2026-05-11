<?php

use Illuminate\Support\Facades\Route;
use Modules\Communication\Http\Controllers\CommunicationController;
use Modules\Communication\Http\Middleware\EnsureCommunicationContext;

Route::middleware(EnsureCommunicationContext::class)->prefix('communication')->as('communication.')->group(function () {
    Route::get('/', [CommunicationController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [CommunicationController::class, 'portal'])->name('portal');
        Route::get('/erp', [CommunicationController::class, 'erp'])->name('erp');
    });
});
