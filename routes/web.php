<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BovinsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\MedsController;
use App\Http\Controllers\VisitesController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
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
    Route::resource('meds', MedsController::class);
    Route::post('meds/{meds}/deduct', [MedsController::class, 'deduct'])->name('meds.deduct');

    // Visites (Vet Visits) routes
    Route::resource('visites', VisitesController::class);
});

require __DIR__.'/auth.php';
