<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\TitlesData;
use Domain\Animes\DTOs\Models\TitlesModelData;
use Infra\Abstracts\Collection;

class TitlesCollection extends Collection
{
    protected string $collectionOf = TitlesData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn ($item) => TitlesModelData::fromModel($item),
                $items
            )
        );
    }
}
