<?php

use Illuminate\Support\Facades\Route;
use Modules\Jobs\Http\Controllers\JobsController;
use Modules\Jobs\Http\Middleware\EnsureJobsContext;

Route::middleware(EnsureJobsContext::class)->prefix('jobs')->as('jobs.')->group(function () {
    Route::get('/', [JobsController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [JobsController::class, 'portal'])->name('portal');
        Route::get('/erp', [JobsController::class, 'erp'])->name('erp');
    });
});
