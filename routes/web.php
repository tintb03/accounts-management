<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Password Routes
Route::middleware(['auth'])->group(function () {
    // Create Password Route
    Route::get('/passwords/create', [PasswordController::class, 'create'])->name('passwords.create');

    // Other Password Routes (index, store, edit, update, destroy)
    Route::resource('passwords', PasswordController::class)->except(['show', 'index']);
});


require __DIR__.'/auth.php';
