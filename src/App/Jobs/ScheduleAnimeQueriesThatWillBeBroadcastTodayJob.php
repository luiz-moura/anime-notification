<?php

namespace App\Jobs;

use Domain\Animes\Actions\DefineTimesToQueryAnimesByTimeInTheScheduleAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ScheduleAnimeQueriesThatWillBeBroadcastTodayJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 3;

    public function __construct()
    {
    }

    public function handle(DefineTimesToQueryAnimesByTimeInTheScheduleAction $action): void
    {
        $action->run(
            fn ($beginning, $end) => ScheduleNotificationsForMembersJob::dispatch($beginning, $end)->delay(now()->diffInSeconds($beginning))
        );
    }
}
