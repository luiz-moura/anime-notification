<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\DTOs\Collections\AnimesCollection;

class UpdateAnimeStatusOutOfScheduleAction
{
    public function __construct(private AnimeRepository $animeRepository)
    {
    }

    public function run(AnimesCollection $animes): void
    {
        $this->animeRepository->updateAiringStatusByMalIds(
            malIds: collect($animes)->pluck('mal_id')->values()->all(),
            status: false
        );
    }
}
