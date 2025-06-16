<?php

namespace App\Console\Commands;

use App\Models\Esp32Session;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeductEsp32SessionBalance extends Command
{
    // protected $signature = 'app:deduct-esp32-session-balance';
    protected $signature = 'esp32:deduct';
    protected $description = 'Command description';

    public function handle()
    {
        $now = now();

        $sessions = Esp32Session::where('active', true)
            ->where('last_deducted_at', '<=', $now->subMinutes(30))
            ->get();

        foreach ($sessions as $session) {
            $user = $session->device->user; // Make sure you have a relation
            if ($user->balance >= 7) {
                DB::transaction(function () use ($user, $session) {
                    $user->balance -= 7;
                    $user->save();
                    $session->last_deducted_at = now();
                    $session->save();
                });
            } else {
                $session->active = false;
                $session->save();
            }
        }

        $this->info("ESP32 session deductions processed.");
    }
}
