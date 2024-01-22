<?php

namespace Infra\Integration\AnimeApi\DTOs;

use Infra\Abstracts\DataTransferObject;

class ImageData extends DataTransferObject
{
    public function __construct(
        public ?string $image_url,
        public ?string $small_image_url,
        public ?string $large_image_url,
    ) {}
}
