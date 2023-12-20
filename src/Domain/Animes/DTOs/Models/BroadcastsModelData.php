<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\BroadcastsData;
use Domain\Animes\DTOs\Mappers\BroadcastsModelMapper;
use Illuminate\Support\Arr;

class BroadcastsModelData extends BroadcastsData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(BroadcastsModelMapper::fromArray($data), ['id']),
        );
    }
}
