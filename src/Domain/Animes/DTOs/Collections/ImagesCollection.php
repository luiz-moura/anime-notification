<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\ImagesData;
use Domain\Animes\DTOs\Models\ImagesModelData;
use Infra\Abstracts\Collection;

class ImagesCollection extends Collection
{
    protected string $collectionOf = ImagesData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn ($item) => ImagesModelData::fromModel($item),
                $items
            )
        );
    }
}
