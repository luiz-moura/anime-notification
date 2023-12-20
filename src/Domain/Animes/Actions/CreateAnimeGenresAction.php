<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\GenreRepository;
use Domain\Animes\Enums\GenreTypesEnum;
use Domain\Animes\DTOs\GenresData;
use Infra\Integration\AnimeApi\DTOs\AnimesData as ApiAnimesData;
use Illuminate\Support\Str;

class CreateAnimeGenresAction
{
    public function __construct(private GenreRepository $genreRepository) {}

    public function run(ApiAnimesData $apiAnime): void
    {
        $apiGenres = collect([
            GenreTypesEnum::COMMON->value => $apiAnime->genres,
            GenreTypesEnum::EXPLICIT->value => $apiAnime->explicit_genres,
            GenreTypesEnum::THEME->value => $apiAnime->themes,
            GenreTypesEnum::DEMOGRAPHIC->value => $apiAnime->demographics
        ]);

        $malIds = $apiGenres->collapse()->pluck('mal_id')->values();
        $registeredGenresMalIds = $this->getMalIds(
            $this->genreRepository->queryByMalIds($malIds->all())
        );

        $unregisteredGenre = $malIds->diff($registeredGenresMalIds)->all();

        $apiGenres->each(function ($genres, $type) use ($unregisteredGenre) {
            $genres?->whereIn('mal_id', $unregisteredGenre)->each(function ($genre) use ($type) {
                $this->genreRepository->create(
                    GenresData::fromArray([
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
