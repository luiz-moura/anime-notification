<?php

namespace Domain\Animes\DTOs\Mappers;

use Domain\Animes\DTOs\TitlesData;
use Domain\Animes\DTOs\BroadcastsData;
use Domain\Animes\DTOs\Collections\TitlesCollection;
use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\GenresData;
use Domain\Animes\Enums\GenreTypesEnum;
use Illuminate\Support\Str;

class AnimesApiMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'mal_id' => $data['mal_id'],
            'mal_url' => $data['url'],
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'approved' => $data['approved'],
            'airing' => $data['airing'],
            'type' => $data['type'] ?? null,
            'source' => $data['source'] ?? null,
            'episodes' => $data['episodes'] ?? null,
            'status' => $data['status'] ?? null,
            'duration' => $data['duration'] ?? null,
            'rating' => $data['rating'] ?? null,
            'synopsis' => $data['synopsis'] ?? null,
            'background' => $data['background'] ?? null,
            'season' => $data['season'] ?? null,
            'year' => $data['year'] ?? null,
            'aired_from' => $data['aired']['from'] ?? null,
            'aired_to' => $data['aired']['to'] ?? null,
            'images' => null,
            'titles' => TitlesCollection::fromArray(
                array_map(fn (array $title) => TitlesData::fromArray([
                    'type' => $title['type'],
                    'title'=> $title['title'],
                ]), $data['titles'])
            ),
            'broadcast' => !empty($data['broadcast']) ? BroadcastsData::fromArray([
                'day' => $data['broadcast']['day'] ?? null,
                'time' => $data['broadcast']['time'] ?? null,
                'timezone' => $data['broadcast']['timezone'] ?? null,
                'date_formatted' => $data['broadcast']['string'] ?? null,
            ]) : null,
            'genres' => GenresCollection::fromArray(
                array_merge(
                    !empty($data['genres'])
                        ? array_map(fn (array $genre) => GenresData::fromArray([
                            'mal_id' => $genre['mal_id'],
                            'mal_url' => $genre['url'],
                            'name' => $genre['name'],
                            'slug' => Str::slug($genre['name']),
                            'type' => GenreTypesEnum::COMMON,
                        ]), $data['genres'])
                        : [],
                    !empty($data['explicit_genres'])
                        ? array_map(fn (array $genre) => GenresData::fromArray([
                            'mal_id' => $genre['mal_id'],
                            'mal_url' => $genre['url'],
                            'name' => $genre['name'],
                            'slug' => Str::slug($genre['name']),
                            'type' => GenreTypesEnum::EXPLICIT,
                        ]), $data['explicit_genres'])
                        : [],
                    !empty($data['themes'])
                        ? array_map(fn (array $genre) => GenresData::fromArray([
                            'mal_id' => $genre['mal_id'],
                            'mal_url' => $genre['url'],
                            'name' => $genre['name'],
                            'slug' => Str::slug($genre['name']),
                            'type' => GenreTypesEnum::THEME,
                        ]), $data['themes'])
                        : [],
                    !empty($data['demographics'])
                        ? array_map(fn (array $genre) => GenresData::fromArray([
                            'mal_id' => $genre['mal_id'],
                            'mal_url' => $genre['url'],
                            'name' => $genre['name'],
                            'slug' => Str::slug($genre['name']),
                            'type' => GenreTypesEnum::DEMOGRAPHIC,
                        ]), $data['demographics'])
                        : [],
                )
            ),
        ];
    }
}
