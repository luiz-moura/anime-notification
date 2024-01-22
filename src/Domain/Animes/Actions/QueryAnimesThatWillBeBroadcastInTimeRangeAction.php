<?php

namespace Domain\Animes\Actions;

use Carbon\Carbon;
use DateTime;
use Domain\Animes\Contracts\AnimeRepository;

class QueryAnimesThatWillBeBroadcastInTimeRangeAction
{
    public function __construct(private AnimeRepository $animeRepository)
    {
    }

    public function run(DateTime $beginning, DateTime $end, callable $callback): void
    {
        $animes = $this->animeRepository->queryByBroadcsatTimeRange($beginning, $end);

        if ($animes->isEmpty()) {
            return;
        }

        $animes->each(function ($anime) use ($callback) {
            $broadcastTime = Carbon::createFromFormat('H:i:s', $anime->broadcast->time);
            $timeLeftToBeTransmitted = now()->diffInSeconds($broadcastTime);

            $callback($anime, $timeLeftToBeTransmitted);
        });
    }
}
