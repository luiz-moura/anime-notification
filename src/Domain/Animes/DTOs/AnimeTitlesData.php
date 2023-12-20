<?php

namespace Domain\Animes\DTOs;

use Infra\Abstracts\DataTransferObject;

class AnimeTitlesData extends DataTransferObject
{
	public function __construct(
        public string $type,
	    public string $title,
    ) {}
}
