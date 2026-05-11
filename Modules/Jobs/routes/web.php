<?php

use Illuminate\Support\Facades\Route;
use Modules\Jobs\Http\Controllers\JobsController;

Route::prefix('jobs')->as('jobs.')->group(function () {
    Route::get('/', [JobsController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [JobsController::class, 'index'])->name('portal');
        Route::get('/erp', [JobsController::class, 'index'])->name('erp');
        Route::get('/dashboard/recruiter', [JobsController::class, 'index'])->name('recruiter.dashboard');
    });
});
