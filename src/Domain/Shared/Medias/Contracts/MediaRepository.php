<?php

namespace Domain\Shared\Medias\Contracts;

use Domain\Shared\Medias\DTOs\MediasData;
use Domain\Shared\Medias\DTOs\Models\MediasModelData;

interface MediaRepository
{
    public function create(MediasData $image): MediasModelData;
}
