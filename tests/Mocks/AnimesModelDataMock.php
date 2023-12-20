<?php

namespace Tests\Mocks;

use Domain\Animes\DTOs\Models\AnimesModelData;

class AnimesModelDataMock
{
    public static function create(array $extra = []): AnimesModelData
    {
        return AnimesModelData::fromArray($extra + [
            'id' => fake()->randomNumber(),
            'mal_id' => fake()->randomNumber(),
            'mal_url' => fake()->url(),
            'title' => fake()->title(),
            'slug' => fake()->slug(),
            'approved' => fake()->boolean(),
            'airing' => fake()->boolean(),
            'type' => fake()->slug(),
            'source' => fake()->sentence(),
            'episodes' => fake()->randomNumber(),
            'status' => fake()->word(),
            'duration' => fake()->word(),
            'rating' => fake()->word(),
            'synopsis' => fake()->text(),
            'background' => fake()->text(),
            'season' => fake()->word(),
            'year' => fake()->year(),
            'aired_from' => fake()->dateTime(),
            'aired_to' => fake()->dateTime(),
            'titles' => null,
            'images' => null,
            'broadcast' => null,
            'genres' => null,
        ]);
    }
}
