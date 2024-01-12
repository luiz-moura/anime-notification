<?php

namespace Domain\Animes\DTOs\Mappers;

use Domain\Animes\DTOs\Collections\ImagesCollection;
use Domain\Animes\DTOs\Collections\TitlesCollection;
use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\Models\BroadcastsModelData;

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
            'titles' => !empty($data['titles'])
                ? TitlesCollection::fromModel($data['titles'])
                : null,
            'images' => !empty($data['images'])
                ? ImagesCollection::fromModel($data['images'])
                : null,
            'broadcast' => !empty($data['broadcast'])
                ? BroadcastsModelData::fromModel($data['broadcast'])
                : null,
            'genres' => !empty($data['genres'])
                ? GenresCollection::fromModel($data['genres'])
                : null
        ];
    }
}
