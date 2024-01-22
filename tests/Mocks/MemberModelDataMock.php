<?php

namespace Tests\Mocks;

use Domain\Animes\DTOs\Collections\NotificationTokensCollection;
use Domain\Animes\DTOs\Models\MemberModelData;
use Domain\Animes\Enums\SubscriptionTypesEnum;

class MemberModelDataMock
{
    public static function create(array $extra = []): MemberModelData
    {
        return MemberModelData::fromArray($extra + [
            'id' => fake()->randomNumber(),
            'name' => fake()->randomNumber(),
            'email' => fake()->randomNumber(),
            'type' => fake()->randomElement(SubscriptionTypesEnum::cases()),
            'notification_tokens' => new NotificationTokensCollection([
                NotificationTokenDataMock::create()
            ]),
        ]);
    }
}
