<?php

namespace Tests\Mocks;

use Domain\Animes\DTOs\Models\GenresModelData;
use Domain\Animes\Enums\GenreTypesEnum;

class GenresModelDataMock
{
    public static function create(array $extra = []): GenresModelData
    {
        return GenresModelData::fromArray($extra + [
            'id' => fake()->randomNumber(),
            'mal_id' => fake()->randomNumber(),
            'mal_url' => fake()->url(),
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'type' => fake()->randomElement(GenreTypesEnum::cases()),
        ] );
    }
}
