<?php

use Illuminate\Support\Facades\Route;
use Modules\School\Http\Controllers\SchoolController;
use Modules\School\Http\Middleware\EnsureSchoolContext;

Route::middleware(EnsureSchoolContext::class)->prefix('school')->as('school.')->group(function () {
    Route::get('/', [SchoolController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [SchoolController::class, 'portal'])->name('portal');
        Route::get('/erp', [SchoolController::class, 'erp'])->name('erp');
    });
});
