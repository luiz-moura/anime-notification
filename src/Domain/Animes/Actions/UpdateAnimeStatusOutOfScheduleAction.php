<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\AnimeRepository;
use Infra\Integration\AnimeApi\DTOs\Collections\AnimesCollection;

class UpdateAnimeStatusOutOfScheduleAction
{
    public function __construct(private AnimeRepository $animeRepository) {}

    public function run(AnimesCollection $apiAnimes): void
    {
        $this->animeRepository->updateAiringStatusByMalIds($apiAnimes->pluck('mal_id')->all(), status: false);
    }
}
