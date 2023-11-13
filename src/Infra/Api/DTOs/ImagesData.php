<?php

namespace Infra\Api\DTOs;

use Infra\Abstracts\DataTransferObject;

class ImagesData extends DataTransferObject
{
	public function __construct(
        public ?string $image_url,
        public ?string $small_image_url,
        public ?string $large_image_url,
    ) {}
}
