<?php

namespace Infra\Api\DTOs;

use DateTime;
use Infra\Abstracts\DataTransferObject;

class AiredData extends DataTransferObject
{
    public function __construct(
        public ?DateTime $from,
        public ?DateTime $to,
        public ?string $date_formatted,
    ) {}
}
