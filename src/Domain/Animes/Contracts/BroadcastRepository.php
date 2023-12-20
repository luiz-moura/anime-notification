<?php

namespace Domain\Animes\Contracts;

use Domain\Animes\DTOs\BroadcastsData;
use Domain\Animes\DTOs\Models\BroadcastsModelData;

interface BroadcastRepository
{
    public function create(int $animeId, BroadcastsData $title): BroadcastsModelData;
}
