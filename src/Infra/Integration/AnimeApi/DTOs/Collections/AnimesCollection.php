<?php

namespace Infra\Integration\AnimeApi\DTOs\Collections;

use Infra\Abstracts\Collection;
use Infra\Integration\AnimeApi\DTOs\AnimeData;

class AnimesCollection extends Collection
{
    protected string $collectionOf = AnimeData::class;

    public static function fromApi(array $items): self
    {
        return new self(
            array_map(
                fn ($item): AnimeData => AnimeData::fromApi($item),
                $items
            )
        );
    }
}
