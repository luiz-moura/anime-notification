<?php

namespace Infra\Integration\AnimeApi\DTOs;

use DateTime;
use Infra\Abstracts\DataTransferObject;

class AiredData extends DataTransferObject
{
    public function __construct(
        public ?DateTime $from,
        public ?DateTime $to,
        public ?string $string,
    ) {
    }
}
