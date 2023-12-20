<?php

namespace Infra\Integration\AnimeApi\DTOs\Collections;

use Infra\Abstracts\Collection;
use Infra\Integration\AnimeApi\DTOs\MalData;

class MalCollection extends Collection
{
    protected string $collectionOf = MalData::class;
}
