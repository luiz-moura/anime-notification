<?php

namespace Domain\Animes\DTOs\Mappers;

use Domain\Animes\Enums\SubscriptionTypesEnum;

class MembersModelMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'id' => $data['id'] ?? null,
            'name' => $data['name'],
            'email' => $data['email'],
            'fcm_token' => $data['fcm_token'] ?? null,
            'type' => SubscriptionTypesEnum::from($data['animes'][0]['subscription']['type']),
        ];
    }
}
