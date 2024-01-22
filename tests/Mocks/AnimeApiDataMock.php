<?php

namespace Tests\Mocks;

class AnimeApiDataMock
{
    public static function create(): array
    {
        return [
            'mal_id' => fake()->randomNumber(),
            'url' => fake()->url(),
            'title' => fake()->title(),
            'approved' => fake()->boolean(),
            'airing' => fake()->boolean(),
            'type' => fake()->slug(),
            'source' => fake()->sentence(),
            'episodes' => fake()->randomNumber(),
            'status' => fake()->word(),
            'duration' => fake()->word(),
            'rating' => fake()->word(),
            'score' => fake()->randomNumber(),
            'scored_by' => fake()->randomNumber(),
            'rank' => fake()->randomNumber(),
            'popularity' => fake()->randomNumber(),
            'members' => fake()->randomNumber(),
            'favorites' => fake()->randomNumber(),
            'synopsis' => fake()->text(),
            'background' => fake()->text(),
            'season' => fake()->word(),
            'year' => fake()->year(),
            'titles' => [
                [
                    'title' => fake()->title(),
                    'type' => fake()->word(),
                ],
            ],
            'images' => [
                'jpg' => [
                    'image_url' => fake()->url() . '.' . fake()->fileExtension(),
                    'small_image_url' => fake()->url() . '.' . fake()->fileExtension(),
                    'large_image_url' => fake()->url() . '.' . fake()->fileExtension(),
                ],
                'webp' => [
                    'image_url' => fake()->url() . '.' . fake()->fileExtension(),
                    'small_image_url' => fake()->url() . '.' . fake()->fileExtension(),
                    'large_image_url' => fake()->url() . '.' . fake()->fileExtension(),
                ],
            ],
            'aired' => [
                'from' => fake()->dateTime()->format('Y-m-d'),
                'to' => fake()->dateTime()->format('Y-m-d'),
                'string' => fake()->dateTime()->format('Y-m-d'),
            ],
            'trailer' => null,
            'broadcast' => [
                'day' => fake()->dayOfWeek(),
                'time' => fake()->time(),
                'timezone' => fake()->timezone(),
                'string' => fake()->dateTime()->format('Y-m-d'),
            ],
            'genres' => [
                [
                    'mal_id' => fake()->randomNumber(),
                    'type' => fake()->slug(),
                    'name' => fake()->name(),
                    'url' => fake()->url(),
                ],
            ],
            'explicit_genres' => [
                [
                    'mal_id' => fake()->randomNumber(),
                    'type' => fake()->slug(),
                    'name' => fake()->name(),
                    'url' => fake()->url(),
                ],
            ],
            'themes' => [
                [
                    'mal_id' => fake()->randomNumber(),
                    'type' => fake()->slug(),
                    'name' => fake()->name(),
                    'url' => fake()->url(),
                ],
            ],
            'demographics' => [
                [
                    'mal_id' => fake()->randomNumber(),
                    'type' => fake()->slug(),
                    'name' => fake()->name(),
                    'url' => fake()->url(),
                ],
            ],
            'producers' => null,
            'licensors' => null,
            'studios' => null,
        ];
    }
}
