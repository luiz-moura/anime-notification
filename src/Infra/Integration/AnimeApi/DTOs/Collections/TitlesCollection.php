<?php

namespace Infra\Integration\AnimeApi\DTOs\Collections;

use Infra\Abstracts\Collection;
use Infra\Integration\AnimeApi\DTOs\TitleData;

class TitlesCollection extends Collection
{
    protected string $collectionOf = TitleData::class;
}
