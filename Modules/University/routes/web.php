<?php

use Illuminate\Support\Facades\Route;
use Modules\University\Http\Controllers\UniversityController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('universities', UniversityController::class)->names('university');
});
