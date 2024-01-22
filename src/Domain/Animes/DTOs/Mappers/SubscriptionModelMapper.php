<?php

namespace Domain\Animes\DTOs\Mappers;

use Domain\Animes\Enums\SubscriptionTypesEnum;

class SubscriptionModelMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'anime_id' => $data['anime_id'],
            'type' => SubscriptionTypesEnum::from($data['type']),
        ];
    }
}
