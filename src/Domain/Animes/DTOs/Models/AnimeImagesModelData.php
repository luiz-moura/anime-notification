<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\ImagesData;
use Domain\Animes\DTOs\Mappers\AnimeImagesMappper;
use Illuminate\Support\Arr;

class AnimeImagesModelData extends ImagesData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(AnimeImagesMappper::fromArray($data), ['id']),
        );
    }
}
