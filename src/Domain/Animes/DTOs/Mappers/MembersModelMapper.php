<?php

namespace Domain\Animes\DTOs\Mappers;

use Domain\Animes\DTOs\Collections\NotificationTokenCollection;
use Domain\Animes\Enums\SubscriptionTypesEnum;

class MembersModelMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'id' => $data['id'] ?? null,
            'name' => $data['name'],
            'email' => $data['email'],
            'type' => SubscriptionTypesEnum::from($data['animes'][0]['subscription']['type']),
            'notification_tokens' => NotificationTokenCollection::fromModel($data['fcm_tokens']),
        ];
    }
}
