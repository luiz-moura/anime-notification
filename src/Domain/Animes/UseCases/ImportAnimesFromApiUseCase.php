<?php

namespace Domain\Animes\UseCases;

use Domain\Animes\Contracts\AnimeRepository;
use Infra\Abstracts\Contracts\Collection;
use Infra\Integration\AnimeApi\Contracts\AnimeApiService;
use Infra\Integration\AnimeApi\DTOs\AnimeData as ApiAnimeData;

class ImportAnimesFromApiUseCase
{
    public function __construct(
        private AnimeApiService $animeApiService,
        private AnimeRepository $animeRepository,
    ) {}

    public function run(string $day, callable $registerAnime, callable $updateAnimeStatusOutOfSchedule): void
    {
        $apiAnimes = $this->animeApiService->getSchedulesByDay($day);

        $animesAlreadyRegistered = $this->animeRepository->queryByMalIds($this->getMalIds($apiAnimes));
        $unregisteredAnimes = $apiAnimes->whereNotIn('mal_id', $this->getMalIds($animesAlreadyRegistered));

        $animesThatLeftSchedule = $this->animeRepository->queryAiringByDayExceptMalIds("{$day}s", $this->getMalIds($apiAnimes));

        $unregisteredAnimes->each(fn(ApiAnimeData $anime) => $registerAnime($anime));

        if ($animesThatLeftSchedule->isNotEmpty()) {
            $updateAnimeStatusOutOfSchedule($animesThatLeftSchedule);
        }
    }

    private function getMalIds(?Collection $animes): array
    {
        return collect($animes)->pluck('mal_id')->values()->all() ?? [];
    }
}
