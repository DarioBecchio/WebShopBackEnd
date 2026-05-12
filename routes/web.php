<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\EmailController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ReturnRequestController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Dashboard\ContactController as DashboardContactController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard admin (solo auth + isAdmin, senza verified)
Route::middleware(['auth', 'isAdmin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('home');

    Route::resource('posts', PostController::class);

    Route::resource('contacts', DashboardContactController::class)
    ->only(['index', 'show', 'update']);

    Route::get('users', [\App\Http\Controllers\Dashboard\UserController::class, 'index'])
        ->name('users.index');

    // Email management dentro la dashboard
    Route::prefix('email')->name('email.')->group(function () {
        Route::get('/',            [EmailController::class, 'index'])          ->name('index');
        Route::get('/newsletter',  [EmailController::class, 'newsletter'])     ->name('newsletter');
        Route::post('/newsletter', [EmailController::class, 'sendNewsletter']) ->name('newsletter.send');
        Route::get('/logs',        [EmailController::class, 'logs'])           ->name('logs');
        Route::get('/templates',   [EmailController::class, 'templates'])      ->name('templates');
    });

    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);

    Route::resource('returns', ReturnRequestController::class)
    ->only(['index', 'show', 'update'])
    ->parameters(['returns' => 'returnRequest']);
});

// Profilo utente frontend (per i clienti, con verified)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/contatti', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contatti', [ContactController::class, 'store'])->name('contact.store');
});

require __DIR__.'/auth.php';