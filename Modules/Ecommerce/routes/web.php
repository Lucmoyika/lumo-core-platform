<?php

use Illuminate\Support\Facades\Route;
use Modules\Ecommerce\Http\Controllers\EcommerceController;

Route::prefix('ecommerce')->as('ecommerce.')->group(function () {
    Route::get('/', [EcommerceController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [EcommerceController::class, 'index'])->name('portal');
        Route::get('/erp', [EcommerceController::class, 'index'])->name('erp');
        Route::get('/dashboard/customer', [EcommerceController::class, 'index'])->name('customer.dashboard');
    });
});
