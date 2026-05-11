<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;
use Modules\Payment\Http\Middleware\EnsurePaymentContext;

Route::middleware(EnsurePaymentContext::class)->prefix('payment')->as('payment.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [PaymentController::class, 'portal'])->name('portal');
        Route::get('/erp', [PaymentController::class, 'erp'])->name('erp');
    });
});
