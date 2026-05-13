<?php

use Illuminate\Support\Facades\Route;
use Modules\School\Http\Controllers\Erp\ClassController;
use Modules\School\Http\Controllers\Erp\StudentController;
use Modules\School\Http\Controllers\Erp\TeacherController;
use Modules\School\Http\Controllers\SchoolController;
use Modules\School\Http\Middleware\EnsureSchoolContext;

Route::middleware(EnsureSchoolContext::class)->prefix('school')->as('school.')->group(function () {
    Route::get('/', [SchoolController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/portal', [SchoolController::class, 'portal'])->name('portal');

        // ERP main dashboard
        Route::get('/erp', [SchoolController::class, 'erp'])->name('erp');

        // ERP sub-modules
        Route::get('/erp/students',        [StudentController::class, 'index'])->name('erp.students');
        Route::get('/erp/students/{id}',   [StudentController::class, 'show'])->name('erp.students.show');
        Route::get('/erp/teachers',        [TeacherController::class, 'index'])->name('erp.teachers');
        Route::get('/erp/classes',         [ClassController::class, 'index'])->name('erp.classes');
    });
});
