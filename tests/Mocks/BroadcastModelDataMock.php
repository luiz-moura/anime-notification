<?php

namespace Tests\Mocks;

use DateTimeInterface;
use Domain\Animes\DTOs\Models\BroadcastModelData;

class BroadcastModelDataMock
{
    public static function create(array $extra = []): BroadcastModelData
    {
        return BroadcastModelData::fromArray($extra + [
            'id' => fake()->randomNumber(),
            'day' => fake()->dayOfWeek(),
            'time' => fake()->time(),
            'timezone' => fake()->timezone(),
            'date_formatted' => fake()->dateTime()->format(DateTimeInterface::ATOM),
        ]);
    }
}
