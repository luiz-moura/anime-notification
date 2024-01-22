<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\SubscriptionData;
use Infra\Abstracts\Collection;

class SubscriptionsCollection extends Collection
{
    protected string $collectionOf = SubscriptionData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn($item) => SubscriptionData::fromModel($item),
                $items
            )
        );
    }
}
