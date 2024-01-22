<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\Mappers\MemberModelMapper;
use Domain\Animes\DTOs\MemberData;
use Illuminate\Support\Arr;

class MemberModelData extends MemberData
{
    public function __construct(public int $id, mixed ...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(array $data): self
    {
        return new self(
            $data['id'],
            ...Arr::except(MemberModelMapper::fromArray($data), 'id')
        );
    }
}
