<?php

namespace Domain\Shared\Medias\Contracts;

use Domain\Shared\Medias\DTOs\MediaData;
use Domain\Shared\Medias\DTOs\Models\MediaModelData;

interface MediaRepository
{
    public function create(MediaData $image): MediaModelData;
}
