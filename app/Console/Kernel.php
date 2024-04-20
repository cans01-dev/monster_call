<?php

namespace App\Console;

use App\Models\Reservation;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $reservations = Reservation::where('date', date('Y-m-d'))->get();
            
            foreach ($reservations as $reservation) {
                $reservation->confirm();
            }

            Log::info('{count}件の予約を確定済にしました', ['count' => $reservations->count()]);
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
