<?php

namespace Infra\Api\DTOs\Mappers;

use DateTime;
use Infra\Api\DTOs\AiredData;
use Infra\Api\DTOs\BroadcastsData;
use Infra\Api\DTOs\Collections\AnimeImagesCollection;
use Infra\Api\DTOs\Collections\MalCollection;
use Infra\Api\DTOs\Collections\TitlesCollection;
use Infra\Api\DTOs\ImagesData;
use Infra\Api\DTOs\MalData;
use Infra\Api\DTOs\TitlesData;
use Infra\Api\DTOs\TrailerImagesData;
use Infra\Api\DTOs\TrailersData;

class AnimesMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'mal_id' => $data['mal_id'],
            'url' => $data['url'],
            'title' => $data['title'],
            'approved' => $data['approved'],
            'airing' => $data['airing'],
            'type' => $data['type'] ?? null,
            'source' => $data['source'] ?? null,
            'episodes' => $data['episodes'] ?? null,
            'status' => $data['status'] ?? null,
            'duration' => $data['duration'] ?? null,
            'rating' => $data['rating'] ?? null,
            'score' => $data['score'] ?? null,
            'scored_by' => $data['scored_by'] ?? null,
            'rank' => $data['rank'] ?? null,
            'popularity' => $data['popularity'] ?? null,
            'members' => $data['members'] ?? null,
            'favorites' => $data['favorites'] ?? null,
            'synopsis' => $data['synopsis'] ?? null,
            'background' => $data['background'] ?? null,
            'season' => $data['season'] ?? null,
            'year' => $data['year'] ?? null,
            'titles' => TitlesCollection::fromArray(
                array_map(fn ($title) => TitlesData::from([
                    'type'=> $title['type'],
                    'title'=> $title['title'],
                ]), $data['titles'])
            ),
            'images' => AnimeImagesCollection::fromArray(
                array_map(fn ($image) => ImagesData::from([
                    'image_url'=> $image['image_url'],
                    'small_image_url'=> $image['small_image_url'],
                    'large_image_url'=> $image['large_image_url'],
                ]), $data['images'])
            ),
            'aired' => AiredData::from([
                'from' => !empty($data['aired']['from']) ? new DateTime($data['aired']['from']) : null,
                'to' => !empty($data['aired']['to']) ? new DateTime($data['aired']['to']) : null,
                'date_formatted' => $data['aired']['string'] ?? null,
            ]),
            'broadcast' => !empty($data['broadcast'])
                ? BroadcastsData::from([
                    'day' => $data['broadcast']['day'],
                    'time' => $data['broadcast']['time'],
                    'timezone' => $data['broadcast']['timezone'],
                    'date_formatted' => $data['broadcast']['string']
                ]) : null,
            'trailer' => !empty($data['trailer'])
                ? TrailersData::from([
                    'youtube_id' => $data['trailer']['youtube_id'],
                    'url' => $data['trailer']['url'],
                    'embed_url' => $data['trailer']['embed_url'],
                    'images' => TrailerImagesData::from([
                        'image_url'=> $data['trailer']['images']['image_url'],
                        'small_image_url'=> $data['trailer']['images']['small_image_url'],
                        'medium_image_url'=> $data['trailer']['images']['medium_image_url'],
                        'large_image_url'=> $data['trailer']['images']['large_image_url'],
                        'maximum_image_url'=> $data['trailer']['images']['maximum_image_url'],
                    ])
                ]) : null,
            'genres' => !empty($data['genres'])
                ? MalCollection::fromArray(
                    array_map(fn ($genre) => MalData::from([
                        'mal_id' => $genre['mal_id'],
                        'type'=> $genre['type'],
                        'name'=> $genre['name'],
                        'url'=> $genre['url'],
                    ]), $data['genres'])
                ) : null,
            'explicit_genres' => !empty($data['explicit_genres'])
                ? MalCollection::fromArray(
                    array_map(fn ($genre) => MalData::from([
                        'mal_id' => $genre['mal_id'],
                        'type'=> $genre['type'],
                        'name'=> $genre['name'],
                        'url'=> $genre['url'],
                    ]), $data['explicit_genres'])
                ) : null,
            'themes' => !empty($data['themes'])
                ? MalCollection::fromArray(
                    array_map(fn ($genre) => MalData::from([
                        'mal_id' => $genre['mal_id'],
                        'type'=> $genre['type'],
                        'name'=> $genre['name'],
                        'url'=> $genre['url'],
                    ]), $data['themes'])
                ) : null,
            'demographics' => !empty($data['demographics'])
                ? MalCollection::fromArray(
                    array_map(fn ($genre) => MalData::from([
                        'mal_id' => $genre['mal_id'],
                        'type'=> $genre['type'],
                        'name'=> $genre['name'],
                        'url'=> $genre['url'],
                    ]), $data['demographics'])
                ) : null,
            'producers' => !empty($data['producers'])
                ? MalCollection::fromArray(
                    array_map(fn ($genre) => MalData::from([
                        'mal_id' => $genre['mal_id'],
                        'type'=> $genre['type'],
                        'name'=> $genre['name'],
                        'url'=> $genre['url'],
                    ]), $data['producers'])
                ) : null,
            'licensors' => !empty($data['licensors'])
                ? MalCollection::fromArray(
                    array_map(fn ($genre) => MalData::from([
                        'mal_id' => $genre['mal_id'],
                        'type'=> $genre['type'],
                        'name'=> $genre['name'],
                        'url'=> $genre['url'],
                    ]), $data['licensors'])
                ) : null,
            'studios' => !empty($data['studios'])
                ? MalCollection::fromArray(
                    array_map(fn ($genre) => MalData::from([
                        'mal_id' => $genre['mal_id'],
                        'type'=> $genre['type'],
                        'name'=> $genre['name'],
                        'url'=> $genre['url'],
                    ]), $data['studios'])
                ) : null,
        ];
    }
}
