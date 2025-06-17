<?php

namespace App\Console\Commands;

use App\Models\Esp32Session;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeductSessionBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deduct-session-balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deducts session balance for active ESP32 sessions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $SESSION_COST = 7;
        $INTERVAL_MINUTES = 10;
        $now = now();

        $sessions = Esp32Session::where('active', true)->get();

        foreach ($sessions as $session) {
            $user = $session->user;
            $last = $session->last_deducted_at;

            if (!$last || $now->diffInMinutes($last) >= $INTERVAL_MINUTES) {
                if ($user->balance >= $SESSION_COST) {
                    $user->decrement('balance', $SESSION_COST);
                    $session->update(['last_deducted_at' => $now]);
                    Log::info("Deducted $SESSION_COST from user ID {$user->id} (session ID {$session->id})");
                } else {
                    $session->update([
                        'active' => false,
                        'expires_at' => $now,
                    ]);
                    Log::info("Ended session ID {$session->id} due to insufficient balance.");
                }
            }
        }

        $this->info('Session balances processed.');
    }
}
