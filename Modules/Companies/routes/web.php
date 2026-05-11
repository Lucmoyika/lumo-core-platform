<?php

use Illuminate\Support\Facades\Route;
use Modules\Companies\Http\Controllers\CompaniesController;
use Modules\Companies\Http\Middleware\EnsureCompaniesContext;

Route::middleware(EnsureCompaniesContext::class)->prefix('companies')->as('companies.')->group(function () {
    Route::get('/', [CompaniesController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [CompaniesController::class, 'portal'])->name('portal');
        Route::get('/erp', [CompaniesController::class, 'erp'])->name('erp');
    });
});
