<?php

namespace Domain\Animes\Actions;

use Carbon\Carbon;
use DateTime;

class HandleAnimesThatWillBeBroadcastInTimeRangeAction
{
    public function __construct(private QueryAnimeByBroadcastTimeRangeAction $queryAnimeByBroadcastTimeRangeAction) {}

    public function run(DateTime $beginning, DateTime $end, callable $callback): void
    {
        $animes = $this->queryAnimeByBroadcastTimeRangeAction->run($beginning, $end);

        if (!$animes) {
            return;
        }

        $animes->each(function ($anime) use ($callback) {
            $broadcastTime = Carbon::createFromFormat('H:i:s', $anime->broadcast->time)->timezone('Asia/Tokyo');
            $timeLeftToBeTransmitted = now()->timezone('Asia/Tokyo')->diffInSeconds($broadcastTime);

            $callback($anime, $timeLeftToBeTransmitted);
        });
    }
}
