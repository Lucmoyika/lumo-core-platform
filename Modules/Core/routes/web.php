<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\CoreController;

Route::group(['prefix' => 'core', 'as' => 'core.'], function () {
    Route::get('/', [CoreController::class, 'home'])->name('home');
    Route::get('/features', [CoreController::class, 'features'])->name('features');
    Route::get('/pricing', [CoreController::class, 'pricing'])->name('pricing');
    Route::get('/contact', [CoreController::class, 'contact'])->name('contact');
    Route::post('/contact', [CoreController::class, 'sendContact'])->name('contact.send');
});
