<?php

namespace Domain\Animes\Contracts;

use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\GenresData;

interface GenreRepository
{
    public function queryByMalIds(array $ids): GenresCollection;
    public function create(GenresData $genre): void;
}
