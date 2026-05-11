<?php

use Illuminate\Support\Facades\Route;
use Modules\University\Http\Controllers\UniversityController;

Route::prefix('university')->as('university.')->group(function () {
    Route::get('/', [UniversityController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [UniversityController::class, 'index'])->name('portal');
        Route::get('/erp', [UniversityController::class, 'index'])->name('erp');
        Route::get('/dashboard/admin', [UniversityController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard/student', [UniversityController::class, 'index'])->name('student.dashboard');
        Route::get('/dashboard/teacher', [UniversityController::class, 'index'])->name('teacher.dashboard');
    });
});
