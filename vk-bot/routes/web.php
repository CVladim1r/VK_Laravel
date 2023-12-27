<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\DashboardController;

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

    Route::resource('contests', ContestController::class);

    Route::resource('publics', PublicController::class);
    

});
Route::get('/publics/{public}/edit', [PublicController::class, 'edit'])->name('publics.edit');
Route::delete('/publics/{public}', [PublicController::class, 'destroy'])->name('publics.destroy');
Route::get('/contests/{contest}/edit', [ContestController::class, 'edit'])->name('contests.edit');
Route::delete('/contests/{contest}', [ContestController::class, 'destroy'])->name('contests.destroy');
Route::get('/contests', [ContestController::class, 'index'])->name('contests.index');
Route::get('/contests/create', [ContestController::class, 'create'])->name('contests.create');
