<?php

use Illuminate\Support\Facades\Route;
use Modules\School\Http\Controllers\SchoolController;
use Modules\School\Http\Middleware\EnsureSchoolContext;

Route::middleware(EnsureSchoolContext::class)->prefix('school')->as('school.')->group(function () {
    // Public site
    Route::get('/', [SchoolController::class, 'index'])->name('home');

    // Online admission (public)
    Route::get('/admission', [SchoolController::class, 'admission'])->name('admission');
    Route::post('/admission', [SchoolController::class, 'admissionSubmit'])->name('admission.submit');
    Route::get('/admission/merci', [SchoolController::class, 'admissionConfirmed'])->name('admission.confirmed');

    // Authenticated areas
    Route::middleware('auth')->group(function () {
        Route::get('/portal', [SchoolController::class, 'portal'])->name('portal');
        Route::get('/erp', [SchoolController::class, 'erp'])->name('erp');
    });
});
