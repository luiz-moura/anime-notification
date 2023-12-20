<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\AnimeTitlesData;
use Infra\Abstracts\Collection;

class AnimeTitlesCollection extends Collection
{
    protected string $collectionOf = AnimeTitlesData::class;
}
