<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\GenreRepository;
use Domain\Animes\DTOs\GenreData;
use Domain\Animes\Enums\GenreTypesEnum;
use Illuminate\Support\Str;
use Infra\Integration\AnimeApi\DTOs\AnimeData as ApiAnimeData;
use Infra\Integration\AnimeApi\DTOs\Collections\MalCollection;
use Infra\Integration\AnimeApi\DTOs\MalData;

class CreateAnimeGenresAction
{
    public function __construct(private GenreRepository $genreRepository)
    {
    }

    public function run(ApiAnimeData $apiAnime): void
    {
        $apiGenres = collect([
            GenreTypesEnum::COMMON->value => $apiAnime->genres,
            GenreTypesEnum::EXPLICIT->value => $apiAnime->explicit_genres,
            GenreTypesEnum::THEME->value => $apiAnime->themes,
            GenreTypesEnum::DEMOGRAPHIC->value => $apiAnime->demographics,
        ]);

        $malIds = $apiGenres->collapse()->pluck('mal_id')->values();
        $registeredGenresMalIds = $this->getMalIds(
            $this->genreRepository->queryByMalIds($malIds->all())
        );

        $unregisteredGenre = $malIds->diff($registeredGenresMalIds)->all();

        $apiGenres->each(function (?MalCollection $genres, string $type) use ($unregisteredGenre): void {
            $genres?->whereIn('mal_id', $unregisteredGenre)->each(function (MalData $genre) use ($type): void {
                $this->genreRepository->create(
                    GenreData::fromArray([
                        'slug' => Str::slug($genre->name),
                        'name' => $genre->name,
                        'mal_id' => $genre->mal_id,
                        'mal_url' => $genre->url,
                        'type' => GenreTypesEnum::from($type),
                    ])
                );
            });
        });
    }

    private function getMalIds($animes): array
    {
        return collect($animes)->pluck('mal_id')->values()->all() ?? [];
    }
}
