<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\GenresData;
use Domain\Animes\DTOs\Mappers\GenresModelMapper;
use Illuminate\Support\Arr;

class GenresModelData extends GenresData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(GenresModelMapper::fromArray($data), ['id']),
        );
    }
}
