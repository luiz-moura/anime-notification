<?php

namespace Domain\Animes\UseCases;

use Domain\Animes\Actions\CreateAnimeGenresAction;
use Domain\Animes\Actions\StoreAnimeImageAction;
use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\AnimeTitleRepository;
use Domain\Animes\Contracts\BroadcastRepository;
use Domain\Animes\Contracts\GenreRepository;
use Domain\Animes\DTOs\AnimeData;
use Domain\Animes\DTOs\TitleData;
use Domain\Shared\Medias\Contracts\MediaRepository;
use Illuminate\Support\Facades\DB;
use Infra\Integration\AnimeApi\DTOs\AnimeData as ApiAnimeData;
use Infra\Storage\Services\StoreMediaService;

class CreateAnimeUseCase
{
    public function __construct(
        private GenreRepository $genreRepository,
        private AnimeRepository $animeRepository,
        private MediaRepository $mediaRepository,
        private BroadcastRepository $broadcastRepository,
        private AnimeTitleRepository $animeTitleRepository,
        private StoreMediaService $storeMediaService,
        private CreateAnimeGenresAction $createAnimeGenresAction,
        private StoreAnimeImageAction $storeAnimeImageAction,
    ) {
    }

    public function run(ApiAnimeData $apiAnime)
    {
        DB::transaction(function () use ($apiAnime) {
            $this->createAnimeGenresAction->run($apiAnime);
            $this->createAnime($apiAnime);
        });
    }

    private function createAnime(ApiAnimeData $apiAnime): void
    {
        $animeRaw = AnimeData::fromApi($apiAnime->toArray());
        $registeredAnime = $this->animeRepository->create($animeRaw);

        $this->broadcastRepository->create($registeredAnime->id, $animeRaw->broadcast);
        $this->createTitles($registeredAnime->id, $apiAnime);
        $this->createAndAttachImage($registeredAnime->id, $apiAnime);
        $this->attachGenres($registeredAnime->id, $apiAnime);
    }

    private function createTitles(int $animeId, ApiAnimeData $apiAnime): void
    {
        $apiAnime->titles->each(function (TitleData $title) use ($animeId) {
            $this->animeTitleRepository->create($animeId, $title);
        });
    }

    private function createAndAttachImage(int $animeId, ApiAnimeData $apiAnime): void
    {
        $image = $this->storeAnimeImageAction->run($apiAnime);
        $this->animeRepository->attachImages($animeId, $image->id);
    }

    private function attachGenres(int $animeId, ApiAnimeData $apiAnime): void
    {
        $apiGenres = collect([
            $apiAnime->genres,
            $apiAnime->explicit_genres,
            $apiAnime->themes,
            $apiAnime->demographics,
        ]);

        $malIds = $this->getMalIds($apiGenres->collapse());
        $genres = $this->genreRepository->queryByMalIds($malIds);

        $genreIds = collect($genres)->pluck('id')->values()->all();
        $this->animeRepository->attachGenres($animeId, $genreIds);
    }

    private function getMalIds($animes): array
    {
        return collect($animes)->pluck('mal_id')->values()->all() ?? [];
    }
}
