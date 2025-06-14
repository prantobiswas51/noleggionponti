<?php 

// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Esp32Device;

Route::get('/device-status/{identifier}', function ($identifier) {
    $device = Esp32Device::where('identifier', $identifier)->first();

    if (!$device) {
        return response()->json(['error' => 'Device not found'], 404);
    }

    $active = $device->session_expires_at && now()->lt($device->session_expires_at);

    return response()->json(['has_enough' => $active]);
});
