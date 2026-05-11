<?php

use Illuminate\Support\Facades\Route;
use Modules\University\Http\Controllers\UniversityController;

Route::prefix('university')->as('university.')->group(function () {
    Route::get('/', [UniversityController::class, 'index'])->name('home');
});
