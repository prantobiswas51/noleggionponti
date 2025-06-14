<?php

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\RouteRegistrar;
use App\Http\Controllers\Esp32Controller;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeviceSessionController;

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

    // handle esp32
    Route::get('/device-session', [DeviceSessionController::class, 'show']);
    Route::post('/device-session/start', [DeviceSessionController::class, 'start']);

    // Deposit using paypal
    Route::get('/deposit', function () {
        return view('deposit');
    })->name('deposit');

    Route::post('/deposit/paypal', [DepositController::class, 'payWithPaypal'])->name('paypal_deposit');
    Route::get('/deposit/paypal/status', [DepositController::class, 'getPaypalPaymentStatus'])->name('deposit_status');
    Route::get('/deposit/payeer/success', [DepositController::class, 'success'])->name('payeer_success');
});


require __DIR__ . '/auth.php';
