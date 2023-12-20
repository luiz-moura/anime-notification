<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\Mappers\MembersModelMapper;
use Domain\Animes\DTOs\MembersData;
use Illuminate\Support\Arr;

class MembersModelData extends MembersData
{
    public function __construct(public int $id, mixed ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(MembersModelMapper::fromArray($data), 'id')
        );
    }
}
