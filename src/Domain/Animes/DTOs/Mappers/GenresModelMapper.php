<?php

namespace Domain\Animes\DTOs\Mappers;

use Domain\Animes\Enums\GenreTypesEnum;

class GenresModelMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'id' => $data['id'] ?? null,
            'mal_id' => $data['mal_id'],
            'mal_url' => $data['mal_url'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'type' => GenreTypesEnum::from($data['type']),
        ];
    }
}
