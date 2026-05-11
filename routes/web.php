<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

// Locale switcher
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

// Unified auth entry points
Route::redirect('/login', '/identity/login')->name('login');
Route::redirect('/register', '/identity/register')->name('register');
Route::redirect('/forgot-password', '/identity/forgot-password')->name('password.request');

// Offline fallback
Route::get('/offline', function () {
    return view('offline');
})->name('offline');

// Default redirect to home
Route::get('/', function () {
    return redirect()->route('core.home');
});
