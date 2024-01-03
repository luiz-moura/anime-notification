<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\Models\AnimeImagesModelData;
use Infra\Abstracts\Collection;
use Infra\Integration\AnimeApi\DTOs\AnimeImagesData;

class AnimeImagesCollection extends Collection
{
    protected string $collectionOf = AnimeImagesData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn ($item) => AnimeImagesModelData::fromModel($item),
                $items
            )
        );
    }
}
