<?php

namespace Domain\Animes\DTOs\Collections;

use Domain\Animes\DTOs\MemberData;
use Domain\Animes\DTOs\Models\MemberModelData;
use Infra\Abstracts\Collection;

class MembersCollection extends Collection
{
    protected string $collectionOf = MemberData::class;

    public static function fromModel(array $items): self
    {
        return new static(
            array_map(
                fn ($item): MemberModelData => MemberModelData::fromModel($item),
                $items
            )
        );
    }
}
