<?php

namespace Domain\Animes\Contracts;

use Domain\Animes\DTOs\AnimeTitlesData;

interface AnimeTitleRepository
{
    public function create(int $animeId, AnimeTitlesData $title): void;
}
