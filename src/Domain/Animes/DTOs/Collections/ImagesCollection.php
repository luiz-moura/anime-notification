<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\ImageData;
use Domain\Animes\DTOs\Models\ImageModelData;
use Infra\Abstracts\Collection;

class ImagesCollection extends Collection
{
    protected string $collectionOf = ImageData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn($item) => ImageModelData::fromModel($item),
                $items
            )
        );
    }
}
