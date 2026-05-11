<?php

use Illuminate\Support\Facades\Route;
use Modules\Logistics\Http\Controllers\LogisticsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('logistics', LogisticsController::class)->names('logistics');
});
