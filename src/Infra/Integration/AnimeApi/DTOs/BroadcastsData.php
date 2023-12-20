<?php

namespace Infra\Integration\AnimeApi\DTOs;

use Infra\Abstracts\DataTransferObject;

class BroadcastsData extends DataTransferObject
{
	public function __construct(
        public ?string $day,
        public ?string $time,
        public ?string $timezone,
        public ?string $string,
    ) {}
}
