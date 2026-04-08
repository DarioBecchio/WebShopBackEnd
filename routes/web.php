<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard admin (protetta da isAdmin)
Route::middleware(['auth', 'verified', 'isAdmin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('home');
    Route::resource('posts', PostController::class);
    Route::get('users', [\App\Http\Controllers\Dashboard\UserController::class, 'index'])->name('users.index');
});

// Profilo utente frontend (per i clienti)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [FrontendProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [FrontendProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [FrontendProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';