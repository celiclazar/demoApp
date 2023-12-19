<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\IncompleteInfoMail;
use App\Mail\CompleteInfoMail;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $clients = Client::all();
    
            foreach ($clients as $client) {
                if (!$client->hasCompleteInfo()) {
                    // Send email for incomplete information
                    Mail::to($client->email)->send(new IncompleteInfoMail($client));
                } else {
                    // Send email for complete information
                    Mail::to($client->email)->send(new CompleteInfoMail($client));
                }
            }
        })->everyMinute(); // Or adjust the frequency as needed
        // $schedule->command('inspire')->hourly();
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
