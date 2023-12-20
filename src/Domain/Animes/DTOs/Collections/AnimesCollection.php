<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\AnimesData;
use Domain\Animes\DTOs\Models\AnimesModelData;
use Infra\Abstracts\Collection;

class AnimesCollection extends Collection
{
    protected string $collectionOf = AnimesData::class;

    public static function fromApi(array $items): AnimesCollection
    {
        return new static(
            array_map(
                fn ($item) => AnimesData::fromApi($item),
                $items
            )
        );
    }

    public static function fromModel(array $items): AnimesCollection
    {
        return new static(
            array_map(
                fn ($item) => AnimesModelData::fromModel($item),
                $items
            )
        );
    }
}
