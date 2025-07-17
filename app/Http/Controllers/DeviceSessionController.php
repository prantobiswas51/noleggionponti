<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Esp32Device;
use App\Models\Esp32Session;
use App\Models\Policy;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeviceSessionController extends Controller
{
    public function show(Request $request)
    {
        $device = Esp32Device::where('identifier', $request->device)->firstOrFail();

        $session = Esp32Session::where('esp32_device_id', $device->id)
            ->where('user_id', Auth::id())
            ->where('active', true)
            ->first();

        $isActive = Esp32Session::where('esp32_device_id',  $device->id)
            ->where('active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', Carbon::now());
            })->exists();


        return view('session', [
            'device' => $device,
            'started_at' => $session?->started_at,
            'isActive' => $isActive,
        ]);
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
            $now = now();

            // End any active session for this device
            Esp32Session::where('esp32_device_id', $device->id)
                ->where('active', true)
                ->update(['active' => false]);

            // Atomically deduct balance
            $user->decrement('balance', $SESSION_COST);

            // Start new session
            Esp32Session::create([
                'user_id' => Auth::id(),
                'esp32_device_id' => $device->id,
                'started_at'       => $now,
                'last_deducted_at' => $now,
                'active'           => true,
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

        if (!$device) {
            return redirect()->back()->with('error', 'Device not found.');
        }

        $updated = Esp32Session::where('esp32_device_id', $device->id)
            ->where('active', true)
            ->update([
                'active' => false,
                'expires_at' => now(), // Optional: mark when it was stopped
            ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Session stopped.');
        }

        return redirect()->back()->with('info', 'No active session found.');
    }

    public function accept_contract(Request $request)
    {
        $userIp = $request->ip();
        $user = Auth::user();
        $user->acceptance_ip = $userIp;
        $user->acceptance_time = now();

        // Get the latest policy and term versions
        $current_policy_version = Policy::latest()->first();  // Retrieve the most recent policy version
        $current_term_version = Term::latest()->first();  // Retrieve the most recent term version

        // Assign the latest policy and term versions to the user
        $user->policy_version = $current_policy_version ? $current_policy_version->version : null;
        $user->terms_version = $current_term_version ? $current_term_version->version : null; // Assuming the 'version' column exists

        if ($request->marketing == "true") {
            $user->marketing = true;
        } else {
            $user->marketing = false;
        }

        $user->save();

        return redirect()->back()->with('error', 'Contract accepted!');
    }
}
