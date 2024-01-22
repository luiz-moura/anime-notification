<?php

namespace Domain\Animes\Contracts;

use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\GenreData;

interface GenreRepository
{
    public function queryByMalIds(array $ids): GenresCollection;

    public function create(GenreData $genre): void;
}
