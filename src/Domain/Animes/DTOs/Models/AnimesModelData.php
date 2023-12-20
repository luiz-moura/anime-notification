<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\AnimesData;
use Domain\Animes\DTOs\Mappers\AnimesModelMapper;
use Illuminate\Support\Arr;

class AnimesModelData extends AnimesData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(AnimesModelMapper::fromArray($data), ['id']),
        );
    }
}
