<?php

namespace App\Http\Controllers;

use App\Models\Esp32Device;
use App\Models\Esp32Session;
use Illuminate\Http\Request;

class DeviceSessionController extends Controller
{
    public function show(Request $request)
    {
        $device = Esp32Device::where('identifier', $request->device)->firstOrFail();
        return view('session', compact('device'));
    }

    public function start(Request $request)
    {
        $device = Esp32Device::where('identifier', $request->device)->firstOrFail();

        // End previous active sessions
        Esp32Session::where('esp32_device_id', $device->id)
            ->where('active', true)
            ->update(['active' => false]);

        Esp32Session::create([
            'esp32_device_id' => $device->id,
            'started_at' => now(),
            'expires_at' => now()->addMinutes(30),
            'active' => true,
        ]);

        return redirect()->back()->with('success', 'Session started for 30 minutes!');
    }
}
