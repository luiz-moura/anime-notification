<?php

namespace App\Jobs;

use DateTime;
use Domain\Animes\Actions\HandleAnimesThatWillBeBroadcastInTimeRangeAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ScheduleNotificationsForMembersJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private DateTime $beginning, private DateTime $end) {}

    public function handle(HandleAnimesThatWillBeBroadcastInTimeRangeAction $handleAnimesThatWillBeBroadcastInTimeRangeAction): void
    {
        $handleAnimesThatWillBeBroadcastInTimeRangeAction->run(
            $this->beginning,
            $this->end,
            function ($anime, $timeLeftToBeTransmitted) {
                NotifyMembersThatAnimeWillBeBroadcastJob::dispatch($anime)->delay($timeLeftToBeTransmitted);
            }
        );
    }
}
