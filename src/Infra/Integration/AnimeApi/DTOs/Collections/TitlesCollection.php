<?php

namespace Infra\Integration\AnimeApi\DTOs\Collections;

use Infra\Abstracts\Collection;
use Infra\Integration\AnimeApi\DTOs\TitlesData;

class TitlesCollection extends Collection
{
    protected string $collectionOf = TitlesData::class;
}
