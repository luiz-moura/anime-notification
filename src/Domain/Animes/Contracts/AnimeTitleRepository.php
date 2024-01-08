<?php

namespace Domain\Animes\Contracts;

use Domain\Animes\DTOs\TitlesData;

interface AnimeTitleRepository
{
    public function create(int $animeId, TitlesData $title): void;
}
