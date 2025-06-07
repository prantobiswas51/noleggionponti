<?php

use App\Http\Controllers\Esp32Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // handle esp32 no 1
    Route::get('/start/esp32_id_123', [Esp32Controller::class, 'esp32_1'])->name('esp32_1_controller');
    Route::get('/start/esp32_id_223', [Esp32Controller::class, 'esp32_2'])->name('esp32_2_controller');
});

require __DIR__.'/auth.php';
