<?php

namespace Domain\Animes\Contracts;

use Domain\Animes\DTOs\BroadcastData;
use Domain\Animes\DTOs\Models\BroadcastModelData;

interface BroadcastRepository
{
    public function create(int $animeId, BroadcastData $title): BroadcastModelData;
}
