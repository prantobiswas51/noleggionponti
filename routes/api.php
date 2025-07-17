<?php

use Carbon\Carbon;
use App\Models\Esp32Device;
use App\Models\Esp32Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/device-status/{identifier}', function ($identifier) {
    $device = Esp32Device::where('identifier', $identifier)->first();

    if (!$device) {
        return response()->json(['error' => 'Device not found'], 404);
    }

    $activeSession = Esp32Session::where('esp32_device_id', $device->id)
        ->where('active', true)
        ->first();

    if ($activeSession) {
        $now = Carbon::now();
        $lastDeducted = Carbon::parse($activeSession->last_deducted_at);

        if ($lastDeducted->diffInMinutes($now) >= 1) {
            $user = $activeSession->user; // assuming you have relation: Esp32Session belongsTo User

            if ($user->balance >= 7) {
                DB::transaction(function () use ($user, $activeSession, $now) {
                    $user->balance -= 7;
                    $user->save();

                    $activeSession->last_deducted_at = $now;
                    $activeSession->save();
                });
            } else {
                $activeSession->active = false;
                $activeSession->save();
            }
        }
    }

    return response()->json([
        'has_enough' => !!$activeSession,
        'last_deducted_at' => optional($activeSession)->last_deducted_at,
    ]);
});