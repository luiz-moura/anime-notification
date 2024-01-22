<?php

namespace Domain\Animes\DTOs;

use Domain\Animes\Enums\GenreTypesEnum;
use Infra\Abstracts\DataTransferObject;

class GenreData extends DataTransferObject
{
    public function __construct(
        public int $mal_id,
        public string $mal_url,
        public string $name,
        public string $slug,
        public GenreTypesEnum $type,
    ) {
    }
}
