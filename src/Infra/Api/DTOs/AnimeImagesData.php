<?php

namespace Infra\Api\DTOs;

use Infra\Abstracts\DataTransferObject;

class AnimeImagesData extends DataTransferObject
{
    public ImagesData $jpg;
    public ImagesData $webp;
}
