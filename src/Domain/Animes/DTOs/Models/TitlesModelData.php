<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\TitlesData;
use Domain\Animes\DTOs\Mappers\TitlesMapper;
use Domain\Animes\DTOs\Mappers\TitlesModelMapper;
use Illuminate\Support\Arr;

class TitlesModelData extends TitlesData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(TitlesModelMapper::fromArray($data), ['id']),
        );
    }
}
