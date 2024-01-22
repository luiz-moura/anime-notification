<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\AnimeData;
use Domain\Animes\DTOs\Mappers\AnimeModelMapper;
use Illuminate\Support\Arr;

class AnimeModelData extends AnimeData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(AnimeModelMapper::fromArray($data), ['id']),
        );
    }
}
