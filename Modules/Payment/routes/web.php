<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;

Route::prefix('payment')->as('payment.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [PaymentController::class, 'index'])->name('portal');
        Route::get('/erp', [PaymentController::class, 'index'])->name('erp');
    });
});
