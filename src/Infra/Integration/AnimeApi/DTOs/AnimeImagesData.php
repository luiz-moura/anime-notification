<?php

namespace Infra\Integration\AnimeApi\DTOs;

use Infra\Abstracts\DataTransferObject;

class AnimeImagesData extends DataTransferObject
{
    public function __construct(
        public ImagesData $jpg,
        public ImagesData $webp,
    ) {}
}
