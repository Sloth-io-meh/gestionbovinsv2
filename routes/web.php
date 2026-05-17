<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BovinsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\MedsController;
use App\Http\Controllers\VisitesController;
use App\Http\Controllers\EtablesController;
use App\Http\Controllers\VendeursController;
use App\Http\Controllers\VetosController;
use App\Http\Controllers\TansporteursController;
use App\Http\Controllers\VehiculesController;
use App\Http\Controllers\QuarantainesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'throttle:120,1'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bovins (Cattle) routes
    Route::resource('bovins', BovinsController::class);
    Route::post('bovins/{bovin}/mark-sold', [BovinsController::class, 'markSold'])->name('bovins.mark-sold');
    Route::post('bovins/{bovin}/mark-dead', [BovinsController::class, 'markDead'])->name('bovins.mark-dead');
    Route::post('bovins/{bovin}/update-weight', [BovinsController::class, 'updateWeight'])->name('bovins.update-weight');

    // Stock routes
    Route::resource('stock', StockController::class);
    Route::post('stock/{stock}/deduct', [StockController::class, 'deduct'])->name('stock.deduct');

    // Meds routes
    Route::resource('meds', MedsController::class)->parameters(['meds' => 'meds']);
    Route::post('meds/{meds}/deduct', [MedsController::class, 'deduct'])->name('meds.deduct');

    // Visites (Vet Visits) routes
    Route::resource('visites', VisitesController::class);

    // Supporting Resources
    Route::resource('etables', EtablesController::class);
    Route::resource('vendeurs', VendeursController::class);
    Route::resource('vetos', VetosController::class);
    Route::resource('tansporteurs', TansporteursController::class);
    Route::resource('vehicules', VehiculesController::class);
    Route::resource('quarantaines', QuarantainesController::class);

    // Admin-only
    Route::resource('users', UsersController::class);
    Route::get('users/{user}/password', [UsersController::class, 'editPassword'])->name('users.edit-password');
    Route::patch('users/{user}/password', [UsersController::class, 'updatePassword'])->name('users.update-password');
    Route::resource('logs', ActivityLogController::class)->only(['index', 'show']);
});

require __DIR__.'/auth.php';
