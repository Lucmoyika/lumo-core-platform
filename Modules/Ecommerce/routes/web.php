<?php

use Illuminate\Support\Facades\Route;
use Modules\Ecommerce\Http\Controllers\EcommerceController;
use Modules\Ecommerce\Http\Middleware\EnsureEcommerceContext;

Route::middleware(EnsureEcommerceContext::class)->prefix('ecommerce')->as('ecommerce.')->group(function () {
    Route::get('/', [EcommerceController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [EcommerceController::class, 'portal'])->name('portal');
        Route::get('/erp', [EcommerceController::class, 'erp'])->name('erp');
    });
});
