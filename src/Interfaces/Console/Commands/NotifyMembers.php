<?php

namespace Interfaces\Console\Commands;

use App\Jobs\ScheduleAnimeQueriesThatWillBeBroadcastTodayJob;
use Illuminate\Console\Command;

class NotifyMembers extends Command
{
    protected $signature = 'app:notify-members';

    protected $description = 'Notifies members that the anime will be broadcast';

    public function handle(): void
    {
        ScheduleAnimeQueriesThatWillBeBroadcastTodayJob::dispatch();
    }
}
