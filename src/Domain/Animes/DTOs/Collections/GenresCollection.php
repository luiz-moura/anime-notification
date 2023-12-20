<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\GenresData;
use Domain\Animes\DTOs\Models\GenresModelData;
use Infra\Abstracts\Collection;

class GenresCollection extends Collection
{
    protected string $collectionOf = GenresData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn ($item) => GenresModelData::fromModel($item),
                $items
            )
        );
    }
}
