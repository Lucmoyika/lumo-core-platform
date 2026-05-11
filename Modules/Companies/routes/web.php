<?php

use Illuminate\Support\Facades\Route;
use Modules\Companies\Http\Controllers\CompaniesController;

Route::prefix('companies')->as('companies.')->group(function () {
    Route::get('/', [CompaniesController::class, 'index'])->name('home');
});
