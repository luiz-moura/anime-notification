<?php

namespace Infra\Integration\AnimeApi\DTOs\Collections;

use Infra\Abstracts\Collection;
use Infra\Integration\AnimeApi\DTOs\AnimesData;

class AnimesCollection extends Collection
{
    protected string $collectionOf = AnimesData::class;

    public static function fromApi(array $items): self
    {
        return new self(
            array_map(
                fn ($item) => AnimesData::fromApi($item),
                $items
            )
        );
    }
}
