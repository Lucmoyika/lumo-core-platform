<?php

use Illuminate\Support\Facades\Route;
use Modules\Communication\Http\Controllers\CommunicationController;

Route::prefix('communication')->as('communication.')->group(function () {
    Route::get('/', [CommunicationController::class, 'index'])->name('home');
});
