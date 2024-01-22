<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\Mappers\TitleModelMapper;
use Domain\Animes\DTOs\TitleData;
use Illuminate\Support\Arr;

class TitleModelData extends TitleData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(TitleModelMapper::fromArray($data), ['id']),
        );
    }
}
