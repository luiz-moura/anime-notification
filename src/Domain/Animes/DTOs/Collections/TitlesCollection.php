<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\Models\TitleModelData;
use Domain\Animes\DTOs\TitleData;
use Infra\Abstracts\Collection;

class TitlesCollection extends Collection
{
    protected string $collectionOf = TitleData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn ($item): TitleModelData => TitleModelData::fromModel($item),
                $items
            )
        );
    }
}
