<?php

use Illuminate\Support\Facades\Route;
use Modules\Communication\Http\Controllers\CommunicationController;

Route::prefix('communication')->as('communication.')->group(function () {
    Route::get('/', [CommunicationController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [CommunicationController::class, 'index'])->name('portal');
        Route::get('/erp', [CommunicationController::class, 'index'])->name('erp');
    });
});
