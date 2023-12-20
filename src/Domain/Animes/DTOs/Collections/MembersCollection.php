<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\MembersData;
use Domain\Animes\DTOs\Models\GenresModelData;
use Infra\Abstracts\Collection;

class MembersCollection extends Collection
{
    protected string $collectionOf = MembersData::class;

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
