<?php

namespace App\Jobs;

use Domain\Animes\Actions\DefineTimeForQueryAnimeThatWillBeBroadcastTodayAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ScheduleAnimeQueriesThatWillBeBroadcastTodayJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct() {}

    public function handle(DefineTimeForQueryAnimeThatWillBeBroadcastTodayAction $action): void
    {
        $action->run(fn () => ScheduleNotificationsForMembersJob::dispatch());
    }
}
