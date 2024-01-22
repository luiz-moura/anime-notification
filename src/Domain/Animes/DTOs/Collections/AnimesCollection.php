<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\AnimeData;
use Domain\Animes\DTOs\Models\AnimeModelData;
use Infra\Abstracts\Collection;

class AnimesCollection extends Collection
{
    protected string $collectionOf = AnimeData::class;

    public static function fromApi(array $items): self
    {
        return new static(
            array_map(
                fn ($item) => AnimeData::fromApi($item),
                $items
            )
        );
    }

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn ($item) => AnimeModelData::fromModel($item),
                $items
            )
        );
    }
}
