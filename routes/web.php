<?php

use App\Models\User;
use App\Models\Esp32Device;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\RouteRegistrar;
use App\Http\Controllers\Esp32Controller;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeviceSessionController;
use App\Models\Esp32Session;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/terms&conditions', function () {
    return view('terms_and_conditions');
})->name('terms');

Route::get('/privacy_policy', function () {
    return view('privacy_policy');
})->name('privacy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // handle esp32
    Route::get('/device-session', [DeviceSessionController::class, 'show'])->name('show_devices');
    Route::post('/device-session/start', [DeviceSessionController::class, 'start'])->name('start_devices');
    Route::post('/device-session/stop', [DeviceSessionController::class, 'stop'])->name('stop_devices');

    // Deposit using paypal
    Route::get('/deposit', function () {
        return view('deposit');
    })->name('deposit');

    Route::post('/deposit/paypal', [DepositController::class, 'payWithPaypal'])->name('paypal_deposit');
    Route::get('/deposit/paypal/status', [DepositController::class, 'getPaypalPaymentStatus'])->name('deposit_status');
});




require __DIR__ . '/auth.php';
