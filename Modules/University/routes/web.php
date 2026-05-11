<?php

use Illuminate\Support\Facades\Route;
use Modules\University\Http\Controllers\UniversityController;
use Modules\University\Http\Middleware\EnsureUniversityContext;

Route::middleware(EnsureUniversityContext::class)->prefix('university')->as('university.')->group(function () {
    Route::get('/', [UniversityController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [UniversityController::class, 'portal'])->name('portal');
        Route::get('/erp', [UniversityController::class, 'erp'])->name('erp');
    });
});
