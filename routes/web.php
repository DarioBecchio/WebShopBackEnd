<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\EmailController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ReturnRequestController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Dashboard\ContactController as DashboardContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ShadeController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\CertificationController;

Route::get('/', function () {
    return view('welcome');
});

// ── Dashboard admin ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'isAdmin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('home');

    Route::resource('posts', PostController::class);

    Route::resource('contacts', DashboardContactController::class)
        ->only(['index', 'show', 'update']);

    Route::get('users', [\App\Http\Controllers\Dashboard\UserController::class, 'index'])
        ->name('users.index');

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

// ── Cosmetici ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('brands',         BrandController::class);
    Route::resource('categories',     CategoryController::class);
    Route::resource('products',       ProductController::class);
    Route::resource('variants',       ProductVariantController::class);
    Route::resource('ingredients',    IngredientController::class);
    Route::resource('shades',         ShadeController::class);
    Route::resource('claims',         ClaimController::class);
    Route::resource('certifications', CertificationController::class);
});

// ── Profilo utente frontend ───────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/contatti', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contatti', [ContactController::class, 'store'])->name('contact.store');
});

require __DIR__.'/auth.php';