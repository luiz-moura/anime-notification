<?php

namespace Infra\Integration\AnimeApi\DTOs;

use Infra\Abstracts\DataTransferObject;

class AnimeImageData extends DataTransferObject
{
    public function __construct(
        public ImageData $jpg,
        public ImageData $webp,
    ) {}
}
