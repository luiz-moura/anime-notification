<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\AnimeTitlesData;
use Domain\Animes\DTOs\Models\AnimeTitlesModelData;
use Infra\Abstracts\Collection;

class AnimeTitlesCollection extends Collection
{
    protected string $collectionOf = AnimeTitlesData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn ($item) => AnimeTitlesModelData::fromModel($item),
                $items
            )
        );
    }
}
