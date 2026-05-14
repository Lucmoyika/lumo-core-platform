<?php

use Illuminate\Support\Facades\Route;
use Modules\School\Http\Controllers\Erp\ClassController;
use Modules\School\Http\Controllers\Erp\StudentController;
use Modules\School\Http\Controllers\Erp\TeacherController;
use Modules\School\Http\Controllers\Erp\WorkflowController;
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
        Route::get('/erp/dashboard/admin', [WorkflowController::class, 'adminDashboard'])->name('erp.dashboard.admin');
        Route::get('/erp/dashboard/teacher', [WorkflowController::class, 'teacherDashboard'])->name('erp.dashboard.teacher');
        Route::get('/erp/dashboard/student', [WorkflowController::class, 'studentDashboard'])->name('erp.dashboard.student');
        Route::get('/erp/dashboard/parent', [WorkflowController::class, 'parentDashboard'])->name('erp.dashboard.parent');
        Route::get('/erp/timetable', [WorkflowController::class, 'timetable'])->name('erp.timetable');
        Route::get('/erp/report-cards/{enrollmentId}', [WorkflowController::class, 'reportCard'])->name('erp.report-cards.show');
        Route::get('/erp/report-cards/{enrollmentId}/pdf', [WorkflowController::class, 'reportCardPdf'])->name('erp.report-cards.pdf');
        Route::get('/erp/fees', [WorkflowController::class, 'fees'])->name('erp.fees');
        Route::post('/erp/fees/generate-invoices', [WorkflowController::class, 'generateInvoices'])->name('erp.fees.generate-invoices');
        Route::post('/erp/promotion', [WorkflowController::class, 'promote'])->name('erp.promote');
    });
});
