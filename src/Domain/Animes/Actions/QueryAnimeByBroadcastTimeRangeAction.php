<?php

namespace Domain\Animes\Actions;

use DateTime;
use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\DTOs\Collections\AnimesCollection;

class QueryAnimeByBroadcastTimeRangeAction
{
    public function __construct(private AnimeRepository $animeRepository) {}

    public function run(DateTime $beginning, DateTime $end): ?AnimesCollection
    {
        return $this->animeRepository->queryByBroadcsatTimeRange($beginning, $end);
    }
}
