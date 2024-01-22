<?php

namespace Tests\Mocks;

use Domain\Animes\DTOs\SubscriptionData;
use Domain\Animes\Enums\SubscriptionTypesEnum;

class SubscriptionDataMock
{
    public static function create(array $extra = []): SubscriptionData
    {
        return SubscriptionData::fromArray($extra + [
            'anime_id' => fake()->randomNumber(),
            'type' => fake()->randomElement(SubscriptionTypesEnum::cases()),
        ]);
    }
}
