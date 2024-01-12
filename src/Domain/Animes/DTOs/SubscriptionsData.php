<?php

namespace Domain\Animes\DTOs;

use Domain\Animes\DTOs\Mappers\SubscriptionsModelMapper;
use Domain\Animes\Enums\SubscriptionTypesEnum;
use Infra\Abstracts\DataTransferObject;

class SubscriptionsData extends DataTransferObject
{
    public function __construct(
        public int $anime_id,
        public SubscriptionTypesEnum $type,
    ) {}

    public static function fromModel(array $data): self
    {
        return self::fromArray(
            SubscriptionsModelMapper::fromArray($data)
        );
    }
}
