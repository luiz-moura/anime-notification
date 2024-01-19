<?php

namespace App\Console;

use App\Jobs\ImportAnimesFromApiJob;
use App\Jobs\ScheduleAnimeQueriesThatWillBeBroadcastTodayJob;
use App\Jobs\SearchForAnimeBroadcastByDayOfTheWeekJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Interfaces\Console\Commands\ImportAnimes;
use Interfaces\Console\Commands\NotifyMembers;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ImportAnimes::class,
        NotifyMembers::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(SearchForAnimeBroadcastByDayOfTheWeekJob::class)
            ->dailyAt('01:00');

        $schedule->job(ScheduleAnimeQueriesThatWillBeBroadcastTodayJob::class)
            ->dailyAt('00:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
