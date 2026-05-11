<?php

use Illuminate\Support\Facades\Route;
use Modules\School\Http\Controllers\SchoolController;

Route::prefix('school')->as('school.')->group(function () {
    Route::get('/', [SchoolController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [SchoolController::class, 'index'])->name('portal');
        Route::get('/erp', [SchoolController::class, 'index'])->name('erp');
        Route::get('/dashboard/admin', [SchoolController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard/student', [SchoolController::class, 'index'])->name('student.dashboard');
        Route::get('/dashboard/teacher', [SchoolController::class, 'index'])->name('teacher.dashboard');
        Route::get('/dashboard/parent', [SchoolController::class, 'index'])->name('parent.dashboard');
    });
});
