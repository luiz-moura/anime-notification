<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\ImageData;
use Domain\Animes\DTOs\Mappers\ImageModelMappper;
use Illuminate\Support\Arr;

class ImageModelData extends ImageData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(ImageModelMappper::fromArray($data), ['id']),
        );
    }
}
