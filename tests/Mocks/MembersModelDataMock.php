<?php

namespace Tests\Mocks;

use Domain\Animes\DTOs\Collections\NotificationTokenCollection;
use Domain\Animes\DTOs\Models\MembersModelData;
use Domain\Animes\Enums\SubscriptionTypesEnum;

class MembersModelDataMock
{
    public static function create(array $extra = []): MembersModelData
    {
        return MembersModelData::fromArray($extra + [
            'id' => fake()->randomNumber(),
            'name' => fake()->randomNumber(),
            'email' => fake()->randomNumber(),
            'type' => fake()->randomElement(SubscriptionTypesEnum::cases()),
            'notification_tokens' => new NotificationTokenCollection([
                NotificationTokenDataMock::create()
            ]),
        ]);
    }
}
