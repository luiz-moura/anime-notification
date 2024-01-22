<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\GenreData;
use Domain\Animes\DTOs\Models\GenreModelData;
use Infra\Abstracts\Collection;

class GenresCollection extends Collection
{
    protected string $collectionOf = GenreData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn ($item) => GenreModelData::fromModel($item),
                $items
            )
        );
    }
}
