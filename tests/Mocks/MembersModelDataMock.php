<?php

namespace Tests\Mocks;

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
            'fcm_token' => fake()->uuid(),
            'type' => fake()->randomElement(SubscriptionTypesEnum::cases()),
        ] );
    }
}
