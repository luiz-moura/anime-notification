<?php

namespace Tests\Mocks;

use Domain\Animes\DTOs\SubscriptionsData;
use Domain\Animes\Enums\SubscriptionTypesEnum;

class SubscriptionsDataMock
{
    public static function create(array $extra = []): SubscriptionsData
    {
        return SubscriptionsData::fromArray($extra + [
            'anime_id' => fake()->randomNumber(),
            'type' => fake()->randomElement(SubscriptionTypesEnum::cases()),
        ] );
    }
}
