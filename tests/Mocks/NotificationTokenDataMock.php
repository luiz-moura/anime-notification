<?php

namespace Tests\Mocks;

use Domain\Animes\DTOs\NotificationTokenData;

class NotificationTokenDataMock
{
    public static function create(array $extra = []): NotificationTokenData
    {
        return NotificationTokenData::fromArray($extra + [
            'user_id' => fake()->randomNumber(),
            'user_agent' => fake()->randomNumber(),
            'token' => fake()->randomNumber(),
        ]);
    }
}
