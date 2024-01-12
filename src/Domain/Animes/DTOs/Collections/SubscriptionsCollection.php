<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\SubscriptionsData;
use Infra\Abstracts\Collection;

class SubscriptionsCollection extends Collection
{
    protected string $collectionOf = SubscriptionsData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn ($item) => SubscriptionsData::fromModel($item),
                $items
            )
        );
    }
}