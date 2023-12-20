<?php

namespace Domain\Animes\DTOs\Collections;

use Infra\Abstracts\Collection;
use Infra\Integration\AnimeApi\DTOs\AnimeImagesData;

class AnimeImagesCollection extends Collection
{
    protected string $collectionOf = AnimeImagesData::class;
}
