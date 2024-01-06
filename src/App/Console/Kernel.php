<?php

namespace App\Console;

use App\Jobs\ScheduleAnimeQueriesThatWillBeBroadcastTodayJob;
use App\Jobs\SearchForAnimesAiringOnTheDaysOfTheWeekJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Interfaces\Console\Commands\NotifyMembers;
use Interfaces\Console\Commands\RegisterAnimeThatAreAiring;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        RegisterAnimeThatAreAiring::class,
        NotifyMembers::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(SearchForAnimesAiringOnTheDaysOfTheWeekJob::class)
            ->dailyAt('01:00')
            ->timezone('Asia/Tokyo');

        $schedule->job(ScheduleAnimeQueriesThatWillBeBroadcastTodayJob::class)
            ->dailyAt('00:00')
            ->timezone('Asia/Tokyo');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
