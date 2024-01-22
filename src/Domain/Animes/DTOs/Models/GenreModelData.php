<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\GenreData;
use Domain\Animes\DTOs\Mappers\GenreModelMapper;
use Illuminate\Support\Arr;

class GenreModelData extends GenreData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(GenreModelMapper::fromArray($data), ['id']),
        );
    }
}
