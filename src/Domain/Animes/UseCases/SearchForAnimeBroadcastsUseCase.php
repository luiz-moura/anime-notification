<?php

namespace Domain\Animes\UseCases;

use Domain\Animes\Contracts\AnimeRepository;
use Infra\Abstracts\Collection;
use Infra\Integration\AnimeApi\Contracts\AnimeApiService;
use Infra\Integration\AnimeApi\DTOs\Collections\AnimesCollection;

class SearchForAnimeBroadcastsUseCase
{
    public function __construct(
        private AnimeApiService $animeApiService,
        private AnimeRepository $animeRepository
    ) {}

    public function run(string $day): AnimesCollection
    {
        $animesAiring = $this->animeApiService->getSchedulesByDay($day);
        $malIdAlreadyRegistered = $this->animeRepository->queryByMalIds($this->getMalIds($animesAiring));

        return $animesAiring->whereNotIn('mal_id', $this->getMalIds($malIdAlreadyRegistered));
    }

    private function getMalIds(?Collection $animes): array
    {
        return collect($animes)->pluck('mal_id')->values()->all() ?? [];
    }
}
