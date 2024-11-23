<?php

namespace Domain\Animes\Actions;

use Carbon\Carbon;
use DateTime;
use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\DTOs\AnimeData;

class QueryAnimesThatWillBeBroadcastInTimeRangeAction
{
    public function __construct(private AnimeRepository $animeRepository)
    {
    }

    public function run(DateTime $beginning, DateTime $end, callable $callback): void
    {
        $animes = $this->animeRepository->queryByBroadcastTimeRange($beginning, $end);

        if ($animes->isEmpty()) {
            return;
        }

        $animes->each(function (AnimeData $anime) use ($callback): void {
            $broadcastTime = Carbon::createFromFormat('H:i:s', $anime->broadcast->time);
            $timeLeftToBeTransmitted = now()->diffInSeconds($broadcastTime);

            $callback($anime, $timeLeftToBeTransmitted);
        });
    }
}
