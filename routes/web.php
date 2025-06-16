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
    Route::get('/deposit/payeer/success', [DepositController::class, 'success'])->name('payeer_success');
});


Route::get('/device-status/{identifier}', function ($identifier) {
    $device = Esp32Device::where('identifier', $identifier)->first();

    if (!$device) {
        return response()->json(['error' => 'Device not found'], 404);
    }

    // Get the latest session for this device
    $session = Esp32Session::where('esp32_device_id', $device->id)
        ->latest('expires_at')
        ->first();

    $active = $session && $session->expires_at && now()->lt($session->expires_at);

    return response()->json([
        'device_time' => $session?->expires_at,
        'now' => now(),
        'has_enough' => $active,
    ]);
});

require __DIR__ . '/auth.php';
