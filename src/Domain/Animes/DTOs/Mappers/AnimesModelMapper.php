<?php

namespace Domain\Animes\DTOs\Mappers;

use Domain\Animes\DTOs\ImagesData;
use Domain\Animes\DTOs\AnimeTitlesData;
use Domain\Animes\DTOs\BroadcastsData;
use Domain\Animes\DTOs\Collections\AnimeImagesCollection;
use Domain\Animes\DTOs\Collections\AnimeTitlesCollection;
use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\GenresData;
use Domain\Animes\Enums\GenreTypesEnum;

class AnimesModelMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'id' => $data['id'],
            'mal_id' => $data['mal_id'],
            'mal_url' => $data['mal_url'],
            'title' => $data['slug'],
            'slug' => $data['slug'],
            'approved' => $data['approved'] ?? true,
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
            'titles' => !empty($data['images'])
                ? AnimeTitlesCollection::fromArray(
                    array_map(fn (array $title) => AnimeTitlesData::fromArray([
                        'id' => $title['id'],
                        'type' => $title['type'],
                        'title'=> $title['title'],
                    ]), $data['titles'])
                ): null,
            'images' => !empty($data['images'])
                ? AnimeImagesCollection::fromArray(
                    array_map(fn (array $imagem) => ImagesData::fromArray([
                        'id' => $imagem['id'],
                        'title' => $imagem['title'],
                        'path' => $imagem['path'],
                        'mimetype' => $imagem['mimetype'],
                    ]), $data['images'])
                ) : null,
            'broadcast' => !empty($data['broadcast'])
                ? BroadcastsData::fromArray([
                    'id' => $data['broadcast']['id'] ?? null,
                    'day' => $data['broadcast']['day'] ?? null,
                    'time' => $data['broadcast']['time'] ?? null,
                    'timezone' => $data['broadcast']['timezone'] ?? null,
                    'date_formatted' => $data['broadcast']['string'] ?? null,
                ]) : null,
            'genres' => !empty($data['genres'])
                ? GenresCollection::fromArray(
                    array_map(fn (array $genre) => GenresData::fromArray([
                        'id' => $genre['id'],
                        'mal_id' => $genre['mal_id'],
                        'mal_url' => $genre['mal_url'],
                        'name' => $genre['name'],
                        'slug' => $genre['slug'],
                        'type' => GenreTypesEnum::from($genre['type']),
                    ]), $data['genres'])
                ) : null
        ];
    }
}
