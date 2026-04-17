<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\CustomerManager;
use App\Livewire\DocumentProcessor;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('customers', CustomerManager::class)->name('customers');
    Route::get('process-document', DocumentProcessor::class)->name('process.document');
});

require __DIR__.'/auth.php';

