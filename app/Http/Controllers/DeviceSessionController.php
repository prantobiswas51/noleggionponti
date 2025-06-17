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
        $request->validate([
            'device' => 'required|string',
        ]);

        $device = Esp32Device::where('identifier', $request->device)->first();
        if (!$device) {
            return redirect()->back()->with('error', 'Device not found.');
        }

        $user = Auth::user();
        $SESSION_COST = 7;

        if ($user->balance < 14) {
            return redirect()->back()->with('error', 'You need at least 14 EURO to start. But it will cost you 7 per 30 minutes');
        }

        DB::transaction(function () use ($device, $user, $SESSION_COST) {
            // End any previous session
            Esp32Session::where('esp32_device_id', $device->id)
                ->where('active', true)
                ->update(['active' => false]);

            // Deduct first €7
            $user->balance -= $SESSION_COST;
            $user->save();

            // Start session without end time
            Esp32Session::create([
                'esp32_device_id' => $device->id,
                'started_at' => now(),
                'last_deducted_at' => now(),
                'active' => true,
            ]);
        });

        return redirect()->back()->with([
            'success' => 'Session started. You will be charged €7 every 30 minutes.',
            'started_at' => now()->toIso8601String(),
        ]);
    }


    public function stop(Request $request)
    {
        $request->validate([
            'device' => 'required|string',
        ]);

        $device = Esp32Device::where('identifier', $request->device)->first();

        if ($device) {
            Esp32Session::where('esp32_device_id', $device->id)
                ->where('active', true)
                ->update(['active' => false]);
        }

        return redirect()->back()->with('success', 'Session stopped.');
    }
}
