<?php

namespace Domain\Shared\Medias\DTOs;

use Infra\Abstracts\DataTransferObject;

class MediasData extends DataTransferObject
{
	public function __construct(
        public string $title,
	    public string $path,
	    public string $mimetype,
        public string $disk,
    ) {}
}
