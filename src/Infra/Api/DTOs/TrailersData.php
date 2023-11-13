<?php

namespace Infra\Api\DTOs;

use Infra\Abstracts\DataTransferObject;

class TrailersData extends DataTransferObject
{
	public function __construct(
        public ?string $youtube_id,
        public ?string $url,
        public ?string $embed_url,
        public ?TrailerImagesData $images,
    ) {}
}
