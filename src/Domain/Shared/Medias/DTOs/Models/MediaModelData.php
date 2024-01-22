<?php

namespace Domain\Shared\Medias\DTOs\Models;

use Domain\Shared\Medias\DTOs\Mappers\MediaModelMapper;
use Domain\Shared\Medias\DTOs\MediaData;
use Illuminate\Support\Arr;

class MediaModelData extends MediaData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(MediaModelMapper::fromArray($data), ['id']),
        );
    }
}
