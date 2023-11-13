<?php

namespace Infra\Api\DTOs\Collections;

use Infra\Abstracts\Collection;
use Infra\Api\DTOs\AnimesData;

class AnimesCollection extends Collection
{
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
