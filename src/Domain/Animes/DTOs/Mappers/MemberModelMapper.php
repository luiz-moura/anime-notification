<?php

namespace Domain\Animes\DTOs\Mappers;

use Domain\Animes\DTOs\Collections\NotificationTokensCollection;
use Domain\Animes\Enums\SubscriptionTypesEnum;

class MemberModelMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'id' => $data['id'] ?? null,
            'name' => $data['name'],
            'email' => $data['email'],
            'type' => SubscriptionTypesEnum::from($data['animes'][0]['subscription']['type']),
            'notification_tokens' => NotificationTokensCollection::fromModel($data['fcm_tokens']),
        ];
    }
}
