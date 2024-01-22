<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\BroadcastData;
use Domain\Animes\DTOs\Mappers\BroadcastModelMapper;
use Illuminate\Support\Arr;

class BroadcastModelData extends BroadcastData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(BroadcastModelMapper::fromArray($data), ['id']),
        );
    }
}
