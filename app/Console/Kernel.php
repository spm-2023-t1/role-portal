<?php

namespace App\Console;

use App\Models\Job;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $jobs = Job::where('deadline', '<=', \Carbon\Carbon::now())->get();

            foreach($jobs as $job)
            {
                //Update each application as you want to
                $job->listing_status = 'closed';
                $job->save();
            }
        })->everyMinute();

        $schedule->call(function () {
            $jobs = Job::where('role_listing_open', '<=', \Carbon\Carbon::now())->get();

            foreach($jobs as $job)
            {
                //Update each application as you want to
                $job->is_released = 'true';
                $job->save();
            }
        })->everyMinute();
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
