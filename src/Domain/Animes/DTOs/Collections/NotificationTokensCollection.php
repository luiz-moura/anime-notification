<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\NotificationTokenData;
use Infra\Abstracts\Collection;

class NotificationTokensCollection extends Collection
{
    protected string $collectionOf = NotificationTokenData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn($item) => NotificationTokenData::fromModel($item),
                $items
            )
        );
    }
}
