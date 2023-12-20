<?php

namespace Infra\Storage\DTOs;

use Infra\Abstracts\DataTransferObject;

class MediaData extends DataTransferObject
{
    public function __construct(
        public string $path,
        public string $filename,
        public string $extension,
        public string $mimetype
    ) {}
}
