<?php

namespace Infra\Integration\AnimeApi\DTOs;

use Infra\Abstracts\DataTransferObject;

class TrailerData extends DataTransferObject
{
    public function __construct(
        public ?string $youtube_id,
        public ?string $url,
        public ?string $embed_url,
        public ?TrailerImageData $images,
    ) {
    }
}
