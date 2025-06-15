<?php

namespace App\Http\Controllers;

use App\Models\Esp32Device;
use App\Models\Esp32Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeviceSessionController extends Controller
{
    public function show(Request $request)
    {
        $device = Esp32Device::where('identifier', $request->device)->firstOrFail();
        return view('session', compact('device'));
    }

    public function start(Request $request)
    {
        if(Auth::user()->balance < 14){
            return redirect()->back()->with('error', 'You need to have at least 14 EURO!');
        }

        // Constants for amount and session duration
        $SESSION_COST = 7;
        $SESSION_DURATION_MINUTES = 2;

        // Validate input
        $request->validate([
            'device' => 'required|string',
        ]);

        // Find device
        $device = Esp32Device::where('identifier', $request->device)->first();
        if (!$device) {
            return redirect()->back()->with('error', 'Device not found.');
        }

        $user = Auth::user();

        if ($user->balance < $SESSION_COST) {
            return redirect()->back()->with('error', 'Insufficient balance.');
        }

        DB::transaction(function () use ($device, $user, $SESSION_COST, $SESSION_DURATION_MINUTES) {
            // Deactivate previous active sessions for this device
            Esp32Session::where('esp32_device_id', $device->id)
                ->where('active', true)
                ->update(['active' => false]);

            // Deduct balance and save
            $user->balance -= $SESSION_COST;
            $user->save();

            // Create new session
            Esp32Session::create([
                'esp32_device_id' => $device->id,
                'started_at' => now(),
                'expires_at' => now()->addMinutes($SESSION_DURATION_MINUTES),
                'active' => true,
            ]);
        });

        return redirect()->back()->with('success', "Session started for {$SESSION_DURATION_MINUTES} minutes!");
    }
}
