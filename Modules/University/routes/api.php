<?php

use Illuminate\Support\Facades\Route;
use Modules\University\Http\Controllers\UniversityController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('universities', UniversityController::class)->names('university');
});
