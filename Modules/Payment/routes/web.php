<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;

Route::prefix('payment')->as('payment.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('home');
});
