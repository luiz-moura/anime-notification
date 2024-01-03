<?php

namespace Tests\Mocks;

use DateTimeInterface;
use Domain\Animes\DTOs\Models\BroadcastsModelData;

class BroadcastsModelDataMock
{
    public static function create(array $extra = []): BroadcastsModelData
    {
        return BroadcastsModelData::fromArray($extra + [
            'id' => fake()->randomNumber(),
            'day' => fake()->dayOfWeek(),
            'time' => fake()->time(),
            'timezone' => fake()->timezone(),
            'date_formatted' => fake()->dateTime()->format(DateTimeInterface::ATOM),
        ]);
    }
}
