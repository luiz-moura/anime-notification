<?php

namespace Infra\Integration\AnimeApi\DTOs;

use Infra\Abstracts\DataTransferObject;

class MalData extends DataTransferObject
{
    public function __construct(
        public int $mal_id,
        public string $type,
        public string $name,
        public string $url,
    ) {
    }
}
