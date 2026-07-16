<?php

use App\Http\Controllers\PodatakController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IspravaController;
use App\Http\Controllers\DokumentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dokumenti', [DokumentController::class, 'index'])->name('dokumenti');
    Route::get('/dokumenti/uredi', [DokumentController::class, 'editLatest'])->name('dokumenti.edit');
    Route::get('/dokumenti/novo', [DokumentController::class, 'create'])->name('dokumenti.create');
    Route::post('/dokumenti', [DokumentController::class, 'store'])->name('dokumenti.store');
    Route::get('/dokumenti/{document}/pregled', [DokumentController::class, 'preview'])->name('dokumenti.preview');
    Route::get('/dokumenti/{document}/uredi', [DokumentController::class, 'edit'])->name('dokumenti.documents.edit');
    Route::put('/dokumenti/{document}', [DokumentController::class, 'update'])->name('dokumenti.update');
    Route::delete('/dokumenti/{document}', [DokumentController::class, 'destroy'])->name('dokumenti.destroy');
    Route::get('/isprave/create', [IspravaController::class, 'create'])->name('isprave.create');
    Route::post('/isprave', [IspravaController::class, 'store'])->name('isprave.store');
    Route::get('/isprave', [IspravaController::class, 'index'])->name('isprave');
    Route::get('/isprave/{isprava}', [IspravaController::class, 'show'])->name('isprave.show');
    Route::get('/isprave/{isprava}/uredi', [IspravaController::class, 'edit'])->name('isprave.edit');
    Route::put('/isprave/{isprava}', [IspravaController::class, 'update'])->name('isprave.update');
    Route::get('/podaci', [PodatakController::class, 'index'])->name('podaci');
    Route::post('/podaci', [PodatakController::class, 'store'])->name('podaci.store');
    Route::put('/podaci/{podatak}', [PodatakController::class, 'update'])->name('podaci.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
