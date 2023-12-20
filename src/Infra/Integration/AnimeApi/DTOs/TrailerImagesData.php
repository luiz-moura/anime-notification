<?php

namespace Infra\Integration\AnimeApi\DTOs;

use Infra\Abstracts\DataTransferObject;

class TrailerImagesData extends DataTransferObject
{
	public function __construct(
        public ?string $image_url,
        public ?string $small_image_url,
        public ?string $medium_image_url,
        public ?string $large_image_url,
        public ?string $maximum_image_url,
    ) {}
}
