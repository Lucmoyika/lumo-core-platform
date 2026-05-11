<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;

// Locale switcher
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

// Offline fallback
Route::get('/offline', function () {
    return view('offline');
})->name('offline');

// Default redirect to home
Route::get('/', function () {
    return redirect()->route('core.home');
});
