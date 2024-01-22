<?php

namespace Domain\Animes\Contracts;

use Domain\Animes\DTOs\TitleData;

interface AnimeTitleRepository
{
    public function create(int $animeId, TitleData $title): void;
}
