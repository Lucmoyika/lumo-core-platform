<?php

use Illuminate\Support\Facades\Route;
use Modules\Analytics\Http\Controllers\AnalyticsController;

Route::prefix('analytics')->as('analytics.')->group(function () {
    Route::get('/', [AnalyticsController::class, 'index'])->name('home');
});
