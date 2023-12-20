<?php

namespace Domain\Animes\DTOs;

use Infra\Abstracts\DataTransferObject;

class BroadcastsData extends DataTransferObject
{
	public function __construct(
        public ?string $day,
        public ?string $time,
        public ?string $timezone,
        public ?string $time_formatted,
    ) {}
}
