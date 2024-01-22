<?php

namespace Tests\Mocks;

use Domain\Animes\DTOs\Models\GenreModelData;
use Domain\Animes\Enums\GenreTypesEnum;

class GenreModelDataMock
{
    public static function create(array $extra = []): GenreModelData
    {
        return GenreModelData::fromArray($extra + [
            'id' => fake()->randomNumber(),
            'mal_id' => fake()->randomNumber(),
            'mal_url' => fake()->url(),
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'type' => fake()->randomElement(GenreTypesEnum::cases()),
        ]);
    }
}
