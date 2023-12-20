<?php

namespace Domain\Shared\Medias\DTOs\Models;

use Domain\Shared\Medias\DTOs\Mappers\MediasModelMapper;
use Domain\Shared\Medias\DTOs\MediasData;
use Illuminate\Support\Arr;

class MediasModelData extends MediasData
{
	public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(MediasModelMapper::fromArray($data), ['id']),
        );
    }
}
