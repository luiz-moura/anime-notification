<?php

namespace App\Jobs;

use DateTime;
use Domain\Animes\Actions\QueryAnimesThatWillBeBroadcastInTimeRangeAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Queue\InteractsWithQueue;

class ScheduleNotificationsForMembersJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 3;

    public function __construct(private DateTime $beginning, private DateTime $end)
    {
    }

    public function handle(QueryAnimesThatWillBeBroadcastInTimeRangeAction $action): void
    {
        $action->run(
            $this->beginning,
            $this->end,
            fn ($anime, $timeLeftToBeTransmitted): PendingDispatch => NotifyMembersThatAnimeWillBeBroadcastJob::dispatch($anime)->delay($timeLeftToBeTransmitted)
        );
    }
}
